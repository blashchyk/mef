<?php

namespace common\services;

use modules\hierarchicalStructure\controllers\backend\FundsController;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\KartikTreeNode;
use Yii;

/**
 * Class ExcelService
 * @package common\services
 */
class ExcelService
{
    /**
     * @param object $fund
     * @param array $records
     * @return \PHPExcel
     */
    public function addExcelFile($fund, $records)
    {
        $ecxel = new \PHPExcel();
        $ecxel->setActiveSheetIndex(0);
        $sheet = $ecxel->getActiveSheet();
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(30);
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(50);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->getColumnDimension('Q')->setWidth(30);
        $sheet->getColumnDimension('R')->setWidth(30);
        $sheet->getColumnDimension('S')->setWidth(30);
        $sheet->getColumnDimension('T')->setWidth(30);
        $sheet->getColumnDimension('U')->setWidth(30);
        $sheet->getColumnDimension('V')->setWidth(30);
        $sheet->getColumnDimension('W')->setWidth(30);
        $sheet->getColumnDimension('X')->setWidth(30);
        $sheet->getColumnDimension('Y')->setWidth(30);
        $sheet->getColumnDimension('Z')->setWidth(30);
        $sheet->getColumnDimension('AA')->setWidth(30);
        $sheet->getColumnDimension('AB')->setWidth(30);
        $sheet->getColumnDimension('AC')->setWidth(30);
        $sheet->getColumnDimension('AD')->setWidth(30);
        $sheet->getColumnDimension('AE')->setWidth(30);

        $sheet->setCellValue("A1", Yii::t('app', 'Reference code'));
        $sheet->setCellValue("B1", Yii::t('app', 'Title'));
        $sheet->setCellValue("C1", Yii::t('app', 'Date'));
        $sheet->setCellValue("D1", Yii::t('app', 'Final date'));
        $sheet->setCellValue("E1", Yii::t('app', 'Level of description'));
        $sheet->setCellValue("F1", Yii::t('app', 'Extent and medium'));
        $sheet->setCellValue("G1", Yii::t('app', 'Name of creator'));
        $sheet->setCellValue("H1", Yii::t('app', 'Administrative / Biographical history'));
        $sheet->setCellValue("I1", Yii::t('app', 'Archival history'));
        $sheet->setCellValue("J1", Yii::t('app', 'Immediate source of acquisition or trans'));
        $sheet->setCellValue("K1", Yii::t('app', 'Scope and content'));
        $sheet->setCellValue("L1", Yii::t('app', 'Appraisal, destruction and scheduling information'));
        $sheet->setCellValue("M1", Yii::t('app', 'Accruals'));
        $sheet->setCellValue("N1", Yii::t('app', 'System of arrangement'));
        $sheet->setCellValue("O1", Yii::t('app', 'Conditions governing access'));
        $sheet->setCellValue("P1", Yii::t('app', 'Conditions governing reproduction'));
        $sheet->setCellValue("Q1", Yii::t('app', 'Language / scripts of material'));
        $sheet->setCellValue("R1", Yii::t('app', 'Physical characteristics and technical requirements'));
        $sheet->setCellValue("S1", Yii::t('app', 'Finding aids'));
        $sheet->setCellValue("T1", Yii::t('app', 'Existence and location of originals'));
        $sheet->setCellValue("U1", Yii::t('app', 'Existence and location of copies'));
        $sheet->setCellValue("V1", Yii::t('app', 'Related units of description'));
        $sheet->setCellValue("W1", Yii::t('app', 'Publication note'));
        $sheet->setCellValue("X1", Yii::t('app', 'Note'));
        $sheet->setCellValue("Y1", Yii::t('app', 'Archivist\'s Note'));
        $sheet->setCellValue("Z1", Yii::t('app', 'Rules or Conventions'));
        $sheet->setCellValue("AA1", Yii::t('app', 'Date of descriptions'));
        $sheet->setCellValue("AB1", Yii::t('app', 'Key HS'));
        $sheet->setCellValue("AC1", Yii::t('app', 'Fund Code'));
        $sheet->setCellValue("AD1", Yii::t('app', 'Node Code'));
        $sheet->setCellValue("AE1", Yii::t('app', 'File'));
        $sheet->getStyle('2')->getFill()->getStartColor()->setRGB('DD33DD');
        $sheet->getStyle('F9')->getFill()->getStartColor()->setRGB('DD33DD');
        $sheet->getRowDimension(3)->setRowHeight(30);
        $item = 0;
        foreach ($fund->attributes as $k => $v) {

            if ($k === 'id' || $k === 'hs_id') {
                continue;
            }
            $sheet->setCellValueByColumnAndRow($item, 2, strip_tags($fund->$k));
            $item++;
        }
        $sheet->setCellValueByColumnAndRow(27, 2, $fund->keyHsTree);
        $sheet->setCellValueByColumnAndRow(29, 2, $fund->code);
        foreach ($records as $k => $record) {
            $node_code = KartikTreeNode::getNoteCode($record->node_id);
            $parent_record_code = FundsController::getCodeRecordParent($record->node_id);
            $fund_code = Funds::findOne($record->fond_id);
            $sheet->getRowDimension($k + 3)->setRowHeight(30);
            $sheet->setCellValueByColumnAndRow(
                0,
                $k + 3,
                $fund_code->code
                . (!empty(str_replace('.', '', $node_code))
                    ? (FundsController::DELIMITER_RECORDS . trim($node_code, FundsController::DELIMITER))
                    : '')
                . (isset($parent_record_code)
                    ? FundsController::DELIMITER_RECORDS . $parent_record_code
                    : '')
                . FundsController::DELIMITER_RECORDS
                . $record->code
            );
            $sheet->setCellValueByColumnAndRow(1, $k + 3, $record->title);
            $sheet->setCellValueByColumnAndRow(2, $k + 3, date('Y-m-d', $record->date));

            $sheet->setCellValueByColumnAndRow(
                3,
                $k + 3,
                $record['final_date'] ? date('Y-m-d', $record->final_date) : ''
            );
            $sheet->setCellValueByColumnAndRow(4, $k + 3, $record->level_description);
            $sheet->setCellValueByColumnAndRow(5, $k + 3, strip_tags($record->extent_description));
            $sheet->setCellValueByColumnAndRow(6, $k + 3, $record->creator);
            $sheet->setCellValueByColumnAndRow(7, $k + 3, strip_tags($record->administrative_history));
            $sheet->setCellValueByColumnAndRow(8, $k + 3, strip_tags($record->archival_history));
            $sheet->setCellValueByColumnAndRow(9, $k + 3, $record->trans);
            $sheet->setCellValueByColumnAndRow(10, $k + 3, strip_tags($record->content));
            $sheet->setCellValueByColumnAndRow(11, $k + 3, strip_tags($record->information));
            $sheet->setCellValueByColumnAndRow(12, $k + 3, $record->accruals);
            $sheet->setCellValueByColumnAndRow(13, $k + 3, $record->arrangement);
            $sheet->setCellValueByColumnAndRow(14, $k + 3, $record->access);
            $sheet->setCellValueByColumnAndRow(15, $k + 3, $record->reproduction);
            $sheet->setCellValueByColumnAndRow(16, $k + 3, $record->language);
            $sheet->setCellValueByColumnAndRow(17, $k + 3, strip_tags($record->characteristics));
            $sheet->setCellValueByColumnAndRow(18, $k + 3, strip_tags($record->aids));
            $sheet->setCellValueByColumnAndRow(19, $k + 3, $record->location_originals);
            $sheet->setCellValueByColumnAndRow(20, $k + 3, $record->location_copies);
            $sheet->setCellValueByColumnAndRow(21, $k + 3, $record->related_units);
            $sheet->setCellValueByColumnAndRow(22, $k + 3, strip_tags($record->publication_note));
            $sheet->setCellValueByColumnAndRow(23, $k + 3, strip_tags($record->note));
            $sheet->setCellValueByColumnAndRow(24, $k + 3, strip_tags($record->archivist_note));
            $sheet->setCellValueByColumnAndRow(25, $k + 3, $record->rules);
            $sheet->setCellValueByColumnAndRow(26, $k + 3, $record->date_descriptions);
            $sheet->setCellValueByColumnAndRow(27, $k + 3, $fund->keyHsTree);
            $sheet->setCellValueByColumnAndRow(28, $k + 3, $fund->code);
            $sheet->setCellValueByColumnAndRow(29, $k + 3, trim($node_code, FundsController::DELIMITER));
            if (!empty($record->files)) {
                $name = explode('/', $record->files[0]->path);
                $sheet->setCellValueByColumnAndRow(30, $k + 3, end($name));
            }
        }
        return $ecxel;
    }

