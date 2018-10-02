<?php

namespace common\services;

use modules\hierarchicalStructure\controllers\backend\FundsController;
use Yii;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\HsTreeNode;
use modules\hierarchicalStructure\models\HsFinalDestination;
use modules\hierarchicalStructure\models\UploadForm;
use moonland\phpexcel\Excel;
use yii\web\UploadedFile;
use XMLReader;

/**
 * Class HierarchicalStructure
 * @package common\services
 */
class TreeNodeService
{
    public $fullPath;

    public static $parentNodesCache = null;
    public static $parentNodesCacheKey = null;

    public static $chunkRows = 10;

    public $fieldsMap = [
        'id' => 'id',
        'code' => 'code',
        'title' => 'title',
        'term' => 'term',
        'finalDestination' => 'final_destination',
        'description' => 'description',
        'notesForUse' => 'notes_for_use',
        'notesForExclusion' => 'notes_for_exclusion',
    ];
    public $fieldMapCSV = [
        'code' => 'CODE',
        'title' => 'TITLE',
        'term' => 'TERM OF ADMINISTRATIVE CONSERVATION',
        'final_destination' => 'FINAL DESTINATION',
        'description' => 'DESCRIPTION',
        'notes_for_use' => 'NOTES FOR USE',
        'notes_for_exclusion' => 'NOTES FOR EXCLUSION',
    ];

    public $fieldsSortOrder;

    public function __construct()
    {
        $this->fieldsSortOrder = [
            $this->fieldsMap['code'] => 0,
            $this->fieldsMap['title'] => 1,
            $this->fieldsMap['term'] => 2,
            $this->fieldsMap['finalDestination'] => 3,
            $this->fieldsMap['description'] => 4,
            $this->fieldsMap['notesForUse'] => 5,
            $this->fieldsMap['notesForExclusion'] => 6,
            $this->fieldsMap['id'] => 7,
        ];
    }

    /**
     * @return HsTreeNode
     */
    public function getHsTreeNodeModel()
    {
        return new HsTreeNode();
    }

    /**
     * @return KartikTreeNode
     */
    public function getKartikTreeNodeModel()
    {
        return new KartikTreeNode();
    }

    /**
     * @param KartikTreeNode[] $nodes
     * @return array
     */
    public function getExistingNodesWithCodePathKey(array $nodes)
    {
        $oldNodes = [];

        /** @var KartikTreeNode $node */
        foreach ($nodes as $node) {
            $codePath = $node->getCodePath();
            $oldNodes[$codePath] = [
                $this->fieldsMap['id'] => $node->id
            ];
        }
        unset($nodes);

        return $oldNodes;
    }

    /**
     * @param int $hsId
     * @param string $sortConditions
     * @return KartikTreeNode[]
     */
    public function getNodesByHsIdWithSortConditions($hsId, $sortConditions)
    {
        return KartikTreeNode::find()
            ->joinWith('hsTreeNode')
            ->where([
                'hs_tree_id' => (int) $hsId,
                'type' => FundsController::NODE_TYPE
            ])
            ->orderBy($sortConditions)
            ->all();
    }

    /**
     * @param array $importData
     * @param KartikTreeNode[] $nodesFromDB
     * @return array
     */
    public function getNewNodesFromExcel(array $importData, $nodesFromDB)
    {
        $existingNodesData = $this->getExistingNodesWithCodePathKey($nodesFromDB);
        return array_diff_key($importData, $existingNodesData);
    }

    /**
     * @param array $importData
     * @param KartikTreeNode[] $nodesFromDB
     * @return array
     */
    public function getNodesToUpdateFromExcel(array $importData, $nodesFromDB)
    {
        $existingNodesData = $this->getExistingNodesWithCodePathKey($nodesFromDB);

        $newSimilarNodes = array_intersect_key($importData, $existingNodesData);
        $existingSimilarNodes = array_intersect_key($existingNodesData, $importData);

        return array_replace_recursive($existingSimilarNodes, $newSimilarNodes);
    }

