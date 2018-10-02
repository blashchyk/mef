<?php

namespace modules\hierarchicalStructure\controllers\backend;


use bupy7\xml\constructor\XmlConstructor;
use common\services\ExcelService;
use common\services\FundService;
use hscstudio\export\OpenTBS;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\Records;
use modules\hierarchicalStructure\models\UploadForm;
use yii\helpers\Html;


/**
 * Trait ExportHelper
 * @package modules\hierarchicalStructure\controllers\backend
 */
trait ExportHelper
{
    /**
     * @var array
     */
    public $fieldsMap = [
        'id' => 'id',
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
        'fond_id' => 'fond_id',
        'node_id' => 'node_id',
        'file' => 'file',
    ];
    /**
     * @var array
     */
    public $fieldsSortOrder = [
        'code' => 0,
        'title' => 1,
        'date' => 2,
        'final_date' => 3,
        'level_description' => 4,
        'extent_description' => 5,
        'creator' => 6,
        'administrative_history' => 7,
        'archival_history' => 8,
        'trans' => 9,
        'content' => 10,
        'information' => 11,
        'accruals' => 12,
        'arrangement' => 13,
        'access' => 14,
        'reproduction' => 15,
        'language' => 16,
        'characteristics' => 17,
        'aids' => 18,
        'location_originals' => 19,
        'location_copies' => 20,
        'related_units' => 21,
        'publication_note' => 22,
        'note' => 23,
        'archivist_note' => 24,
        'rules' => 25,
        'date_descriptions' => 26,
        'id' => 27,
        'hs_key' => 28,
        'fond_id' => 29,
        'node_id' => 30,
        'file' => 31,
    ];

    /**
     * @param integer $fundId
     */
    public function exportPdf($fundId)
    {
        $this->setPhpIniValue();
        $fund = Funds::findOne($fundId);
        $records = Records::find()->where(['fond_id' => $fund->id])->orderBy(['node_id' => SORT_ASC])->all();
        $html = $this->renderPartial('export-templates/_pdf_fund', [
            'fund' => $fund,
            'records' => $records,
        ]);
        $mpdf = new \mPDF('c', 'A4', '', '', 10, 10, 5, 5, 0, 0, 'L');
        $mpdf->list_indent_first_level = 0;
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;
        $mpdf->WriteHTML($html);
        unset($html);
        $mpdf->Output('report-' . date('mdY') . '.pdf', 'D');
        exit;
    }

    /**
     * @param integer $fundId
     */
    public function exportExcel($fundId)
    {
        $this->setPhpIniValue();
        $fund = Funds::findOne($fundId);
        $records = Records::find()->where(['fond_id' => $fundId])->orderBy(['node_id' => SORT_ASC])->all();
        $ecxel = new ExcelService();
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=export_fund_" . date('Y-m-d') . ".xlsx");
        $objWriter = new \PHPExcel_Writer_Excel5($ecxel->addExcelFile($fund, $records));
        $objWriter->save('php://output');
    }

    /**
     * @param integer $fundId
     * @return string
     */
    public function actionExportXml($fundId)
    {
        $this->setPhpIniValue();
        $fund = Funds::findOne($fundId);
        $fundService = new FundService();
        $data = $fundService->addFundStructureToXml($fund);
        $in = [
            [
                'tag' => 'root',
                'elements' => $data,
            ],
        ];
        $xml = new XmlConstructor();
        \Yii::$app->response->setDownloadHeaders('report-'.date('mdY').'.xml', 'application/xml');
        return $xml->fromArray($in)->toOutput();
    }

    /**
     * @param $fundId
     */
    public function exportOdt($fundId)
    {
        $this->setPhpIniValue();
        $fund = Funds::findOne($fundId);
        $records = Records::find()->where(['fond_id' => $fundId])->orderBy(['full_code' => SORT_ASC])->all();
        $data = $this->addDataToOdtExport($fund, $records);
        $OpenTBS = new OpenTBS();
        $template = \Yii::getAlias('@modules').'/hierarchicalStructure/export-templates/fund-template.odt';
        $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
        $OpenTBS->MergeBlock('a', $data);
        unset($data);
        $OpenTBS->Show(OPENTBS_DOWNLOAD, 'report-'.date('mdY').'.odt');
        exit;
    }