    /**
     * @param $records
     * @return \PHPExcel
     */
    public function addExcelFileNoFond($records)
    {
        $ecxel = new \PHPExcel();
        $ecxel->setActiveSheetIndex(0);
        $sheet = $ecxel->getActiveSheet();
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getRowDimension(2)->setRowHeight(30);
        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(50);
        $sheet->getColumnDimension('M')->setWidth(30);
        $sheet->getColumnDimension('N')->setWidth(30);
        $sheet->getColumnDimension('O')->setWidth(30);
        $sheet->getColumnDimension('P')->setWidth(30);
        $sheet->getColumnDimension('Q')->setWidth(30);
        $sheet->getColumnDimension('R')->setWidth(30);
        $sheet->getColumnDimension('S')->setWidth(30);
        $sheet->getColumnDimension('T')->setWidth(30);
        $sheet->getColumnDimension('U')->setWidth(30);
        $sheet->getColumnDimension('V')->setWidth(30);
        $sheet->getColumnDimension('W')->setWidth(30);
        $sheet->getColumnDimension('X')->setWidth(30);
        $sheet->getColumnDimension('Y')->setWidth(30);
        $sheet->getColumnDimension('Z')->setWidth(30);
        $sheet->getColumnDimension('AA')->setWidth(30);
        $sheet->setTitle($records->full_code);
        $sheet->setCellValue("A1", $records->title);
        $sheet->setCellValue("A2", Yii::t('app', 'Reference code'));
        $sheet->setCellValue("B2", Yii::t('app', 'Title'));
        $sheet->setCellValue("C2", Yii::t('app', 'Date'));
        $sheet->setCellValue("D2", Yii::t('app', 'Final date'));
        $sheet->setCellValue("E2", Yii::t('app', 'Level of description'));
        $sheet->setCellValue("F2", Yii::t('app', 'Extent and medium'));
        $sheet->setCellValue("G2", Yii::t('app', 'Name of creator'));
        $sheet->setCellValue("H2", Yii::t('app', 'Administrative / Biographical history'));
        $sheet->setCellValue("I2", Yii::t('app', 'Archival history'));
        $sheet->setCellValue("J2", Yii::t('app', 'Immediate source of acquisition or trans'));
        $sheet->setCellValue("K2", Yii::t('app', 'Scope and content'));
        $sheet->setCellValue("L2", Yii::t('app', 'Appraisal, destruction and scheduling information'));
        $sheet->setCellValue("M2", Yii::t('app', 'Accruals'));
        $sheet->setCellValue("N2", Yii::t('app', 'System of arrangement'));
        $sheet->setCellValue("O2", Yii::t('app', 'Conditions governing access'));
        $sheet->setCellValue("P2", Yii::t('app', 'Conditions governing reproduction'));
        $sheet->setCellValue("Q2", Yii::t('app', 'Language / scripts of material'));
        $sheet->setCellValue("R2", Yii::t('app', 'Physical characteristics and technical requirements'));
        $sheet->setCellValue("S2", Yii::t('app', 'Finding aids'));
        $sheet->setCellValue("T2", Yii::t('app', 'Existence and location of originals'));
        $sheet->setCellValue("U2", Yii::t('app', 'Existence and location of copies'));
        $sheet->setCellValue("V2", Yii::t('app', 'Related units of description'));
        $sheet->setCellValue("W2", Yii::t('app', 'Publication note'));
        $sheet->setCellValue("X2", Yii::t('app', 'Note'));
        $sheet->setCellValue("Y2", Yii::t('app', 'Archivist\'s Note'));
        $sheet->setCellValue("Z2", Yii::t('app', 'Rules or Conventions'));
        $sheet->setCellValue("AA2", Yii::t('app', 'Date of descriptions'));
        $sheet->getStyle('A1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');
        $sheet->getStyle('2')->getFill()->getStartColor()->setRGB('DD33DD');
        $sheet->getStyle('F9')->getFill()->getStartColor()->setRGB('DD33DD');
        $sheet->getRowDimension(3)->setRowHeight(30);

        $node_code = KartikTreeNode::getNoteCode($records['node_id']);
        $parent_record_code = FundsController::getCodeRecordParent($records['node_id']);
        $fund_code = Funds::findOne($records['fond_id']);
        $sheet->getRowDimension(4)->setRowHeight(30);
        $sheet->setCellValueByColumnAndRow(
            0,
            4,
            $fund_code->code
            . (!empty(str_replace('.', '', $node_code))
                ? (FundsController::DELIMITER_RECORDS . trim($node_code, FundsController::DELIMITER))
                : '')
            . (isset($parent_record_code)
                ? FundsController::DELIMITER_RECORDS . $parent_record_code
                : '')
            . FundsController::DELIMITER_RECORDS
            . $records['code']
        );
        $sheet->setCellValueByColumnAndRow(1, 4, $records['title']);
        $sheet->setCellValueByColumnAndRow(2, 4, date('Y-m-d', $records['date']));

        $sheet->setCellValueByColumnAndRow(
            3,
            4,
            $records['final_date'] ? date('Y-m-d', $records['final_date']) : ''
        );
        $sheet->setCellValueByColumnAndRow(4, 4, $records['level_description']);
        $sheet->setCellValueByColumnAndRow(5, 4, strip_tags($records['extent_description']));
        $sheet->setCellValueByColumnAndRow(6, 4, $records['creator']);
        $sheet->setCellValueByColumnAndRow(7, 4, strip_tags($records['administrative_history']));
        $sheet->setCellValueByColumnAndRow(8, 4, strip_tags($records['archival_history']));
        $sheet->setCellValueByColumnAndRow(9, 4, $records['trans']);
        $sheet->setCellValueByColumnAndRow(10, 4, strip_tags($records['content']));
        $sheet->setCellValueByColumnAndRow(11, 4, strip_tags($records['information']));
        $sheet->setCellValueByColumnAndRow(12, 4, $records['accruals']);
        $sheet->setCellValueByColumnAndRow(13, 4, $records['arrangement']);
        $sheet->setCellValueByColumnAndRow(14, 4, $records['access']);
        $sheet->setCellValueByColumnAndRow(15, 4, $records['reproduction']);
        $sheet->setCellValueByColumnAndRow(16, 4, $records['language']);
        $sheet->setCellValueByColumnAndRow(17, 4, strip_tags($records['characteristics']));
        $sheet->setCellValueByColumnAndRow(18, 4, strip_tags($records['aids']));
        $sheet->setCellValueByColumnAndRow(19, 4, $records['location_originals']);
        $sheet->setCellValueByColumnAndRow(20, 4, $records['location_copies']);
        $sheet->setCellValueByColumnAndRow(21, 4, $records['related_units']);
        $sheet->setCellValueByColumnAndRow(22, 4, strip_tags($records['publication_note']));
        $sheet->setCellValueByColumnAndRow(23, 4, strip_tags($records['note']));
        $sheet->setCellValueByColumnAndRow(24, 4, strip_tags($records['archivist_note']));
        $sheet->setCellValueByColumnAndRow(25, 4, $records['rules']);
        $sheet->setCellValueByColumnAndRow(26, 4, $records['date_descriptions']);
        return $ecxel;
    }