    /**
     * @param array $importData
     * @param string $fileName
     * @param string $nameFlag
     * @return bool|string
     */
    public function saveDataToCSV($importData, $fileName, $nameFlag)
    {
        $csvFilePath = Yii::getAlias(UploadForm::DIR_PATH . $fileName . '-' . $nameFlag . '.csv');
        $csvFile = fopen($csvFilePath, 'w');

        foreach ($importData as $node) {
            $nodesWithLowerKeys = array_change_key_case($node);
            uksort($nodesWithLowerKeys, [$this, 'fieldsSort']);
            fputcsv($csvFile, $nodesWithLowerKeys, ';');
        }

        fclose($csvFile);
        return $csvFilePath;
    }

    /**
     * @param  array $excelData
     * @return array
     */
    public function getExcelDataToImportWithCodePathKey(array $excelData)
    {
        $importData = [];

        foreach ($excelData as $nodes => $nodeData) {
            if (!is_array($nodeData)) {
                continue;
            }
            $nodeData = $this->changeKeyCVS($nodeData);
            foreach ($nodeData as $attribute => $value) {
                if (strtolower($attribute) === $this->fieldsMap['code']) {
                    $importData[(string) $value] = $nodeData;
                }
            }
        }

        return $importData;
    }

    /**
     * @param array $nodeData
     * @return array
     */
    public function changeKeyCVS($nodeData)
    {
        foreach ($nodeData as $k => $val) {
            if (array_search($k, $this->fieldMapCSV)) {
                unset($nodeData[$k]);
                $nodeData[array_search($k, $this->fieldMapCSV)] = $val;
            } elseif ($k == '') {
                unset($nodeData[$k]);
            } else {
                continue;
            }
        }
        return $nodeData;
    }
    public function fieldsSort($a, $b)
    {
        return (isset($this->fieldsSortOrder[$a]) ? $this->fieldsSortOrder[$a] : -1) > (isset($this->fieldsSortOrder[$b]) ? $this->fieldsSortOrder[$b] : 1) ? 1 : -1;
    }

    /**
     * @param array $nodesFromDB
     * @return array
     */
    public function addDataToXmlStructure(array $nodesFromDB)
    {
        $data = [];

        while (($node = array_shift($nodesFromDB))) {
            $data[] = [
                'tag' => 'row',
                'elements' => [
                    [
                        'tag' => 'field',
                        'attributes' => [
                            'name' => $this->fieldsMap['code'],
                        ],
                        'content' => $node->getCodePath(),
                    ],
                    [
                        'tag' => 'field',
                        'attributes' => [
                            'name' => $this->fieldsMap['title'],
                        ],
                        'content' => $node->name,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' => [
                            'name' => $this->fieldsMap['term'],
                        ],
                        'content' => !empty($node->hsTreeNode->conservation_term) ?
                            $node->hsTreeNode->conservation_term : '',
                    ],
                    [
                        'tag' => 'field',
                        'attributes' => [
                            'name' => $this->fieldsMap['finalDestination'],
                        ],
                        'content' => !empty($node->hsTreeNode->finalDestination->abbreviation) ?
                            $node->hsTreeNode->finalDestination->abbreviation : '',
                    ],
                    [
                        'tag' => 'field',
                        'attributes' => [
                            'name' => $this->fieldsMap['description'],
                        ],
                        'content' => !empty($node->hsTreeNode->description) ?
                            strip_tags($node->hsTreeNode->description) : '',
                    ],
                    [
                        'tag' => 'field',
                        'attributes' => [
                            'name' => $this->fieldsMap['notesForUse'],
                        ],
                        'content' => !empty($node->hsTreeNode->notes_application) ?
                            strip_tags($node->hsTreeNode->notes_application) : '',
                    ],
                    [
                        'tag' => 'field',
                        'attributes' => [
                            'name' => $this->fieldsMap['notesForExclusion'],
                        ],
                        'content' => !empty($node->hsTreeNode->notes_exclusion) ?
                            strip_tags($node->hsTreeNode->notes_exclusion) : '',
                    ],
                ],
            ];
        }

