<?php


namespace common\services;

use Imagine\Exception\RuntimeException;
use modules\hierarchicalStructure\controllers\backend\FundsController;
use modules\hierarchicalStructure\models\Files;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\Records;
use modules\hierarchicalStructure\models\UploadForm;
use moonland\phpexcel\Excel;
use yii\helpers\BaseFileHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;
use Yii;

/**
 * Class FundService
 * @package common\services
 */
class FundService
{

    public $errorMessage = 'Fund is uploaded';
    /**
     * @var array
     */
    public $fieldsMap = [
        'code' => 'code',
        'title' => 'title',
        'date' => 'date',
        'final_date' => 'final_date',
        'level_description' => 'level_description',
        'extent_description' => 'extent_description',
        'creator' => 'creator',
        'administrative_history' => 'administrative_history',
        'archival_history' => 'archival_history',
        'trans' => 'trans',
        'content' => 'content',
        'information' => 'information',
        'accruals' => 'accruals',
        'arrangement' => 'arrangement',
        'access' => 'access',
        'reproduction' => 'reproduction',
        'language' => 'language',
        'characteristics' => 'characteristics',
        'aids' => 'aids',
        'location_originals' => 'location_originals',
        'location_copies' => 'location_copies',
        'related_units' => 'related_units',
        'publication_note' => 'publication_note',
        'note' => 'note',
        'archivist_note' => 'archivist_note',
        'rules' => 'rules',
        'date_descriptions' => 'date_descriptions',
        'fond_id' => 'fond_code',
        'hs_id' => 'keyHs',
        'records' => 'records',
        'node_id' => 'node_code',
        'files' => 'files',
        'file_id' => 'file_id',
        'file_base64' => 'file_base64',
    ];

    public $fieldMapCSV = [
        'code' => 'Reference code',
        'title' => 'Title',
        'date' => 'Date',
        'final_date' => 'Final date',
        'level_description' => 'Level of description',
        'extent_description' => 'Extent and medium',
        'creator' => 'Name of creator',
        'administrative_history' => 'Administrative / Biographical history',
        'archival_history' => 'Archival history',
        'trans' => 'Immediate source of acquisition or trans',
        'content' => 'Scope and content',
        'information' => 'Appraisal, destruction and scheduling information',
        'accruals' => 'Accruals',
        'arrangement' => 'System of arrangement',
        'access' => 'Conditions governing access',
        'reproduction' => 'Conditions governing reproduction',
        'language' => 'Language / scripts of material',
        'characteristics' => 'Physical characteristics and technical requirements',
        'aids' => 'Finding aids',
        'location_originals' => 'Existence and location of originals',
        'location_copies' => 'Existence and location of copies',
        'related_units' => 'Related units of description',
        'publication_note' => 'Publication note',
        'note' => 'Note',
        'archivist_note' => 'Archivist\'s Note',
        'rules' => 'Rules or Conventions',
        'date_descriptions' => 'Date of descriptions',
        'keyHs' => 'Key HS',
        'fond_code' => 'Fund Code',
        'node_code' => 'Node Code',
    ];