    /**
     * @param Funds $fund
     * @param array $records
     * @return array
     */
    protected function addDataToOdtExport(Funds $fund, array $records)
    {
        $file = '';
        $data[0] = [
            'code' => $fund->code,
            'title' => $fund->title,
            'date' => $fund->date,
            'final_date' => $fund->final_date,
            'level_description' => $fund->level_description,
            'extent_description' => strip_tags($fund->extent_description),
            'creator' => $fund->creator,
            'administrative_history' => strip_tags($fund->administrative_history),
            'archival_history' => strip_tags($fund->archival_history),
            'trans' => $fund->trans,
            'content' => strip_tags($fund->content),
            'information' => strip_tags($fund->information),
            'accruals' => $fund->accruals,
            'arrangement' => $fund->arrangement,
            'access' => $fund->access,
            'reproduction' => $fund->reproduction,
            'language' => $fund->language,
            'characteristics' => strip_tags($fund->characteristics),
            'aids' => strip_tags($fund->aids),
            'location_originals' => $fund->location_originals,
            'location_copies' => $fund->location_copies,
            'related_units' => $fund->related_units,
            'publication_note' => strip_tags($fund->publication_note),
            'note' => strip_tags($fund->note),
            'archivist_note' => strip_tags($fund->archivist_note),
            'rules' => $fund->rules,
            'date_descriptions' => $fund->date_descriptions,
            'file' => $file,
        ];
        while ($record = array_shift($records)) {
            if (!empty($record->files)) {
                $name = explode('/', $record->files[0]->path);
                $file = end($name);
            }
            $data[] = [
                'code' => $record->full_code,
                'title' => $record->title,
                'date' => \Yii::$app->formatter->asDate($record->date, 'php:Y-m-d'),
                'final_date' => $record->final_date
                    ? \Yii::$app->formatter->asDate($record->final_date, 'php:Y-m-d')
                    : '',
                'level_description' => $record->level_description,
                'extent_description' => strip_tags($record->extent_description),
                'creator' => $record->creator,
                'administrative_history' => strip_tags($record->administrative_history),
                'archival_history' => strip_tags($record->archival_history),
                'trans' => $record->trans,
                'content' => strip_tags($record->content),
                'information' => strip_tags($record->information),
                'accruals' => $record->accruals,
                'arrangement' => $record->arrangement,
                'access' => $record->access,
                'reproduction' => $record->reproduction,
                'language' => $record->language,
                'characteristics' => strip_tags($record->characteristics),
                'aids' => strip_tags($record->aids),
                'location_originals' => $record->location_originals,
                'location_copies' => $record->location_copies,
                'related_units' => $record->related_units,
                'publication_note' => strip_tags($record->publication_note),
                'note' => strip_tags($record->note),
                'archivist_note' => strip_tags($record->archivist_note),
                'rules' => $record->rules,
                'date_descriptions' => $record->date_descriptions,
                'file' => $file,
            ];
            unset($record);
        }
        return $data;
    }