        return $data;
    }

    /**
     * @param array $nodesFromDB
     * @return array
     */
    public static function addDataToOdtExport(array $nodesFromDB)
    {
        $data = [];
        while (($node = array_shift($nodesFromDB))) {
            $data[] = [
                'code' => $node->getCodePath(),
                'title' => $node->name,
                'term' => $node->hsTreeNode->conservation_term,
                'finalDestination' => $node->hsTreeNode->finalDestination->abbreviation,
                'description' => strip_tags($node->hsTreeNode->description),
                'notesForUse' => strip_tags($node->hsTreeNode->notes_application),
                'notesForExclusion' => strip_tags($node->hsTreeNode->notes_exclusion),
            ];
            unset($node);
        }
        return $data;
    }

    /**
     * @param array $eol
     * @return array
     */
    public function addDataToOdtEolExport(array $eol)
    {
        $data = [];
        while ($node = array_shift($eol)) {
            $data[] = [
                'code' => $node['full_code'],
                'title' => $node['title'],
                'date' => date('Y-m-d', (int)$node['date']),
                'final_date' => $node['final_date'] ? date('Y-m-d', (int)$node['final_date']) : '',
                'extent_description' => strip_tags($node['extent_description']),
                'full_code' => $node['full_code'],
            ];
            unset($node);
        }
        return $data;
    }

    /**
     * @param XMLReader $xml
     * @return array
     */
    public function getXmlDataToImportWithCodePathKey($xml)
    {
        $importData = [];
        $nodeData = [];

        $code = $this->fieldsMap['code'];
        $title = $this->fieldsMap['title'];
        $term = $this->fieldsMap['term'];
        $finalDestination = $this->fieldsMap['finalDestination'];
        $description = $this->fieldsMap['description'];
        $notesForUse = $this->fieldsMap['notesForUse'];
        $notesForExclusion = $this->fieldsMap['notesForExclusion'];

        while ($xml->read()) {
            if ($xml->nodeType == XMLReader::ELEMENT && $xml->localName === 'field') {
                switch ($xml->getAttribute('name')) {
                    case $code :
                        $nodeData[$code] = $xml->readInnerXml();
                        break;
                    case $title :
                        $nodeData[$title] = $xml->readInnerXml();
                        break;
                    case $term :
                        $nodeData[$term] = $xml->readInnerXml();
                        break;
                    case $finalDestination :
                        $nodeData[$finalDestination] = $xml->readInnerXml();
                        break;
                    case $description :
                        $nodeData[$description] = $xml->readInnerXml();
                        break;
                    case $notesForUse :
                        $nodeData[$notesForUse] = $xml->readInnerXml();
                        break;
                    case $notesForExclusion :
                        $nodeData[$notesForExclusion] = $xml->readInnerXml();
                        $importData[$nodeData[$code]] = $nodeData;
                        break;
                }
            }
        }

        return $importData;
    }

    /**
     * @param string $importFileField
     * @param int $hsId
     * @return bool|string
     */
    public function convertUploadedFileToCSV($importFileField, $hsId)
    {
        $uploadForm = new UploadForm();
        $errorMessage = false;

        if (!$uploadForm->createDir()) {
            $errorMessage = Yii::t('app', 'Failed to create directory');
        }

        $uploadForm->importFile = UploadedFile::getInstance($uploadForm, $importFileField);

        if ($uploadForm->validate()) {
            $importData = [];

            if ($uploadForm->importFile->type === 'text/xml') {
                $xml = new XMLReader;
                $xml->open($uploadForm->importFile->tempName);
                $importData = $this->getXmlDataToImportWithCodePathKey($xml);
                unset($xml);
            } elseif ($uploadForm->importFile->type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                $excelData = (array) Excel::import($uploadForm->importFile->tempName);
                $importData = $this->getExcelDataToImportWithCodePathKey($excelData);
                unset($excelData);
            } elseif ($uploadForm->importFile->type === 'text/csv') {
                $downloadFile = UploadedFile::getInstance($uploadForm, $importFileField);
                $path = Yii::getAlias(UploadForm::DIR_PATH) . $uploadForm->importFile->baseName . '.csv';
                $downloadFile->saveAS($path);
                $cvsData = $this->getArrayFromCvsFile($path);
                $importData = $this->getExcelDataToImportWithCodePathKey($cvsData);
                unset($cvsData);
            } else {
                $errorMessage = Yii::t('app', 'This data format is not supported for import');
            }

            if (empty($importData)) {
                $errorMessage = Yii::t('app', 'This data structure is not supported for import or imported file was empty');
            }

            $nodesFromDB = $this->getNodesByHsIdWithSortConditions($hsId, 'root, lft, code');
            $nodesToAdd = $this->getNewNodesFromExcel($importData, $nodesFromDB);
            $newNodesCount = count($nodesToAdd);
            $newNodesFile = $this->saveDataToCSV($nodesToAdd, $uploadForm->importFile->baseName, 'newNodes');
            chmod($newNodesFile, 0755);
            unset($nodesToAdd);

            $nodesToUpdate = $this->getNodesToUpdateFromExcel($importData, $nodesFromDB);
            unset($nodesFromDB);
            unset($importData);
            $updateNodesFile = $this->saveDataToCSV($nodesToUpdate, $uploadForm->importFile->baseName, 'nodesToUpdate');
            chmod($updateNodesFile, 0755);
            $nodesToUpdateCount = count($nodesToUpdate);
            unset($nodesToUpdate);

            return [
                'newNodesFile' => $newNodesFile,
                'updateNodesFile' => $updateNodesFile,
                'newNodesCount' => $newNodesCount,
                'nodesToUpdateCount' => $nodesToUpdateCount,
                'errorMessage' => $errorMessage,
            ];
        }

        return [
            'errorMessage' => Yii::t('app', 'Invalid file to import: ') . $uploadForm->getFirstError('importFile'),
        ];
    }

    /**
     * @param int $id
     * @return KartikTreeNode
     */
    public function getKartikTreeNodeById($id)
    {
        /** @var KartikTreeNode $node */
        return KartikTreeNode::findOne(['id' => $id]);
    }

    /**
     * @param int $id
     * @return HsTreeNode
     */
    public function getHsTreeNodeById($id)
    {
        return HsTreeNode::findOne(['id' => $id]);
    }

    /**
     * @return array
     */
    public function importDataFromCSV()
    {
        $request = Yii::$app->request;
        $hsId = (int) $request->post('hsId');
        $newNodesFile = $request->post('newNodesFile');
        $updateNodesFile = $request->post('updateNodesFile');
        $isInserting = (bool)$request->post('isInserting', 1);
        $csvOffset = (int) $request->post('csvOffset');

        $fileName = $isInserting ? $newNodesFile : $updateNodesFile;
        if (!file_exists($fileName) || !is_readable($fileName)) {
            return [
                'status' => 'error',
                'message' => Yii::t('app', 'Error : file does not exist or cannot be read! Try upload file again'),
            ];
        }

        if (($csvFile = fopen($fileName, 'r+')) === false) {
            return [
                'status' => 'error',
                'message' => Yii::t('app', 'Error during open file'),
            ];
        }

        $isFinished = false;
        fseek($csvFile, $csvOffset);

        for ($processedRows = 0; $processedRows < self::$chunkRows; $processedRows++) {
            $row = fgetcsv($csvFile, 0, ';');
            if ($row !== false) {
                if ($isInserting) {
                    $this->saveNewNodes($hsId, $row);
                } else {
                    $this->updateExistingNodes($row);
                }
            } else {
                $isFinished = true;
                break;
            }
        }

        $csvOffset = ftell($csvFile);
        fclose($csvFile);

        if (!$isInserting && $isFinished) {
            $this->deleteFiles($newNodesFile, $updateNodesFile);
        }

        return [
            'status' => 'success',
            'processedRows' => $processedRows,
            'csvOffset' => $csvOffset,
            'isFinished' => (int)$isFinished,
            'isInserting' => (int)$isInserting,
        ];
    }

    /**
     * @param string $newNodesFile
     * @param string $updateNodesFile
     */
    public function deleteFiles($newNodesFile, $updateNodesFile)
    {
        $files = [$newNodesFile, $updateNodesFile];
        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    /**
     * @param int $hsId
     * @param array $row
     * @return int
     */
    public function saveNewNodes($hsId, array $row)
    {
        $codeOrder = $this->fieldsSortOrder[$this->fieldsMap['code']];
        $titleOrder = $this->fieldsSortOrder[$this->fieldsMap['title']];
        $termOrder = $this->fieldsSortOrder[$this->fieldsMap['term']];
        $finalDestinationOrder = $this->fieldsSortOrder[$this->fieldsMap['finalDestination']];
        $descriptionOrder = $this->fieldsSortOrder[$this->fieldsMap['description']];
        $notesForUseOrder = $this->fieldsSortOrder[$this->fieldsMap['notesForUse']];
        $notesForExclusionOrder = $this->fieldsSortOrder[$this->fieldsMap['notesForExclusion']];

        $kartikTreeNode = $this->getKartikTreeNodeModel();
        $kartikTreeNode->hs_tree_id = $hsId;
        $kartikTreeNode->name = $row[$titleOrder];

        $code = (string) trim($row[$codeOrder], FundsController::DELIMITER);

        if ($this->isRootByCode($code)) {
            $kartikTreeNode->makeRoot();
            $kartikTreeNode->save();
        } else {
            $parentNode = $this->getParentNodeByPathCode(trim($code, FundsController::DELIMITER), $hsId);
            $kartikTreeNode->appendTo($parentNode);
            $code_arr = explode(FundsController::DELIMITER, trim($code, FundsController::DELIMITER));
            $code = array_pop($code_arr);
        }

        $hsTreeNode = $this->getHsTreeNodeById($kartikTreeNode->id);

        $hsTreeNode->code = trim($code, FundsController::DELIMITER);
        $hsTreeNode->description = $row[$descriptionOrder];
        $hsTreeNode->notes_application = $row[$notesForUseOrder];
        $hsTreeNode->notes_exclusion = $row[$notesForExclusionOrder];
        $hsTreeNode->conservation_term = $row[$termOrder];

        if (!empty($row[$finalDestinationOrder])) {
            $finalDestination = $this->getFinalDestinationByAbbreviation($row[$finalDestinationOrder]);
            $hsTreeNode->final_destination_id = is_object($finalDestination) ? $finalDestination->id : null;
        } else {
            $hsTreeNode->final_destination_id = null;
        }

        $hsTreeNode->save();

        return $kartikTreeNode->id;
    }

    /**
     * @param array $row
     * @return int
     */
    public function updateExistingNodes(array $row)
    {
        $idOrder = $this->fieldsSortOrder[$this->fieldsMap['id']];
        $titleOrder = $this->fieldsSortOrder[$this->fieldsMap['title']];
        $termOrder = $this->fieldsSortOrder[$this->fieldsMap['term']];
        $finalDestinationOrder = $this->fieldsSortOrder[$this->fieldsMap['finalDestination']];
        $descriptionOrder = $this->fieldsSortOrder[$this->fieldsMap['description']];
        $notesForUseOrder = $this->fieldsSortOrder[$this->fieldsMap['notesForUse']];
        $notesForExclusionOrder = $this->fieldsSortOrder[$this->fieldsMap['notesForExclusion']];

        $nodeId = $row[$idOrder];

        $kartikTreeNode = $this->getKartikTreeNodeById($nodeId);
        $hsTreeNode = $this->getHsTreeNodeById($nodeId);

        $kartikTreeNode->name = $row[$titleOrder];
        $kartikTreeNode->save();

        $hsTreeNode->description = $row[$descriptionOrder];
        $hsTreeNode->notes_application = $row[$notesForUseOrder];
        $hsTreeNode->notes_exclusion = $row[$notesForExclusionOrder];
        $hsTreeNode->conservation_term = $row[$termOrder];

        if (!empty($row[$finalDestinationOrder])) {
            $finalDestination = $this->getFinalDestinationByAbbreviation($row[$finalDestinationOrder]);
            $hsTreeNode->final_destination_id = is_object($finalDestination) ? $finalDestination->id : null;
        } else {
            $hsTreeNode->final_destination_id = null;
        }

        $hsTreeNode->save();

        return $kartikTreeNode->id;
    }

    /**
     * @param KartikTreeNode $parentNode
     * @param string $code
     * @return kartikTreeNode
     */
    public function getParentNode($parentNode, $code)
    {
        $firstLevelChildren = $parentNode->children(1)->all();

        $findChildNode = null;
        /** @var KartikTreeNode $child */
        foreach ($firstLevelChildren as $child) {
            if ($child->hsTreeNode->code !== $code) {
                continue;
            }
            $findChildNode = $child;
        }

        return $findChildNode;
    }

    /**
     * @param string $pathCode
     * @param int $hsId
     * @return KartikTreeNode
     */
    public function getParentNodeByPathCode($pathCode, $hsId)
    {

        $codes = explode('.', $pathCode);
        array_pop($codes);
        $pathCodeToCache = implode('.', $codes);
        $rootCode = array_shift($codes);

        if (self::$parentNodesCache && self::$parentNodesCacheKey === $pathCodeToCache) {
            return self::$parentNodesCache;
        }

        $parentNode = $this->getNodeByConditions([
            'hs_tree_id' => $hsId,
            'code' => $rootCode,
            'lft' => 1
        ]);

        foreach ($codes as $code) {
            $parentNode = $this->getParentNode($parentNode, $code);
        }

        self::$parentNodesCacheKey = $pathCodeToCache;
        return self::$parentNodesCache = $parentNode;
    }

    /**
     * @param array $conditions
     * @return KartikTreeNode
     */
    private function getNodeByConditions($conditions)
    {
        return KartikTreeNode::find()
            ->joinWith('hsTreeNode')
            ->where($conditions)
            ->one();
    }

    /**
     * @param string $code
     * @return bool
     */
    public function isRootByCode($code)
    {
        return strpos($code, '.') === false;
    }

    /**
     * @param $abbr
     * @return HsFinalDestination
     */
    public function getFinalDestinationByAbbreviation($abbr)
    {
        return HsFinalDestination::findOne(['abbreviation' => $abbr]);
    }

    /**
     * @param string $path
     * @return array
     */
    public function getArrayFromCvsFile($path)
    {
        $fp = fopen($path, "r");
        while (!feof($fp)) {
            $nodeArray = fgetcsv($fp, 1024, ";");
            if (!empty($nodeArray[2])) {
                $node['CODE'] = $nodeArray[2];
                $node['TITLE'] = $nodeArray[4];
                $node['TERM OF ADMINISTRATIVE CONSERVATION'] = $nodeArray[5];
                $node['FINAL DESTINATION'] = $nodeArray[7];
                $node['DESCRIPTION'] = $nodeArray[6];
                $node['NOTES FOR USE'] = $nodeArray[3];
                $node['NOTES FOR EXCLUSION'] = $nodeArray[1];
                $cvsData[] = $node;
            }
            unset($node, $nodeArray);
        }
        unlink($path);
        return $cvsData;
    }
}