    /**
     * @param object $fund
     * @return array
     */
    public function addFundStructureToXml($fund)
    {
        $records = Records::findAll(['fond_id' => $fund->id]);
        $data[] = [
            'tag' => 'row',
            'elements' => [
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['code'],
                        ],
                    'content' => $fund->code,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['title'],
                        ],
                    'content' => $fund->title,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['date'],
                        ],
                    'content' => $fund->date,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['final_date'],
                        ],
                    'content' => !empty($fund->final_date) ? $fund->final_date : '',
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['level_description'],
                        ],
                    'content' => $fund->level_description,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['extent_description'],
                        ],
                    'content' => $fund->extent_description,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['creator'],
                        ],
                    'content' => $fund->creator,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['administrative_history'],
                        ],
                    'content' => $fund->administrative_history,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['archival_history'],
                        ],
                    'content' => $fund->archival_history,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['trans'],
                        ],
                    'content' => $fund->trans,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['content'],
                        ],
                    'content' => $fund->content,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['information'],
                        ],
                    'content' => $fund->information,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['accruals'],
                        ],
                    'content' => $fund->accruals,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['arrangement'],
                        ],
                    'content' => $fund->arrangement,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['access'],
                        ],
                    'content' => $fund->access,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['reproduction'],
                        ],
                    'content' => $fund->access,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['language'],
                        ],
                    'content' => $fund->access,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['characteristics'],
                        ],
                    'content' => $fund->characteristics,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['aids'],
                        ],
                    'content' => $fund->aids,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['location_originals'],
                        ],
                    'content' => $fund->location_originals,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['location_copies'],
                        ],
                    'content' => $fund->location_copies,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['related_units'],
                        ],
                    'content' => $fund->related_units,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['publication_note'],
                        ],
                    'content' => $fund->publication_note,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['note'],
                        ],
                    'content' => $fund->note,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['archivist_note'],
                        ],
                    'content' => $fund->archivist_note,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['rules'],
                        ],
                    'content' => $fund->rules,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['date_descriptions'],
                        ],
                    'content' => $fund->date_descriptions,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['hs_id'],
                        ],
                    'content' => $fund->keyHsTree,
                ],
                [
                    'tag' => 'field',
                    'attributes' =>
                        [
                            'name' => $this->fieldsMap['records'],
                        ],
                    'content' => $this->addFundRecordsToXml($records)
                ]
            ],
        ];
        return $data;
    }

    /**
     * @param array $records
     * @return array
     */
    protected function addFundRecordsToXml($records)
    {
        $data = [];
        while ($node = array_shift($records)) {
            $data[] = [
                'tag' => 'row',
                'elements' => [
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['code'],
                            ],
                        'content' => $node->code,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['title'],
                            ],
                        'content' => $node->title,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['date'],
                            ],
                        'content' => date('Y-m-d', (int)$node->date),
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['final_date'],
                            ],
                        'content' => !empty($node->final_date) ? date('Y-m-d', (int)$node->final_date) : '',
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['level_description'],
                            ],
                        'content' => $node->level_description,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['extent_description'],
                            ],
                        'content' => $node->extent_description,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['creator'],
                            ],
                        'content' => $node->creator,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['administrative_history'],
                            ],
                        'content' => $node->administrative_history,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['archival_history'],
                            ],
                        'content' => $node->archival_history,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['trans'],
                            ],
                        'content' => $node->trans,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['content'],
                            ],
                        'content' => $node->content,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['information'],
                            ],
                        'content' => $node->information,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['accruals'],
                            ],
                        'content' => $node->accruals,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['arrangement'],
                            ],
                        'content' => $node->arrangement,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['access'],
                            ],
                        'content' => $node->access,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['reproduction'],
                            ],
                        'content' => $node->access,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['language'],
                            ],
                        'content' => $node->access,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['characteristics'],
                            ],
                        'content' => $node->characteristics,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['aids'],
                            ],
                        'content' => $node->aids,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['location_originals'],
                            ],
                        'content' => $node->location_originals,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['location_copies'],
                            ],
                        'content' => $node->location_copies,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['related_units'],
                            ],
                        'content' => $node->related_units,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['publication_note'],
                            ],
                        'content' => $node->publication_note,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['note'],
                            ],
                        'content' => $node->note,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['archivist_note'],
                            ],
                        'content' => $node->archivist_note,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['rules'],
                            ],
                        'content' => $node->rules,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['date_descriptions'],
                            ],
                        'content' => $node->date_descriptions,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['fond_id'],
                            ],
                        'content' => Funds::findOne($node->fond_id)->code,
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['node_id'],
                            ],
                        'content' => !empty(FundsController::getCodeRecordParent($node->node_id))
                            ? trim(
                                KartikTreeNode::findOne($node->node_id)->getCodePath(),
                                FundsController::DELIMITER
                            ) . FundsController::DELIMITER_RECORDS
                            . FundsController::getCodeRecordParent($node->node_id)
                            : trim(
                                KartikTreeNode::findOne($node->node_id)->getCodePath(),
                                FundsController::DELIMITER
                            ),
                    ],
                    [
                        'tag' => 'field',
                        'attributes' =>
                            [
                                'name' => $this->fieldsMap['files'],
                            ],
                        'content' => '',
                    ],
                ],
            ];
        }
        return $data;
    }

    public function convertUploadedFileToCSV($importFileField)
    {
        $uploadForm = new UploadForm();

        if (!$uploadForm->createDir()) {
            $this->errorMessage = \Yii::t('app', 'Failed to create directory');
        }
        $uploadForm->importFile = UploadedFile::getInstance($uploadForm, $importFileField);
        if ($uploadForm->validate() && $uploadForm->importFile->type === 'text/xml') {
            $xml = new \XMLReader();
            $xml->open($uploadForm->importFile->tempName);
            $importData = $this->getXmlDataToImportWithCodePathKey($xml);
            unset($xml);
        } elseif ($uploadForm->validate() && $uploadForm->importFile->type === 'text/csv') {
            $downloadFile = UploadedFile::getInstance($uploadForm, $importFileField);
            $path = Yii::getAlias(UploadForm::DIR_PATH) . $uploadForm->importFile->baseName . '.csv';
            $downloadFile->saveAS($path);
            $importData = $this->getArrayFromCvsFile($path);
            unset($cvsData);
        } elseif (
            $uploadForm->validate()
            &&
            $uploadForm->importFile->type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ) {
            $excelData = (array) Excel::import($uploadForm->importFile->tempName);
            $importData = $this->getExcelDataToImportWithCodePathKey($excelData);
            unset($excelData);
        } else {
            $this->errorMessage = Yii::t('app', 'This data format is not supported for import');
        }
        if (empty($importData)) {
            $this->errorMessage = Yii::t(
                'app',
                'This data structure is not supported for import or imported file was empty'
            );
        }
        return $this->preservationFundStructure($this->sort($importData));
    }

    /**
     * @param array $excelData
     * @return array
     */
    protected function getExcelDataToImportWithCodePathKey(array $excelData)
    {
        $importData = [];
        foreach ($excelData as $nodeData) {
            if (!is_array($nodeData) || empty($nodeData['Reference code'])) {
                continue;
            }
            $nodeData = $this->changeKeyCVS($nodeData);
            foreach ($nodeData as $attribute => $value) {
                if (empty($nodeData['fond_code'])) {
                    $importData[$nodeData['node_code']] = $nodeData;
                }
                if (!empty($nodeData['fond_code']) && strtolower($attribute) === $this->fieldsMap['code']) {
                    $nodeData['code'] = end(explode(FundsController::DELIMITER_RECORDS, $nodeData['code']));
                    $importData[$nodeData['node_code']][] = $nodeData;
                }
            }
        }

        return $importData;
    }

    /**
     * @param array $nodeData
     * @return mixed
     */
    public function changeKeyCVS(array $nodeData)
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

    /**
     * @param array $importData
     * @return array
     */
    protected function preservationFundStructure($importData)
    {
        foreach ($importData as $k => $record) {
            if ($k == $record[$this->fieldsMap['code']]) {
                $hsKeys = explode(Funds::DELIMETER, $record[$this->fieldsMap['hs_id']]);
                $hsIds = $this->verificationExistenceStructure($hsKeys);
                $fond_id = $this->saveFund($record, $hsIds);
            } else {
                $nodes = KartikTreeNode::findAll(['hs_tree_id' => $hsIds]);
                foreach ($nodes as $node) {
                    $node_codes[$node->id] = KartikTreeNode::getNoteCode($node->id);
                }
                $nodes = null;
                foreach ($record as $value) {
                    $record_id = $this->saveRecord($value, $node_codes, $fond_id);
                }
                if (!empty($record['files'])) {
                    $data = explode(';base64,', $record['files'], 2);
                    $content = explode('/', $data[0]);
                    $file = base64_decode($data[1]);
                    BaseFileHelper::createDirectory(Yii::getAlias('@runtime') . '/exportmef/' . $record_id, 0777, true);
                    $path = 'exportmef/' . $record_id. '/' . uniqid() . ".$content[1]";
                    file_put_contents(Yii::getAlias('@runtime') . '/' . $path, $file);
                    $fileDb = new Files();
                    $fileDb->record_id = $record_id;
                    $fileDb->path = $path;
                    $fileDb->type = FileHelper::getMimeType(Yii::getAlias('@runtime') . '/' . $fileDb->path);
                    $fileDb->version = $this->versionFile(Yii::getAlias('@runtime') . '/' . $fileDb->path);
                    $fileDb->save();
                    $record = null;
                    $node_codes = null;
                    $fileDb = null;
                } else {
                    $record = null;
                    $node_codes = null;
                    continue;
                }
            }
        }
        return [
            'errorMessage' => $this->errorMessage,
        ];
    }

    /**
     * @param array $importData
     * @return array
     */
    private function sort($importData)
    {
        foreach ($importData as $k => $records) {
            if ($records[0] !== null) {
                $result = array();
                foreach ($records as $key => $row) {
                    $result[$key] = $row['code'];
                }
                array_multisort($result, SORT_ASC, $records);
                $importData[$k] = $records;
            }
        }
        return $importData;
    }

    /**
     * @param array $hsKeys
     * @return array
     */
    protected function verificationExistenceStructure($hsKeys)
    {
        foreach ($hsKeys as $value) {
            $hs = HsTree::findOne(['key' => $value]);
            if ($hs === null) {
                $this->errorMessage = Yii::t('app', 'Hs not found');
            }
            $hsIds[] = $hs->id;
        }
        return $hsIds;
    }

    /**
     * @param array $record
     * @param array $node_codes
     * @param integer $fond_id
     * @return mixed
     */
    protected function saveRecord($record, $node_codes, $fond_id)
    {
        $node_id = array_search(trim($record['node_code'], '.'), $node_codes);
        if (empty($node_id)) {
            $parents = array_column(KartikTreeNode::findAll(['fund_id' => $fond_id]), 'id');

            foreach ($parents as $parent) {
                $node_code_parents[$parent] = trim(
                    KartikTreeNode::getNoteCode($parent),
                    FundsController::DELIMITER
                    ) . FundsController::DELIMITER_RECORDS . Records::findOne(['node_id' => $parent])->code;
                $node_id = array_search($record['node_code'], $node_code_parents);
            }
        }
        $nodeModel = KartikTreeNode::findOne($node_id);
        $node = new KartikTreeNode();
        $node->activeOrig = $node->active;
        $node->name = $record['title'];
        $node->hs_tree_id = $nodeModel->hs_tree_id;
        $node->appendTo($nodeModel);
        $node->type = FundsController::RECORD_TYPE;
        $node->fund_id = $fond_id;
        $node_codes = null;
        if ($node->save()) {
            $model = new Records();
            foreach ($record as $k => $value) {
                $record[$k] = Html::decode($value);
            }
            $model->attributes = $record;
            $model->fond_id = $fond_id;
            $model->node_id = $node->id;
            $full_code = new CodeService();
            $model->full_code = $full_code->getFullCodeRecord($model);

            if ($model->save()) {
                return $model->id;
            } else {
                throw new ForbiddenHttpException('Record data ' . $record['code'] . ' not saved');
            }
        }
    }

    /**
     * @param array $record
     * @param array $hsIds
     * @return mixed
     */
    protected function saveFund($record, $hsIds)
    {

        $fund = new Funds();
        foreach ($record as $k => $value) {
            $record[$k] = Html::decode($value);
        }
        $fund->attributes = $record;
        $fund->setFormHsTree($hsIds);
        if ($fund->save()) {
            foreach ($hsIds as $item) {
                $hs = HsTree::findOne($item);
                $fund->link("hsTree", $hs);
            }
            return $fund->id;
        }
    }

    /**
     * @param object $xml
     * @return array
     */
    protected function getXmlDataToImportWithCodePathKey($xml)
    {
        $importData = [];
        $nodeData = [];
        $code = $this->fieldsMap['code'];
        $records = $this->fieldsMap['records'];
        $files = $this->fieldsMap['files'];
        $node_code = $this->fieldsMap['node_id'];
        while ($xml->read()) {
            if (!($xml->nodeType == \XMLReader::ELEMENT && $xml->localName === 'field')) {
                continue;
            }
            $attr = $xml->getAttribute('name');
            switch (true) {
                case in_array($attr, $this->fieldsMap):
                    if ($attr == $records) {
                        $importData[$nodeData[$code]] = $nodeData;
                        break;
                    } elseif ($attr == $files) {
                        $nodeData[$files] = $xml->readInnerXml();
                        $importData[$nodeData[$node_code]][] = $nodeData;
                        break;
                    } else {
                        $nodeData[$attr] = $xml->readInnerXml();
                        break;
                    }
                default:
                    continue 2;
            }
        }
        return $importData;
    }

    /**
     * @param string $path
     * @return int
     */
    public static function versionFile($path)
    {
        try {
            $fp = (new \SplFileInfo($path))->openFile('rb');
        } catch (RuntimeException $e) {
            return 0;
        }
        preg_match('/\d\.\d/', $fp->fread(20), $match);
        $fp = null;
        if (isset($match[0])) {
            return $match[0];
        } else {
            return 0;
        }
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
            if (!empty($nodeArray[0])) {
                $node['code'] = $nodeArray[0];
                $node['title'] = $nodeArray[1];
                $node['date'] = $nodeArray[2];
                $node['final_date'] = $nodeArray[3];
                $node['level_description'] = $nodeArray[4];
                $node['extent_description'] = $nodeArray[5];
                $node['creator'] = $nodeArray[6];
                $node['administrative_history'] = $nodeArray[7];
                $node['archival_history'] = $nodeArray[8];
                $node['trans'] = $nodeArray[9];
                $node['content'] = $nodeArray[10];
                $node['information'] = $nodeArray[11];
                $node['accruals'] = $nodeArray[12];
                $node['arrangement'] = $nodeArray[13];
                $node['access'] = $nodeArray[14];
                $node['reproduction'] = $nodeArray[15];
                $node['language'] = $nodeArray[16];
                $node['characteristics'] = $nodeArray[17];
                $node['aids'] = $nodeArray[18];
                $node['location_originals'] = $nodeArray[19];
                $node['location_copies'] = $nodeArray[20];
                $node['related_units'] = $nodeArray[21];
                $node['publication_note'] = $nodeArray[22];
                $node['note'] = $nodeArray[23];
                $node['archivist_note'] = $nodeArray[24];
                $node['rules'] = $nodeArray[25];
                $node['date_descriptions'] = $nodeArray[26];
                $node['keyHs'] = $nodeArray[27];
                if (empty($nodeArray[29])) {
                    $cvsData[$nodeArray[0]] = $node;
                } else {
                    $node['fond_code'] = $nodeArray[28];
                    $node['node_code'] = $nodeArray[29];
                    $cvsData[$node['node_code']][] = $node;
                }
            }
            unset($node, $nodeArray);
        }
        return $cvsData;
    }

    /**
     * @param array $records
     * @return array
     */
    public static function getAllFiles(array $records)
    {
        foreach ($records as $record) {
            foreach ($record->files as $file) {
                $files[] = $file;
            }
        }
        return $files;
    }
}