    /**
     * @param integer $fund_id
     * @return $this
     */
    public function exportCsv($fund_id)
    {
        $file = '';
        $this->setPhpIniValue();
        $fund = Funds::findOne($fund_id);
        $arrayNode[$fund->code]['code'] = $fund->code;
        $arrayNode[$fund->code]['title'] = $fund->title;
        $arrayNode[$fund->code]['date'] = $fund->date;
        $arrayNode[$fund->code]['final_date'] = $fund->final_date;
        $arrayNode[$fund->code]['level_description'] = $fund->level_description;
        $arrayNode[$fund->code]['extent_description'] = $fund->extent_description;
        $arrayNode[$fund->code]['creator'] = $fund->creator;
        $arrayNode[$fund->code]['administrative_history'] = $fund->administrative_history;
        $arrayNode[$fund->code]['archival_history'] = $fund->archival_history;
        $arrayNode[$fund->code]['trans'] = $fund->trans;
        $arrayNode[$fund->code]['content'] = $fund->content;
        $arrayNode[$fund->code]['information'] = $fund->information;
        $arrayNode[$fund->code]['accruals'] = $fund->accruals;
        $arrayNode[$fund->code]['arrangement'] = $fund->arrangement;
        $arrayNode[$fund->code]['access'] = $fund->access;
        $arrayNode[$fund->code]['reproduction'] = $fund->reproduction;
        $arrayNode[$fund->code]['language'] = $fund->language;
        $arrayNode[$fund->code]['characteristics'] = $fund->characteristics;
        $arrayNode[$fund->code]['aids'] = $fund->characteristics;
        $arrayNode[$fund->code]['location_originals'] = $fund->location_originals;
        $arrayNode[$fund->code]['location_copies'] = $fund->location_copies;
        $arrayNode[$fund->code]['related_units'] = $fund->related_units;
        $arrayNode[$fund->code]['publication_note'] = $fund->publication_note;
        $arrayNode[$fund->code]['note'] = $fund->note;
        $arrayNode[$fund->code]['archivist_note'] = $fund->archivist_note;
        $arrayNode[$fund->code]['rules'] = $fund->rules;
        $arrayNode[$fund->code]['date_descriptions'] = $fund->date_descriptions;
        $arrayNode[$fund->code]['hs_key'] = $fund->keyHsTree;
        $records = Records::findAll(['fond_id' => $fund_id]);
        foreach ($records as $record) {
            $arrayNode[$record->full_code]['code'] = $record->code;
            $arrayNode[$record->full_code]['title'] = $record->title;
            $arrayNode[$record->full_code]['date'] = date('Y-m-d', $record->date);
            $arrayNode[$record->full_code]['final_date'] = $record->final_date
                ? date('Y-m-d', $record->final_date)
                : '';
            $arrayNode[$record->full_code]['level_description'] = $record->level_description;
            $arrayNode[$record->full_code]['extent_description'] = $record->extent_description;
            $arrayNode[$record->full_code]['creator'] = $record->creator;
            $arrayNode[$record->full_code]['administrative_history'] = $record->administrative_history;
            $arrayNode[$record->full_code]['archival_history'] = $record->archival_history;
            $arrayNode[$record->full_code]['trans'] = $record->trans;
            $arrayNode[$record->full_code]['content'] = $record->content;
            $arrayNode[$record->full_code]['information'] = $record->information;
            $arrayNode[$record->full_code]['accruals'] = $record->accruals;
            $arrayNode[$record->full_code]['arrangement'] = $record->arrangement;
            $arrayNode[$record->full_code]['access'] = $record->access;
            $arrayNode[$record->full_code]['reproduction'] = $record->reproduction;
            $arrayNode[$record->full_code]['language'] = $record->language;
            $arrayNode[$record->full_code]['characteristics'] = $record->characteristics;
            $arrayNode[$record->full_code]['aids'] = $record->aids;
            $arrayNode[$record->full_code]['location_originals'] = $record->location_originals;
            $arrayNode[$record->full_code]['location_copies'] = $record->location_copies;
            $arrayNode[$record->full_code]['related_units'] = $record->related_units;
            $arrayNode[$record->full_code]['publication_note'] = $record->publication_note;
            $arrayNode[$record->full_code]['note'] = $record->note;
            $arrayNode[$record->full_code]['archivist_note'] = $record->archivist_note;
            $arrayNode[$record->full_code]['rules'] = $record->rules;
            $arrayNode[$record->full_code]['date_descriptions'] = $record->date_descriptions;
            $arrayNode[$record->full_code]['hs_key'] = $fund->keyHsTree;
            $arrayNode[$record->full_code]['fond_id'] = Funds::findOne($record->fond_id)->code;

            $arrayNode[$record->full_code]['node_id'] = !empty(FundsController::getCodeRecordParent($record->node_id))
                ? trim(
                    KartikTreeNode::findOne($record->node_id)->getCodePath(),
                    FundsController::DELIMITER
                ) . FundsController::DELIMITER_RECORDS
                . FundsController::getCodeRecordParent($record->node_id)
                : trim(
                    KartikTreeNode::findOne($record->node_id)->getCodePath(),
                    FundsController::DELIMITER
                );
            if (!empty($record->files)) {
                $name = explode('/', $record->files[0]->path);
                $file = end($name);
            }
            $arrayNode[$record->full_code]['file'] = $file;
            unset($record);
        }
        unset($records);
        $filePath = $this->saveDataToCSV($arrayNode, 'export_fund', date('Y-m-d'));
        return \Yii::$app->response->sendFile($filePath);
    }

    /**
     * @param $importData
     * @param $fileName
     * @param $nameFlag
     * @return bool|string
     */
    public function saveDataToCSV($importData, $fileName, $nameFlag)
    {
        $csvFilePath = \Yii::getAlias(UploadForm::DIR_PATH . $fileName . '-' . $nameFlag . '.csv');
        $csvFile = fopen($csvFilePath, 'w');

        foreach ($importData as $node) {
            $nodesWithLowerKeys = array_change_key_case($node);
            uksort($nodesWithLowerKeys, [$this, 'fieldsSort']);
            fputcsv($csvFile, $nodesWithLowerKeys, ';');
        }

        fclose($csvFile);
        return $csvFilePath;
    }

    public function fieldsSort($a, $b)
    {
        return (
            isset($this->fieldsSortOrder[$a]) ? $this->fieldsSortOrder[$a] : -1
        ) > (
            isset($this->fieldsSortOrder[$b]) ? $this->fieldsSortOrder[$b] : 1
        ) ? 1 : -1;
    }
}