    /**
     * @param array $nodesFromDB
     * @return \PHPExcel
     */
    public function addExcelHs($nodesFromDB)
    {
        $ecxel = new \PHPExcel();
        $ecxel->setActiveSheetIndex(0);
        $sheet = $ecxel->getActiveSheet();
        $sheet->getRowDimension(1)->setRowHeight(40);
        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(50);
        $sheet->getColumnDimension('F')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->setCellValue("A1", Yii::t('app', 'CODE'));
        $sheet->setCellValue("B1", Yii::t('app', 'TITLE'));
        $sheet->setCellValue("C1", Yii::t('app', 'TERM OF ADMINISTRATIVE CONSERVATION'));
        $sheet->setCellValue("D1", Yii::t('app', 'FINAL DESTINATION'));
        $sheet->setCellValue("E1", Yii::t('app', 'DESCRIPTION'));
        $sheet->setCellValue("F1", Yii::t('app', 'NOTES FOR USE'));
        $sheet->setCellValue("G1", Yii::t('app', 'NOTES FOR EXCLUSION'));
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $string = 'A1:G' . count($nodesFromDB);
        $sheet->getStyle($string)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_JUSTIFY);
        $sheet->getStyle('A1:G1')->getFill()->getStartColor()->setRGB('EEEEEE');
        foreach ($nodesFromDB as $k => $node) {
            $sheet->getRowDimension(2 + $k)->setRowHeight(60);
            $sheet->setCellValueByColumnAndRow(0, 2 + $k, $node->getCodePath() . FundsController::DELIMITER);
            $sheet->setCellValueByColumnAndRow(1, 2 + $k, $node->name);
            $sheet->setCellValueByColumnAndRow(2, 2 + $k, $node->hsTreeNode->conservation_term);
            $sheet->setCellValueByColumnAndRow(3, 2 + $k, $node->hsTreeNode->finalDestination->abbreviation);
            $sheet->setCellValueByColumnAndRow(4, 2 + $k, strip_tags($node->hsTreeNode->description));
            $sheet->setCellValueByColumnAndRow(5, 2 + $k, strip_tags($node->hsTreeNode->notes_application));
            $sheet->setCellValueByColumnAndRow(6, 2 + $k, strip_tags($node->hsTreeNode->notes_exclusion));
        }
        unset($nodesFromDB);
        return $ecxel;
    }
}
