<?php

namespace common\services;


use modules\hierarchicalStructure\controllers\backend\FundsController;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\KartikTreeNode;

/**
 * Class CodeService
 * @package common\services
 */
class CodeService
{
    /**
     * @param object $record
     * @return string
     */
    public static function getFullCodeRecord($record)
    {
        $node_code = KartikTreeNode::getNoteCode($record->node_id);
        $parent_record_code = FundsController::getCodeRecordParent($record->node_id);
        $fund_code = Funds::findOne($record->fond_id);
        return $fund_code->code . (!empty(str_replace(FundsController::DELIMITER, '', $node_code))
                ? (FundsController::DELIMITER_RECORDS . trim($node_code, FundsController::DELIMITER))
                : '') . (isset($parent_record_code)
                ? FundsController::DELIMITER_RECORDS . $parent_record_code
                : '') . FundsController::DELIMITER_RECORDS . $record->code;
    }
}
