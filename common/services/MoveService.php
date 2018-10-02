<?php

namespace common\services;


use modules\hierarchicalStructure\controllers\backend\FundsController;
use modules\hierarchicalStructure\models\HsTreeNode;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\Records;
use Yii;
use yii\db\Expression;

/**
 * Class MoveService
 * @package common\services
 */
class MoveService
{
    /**
     * @param $move_node
     * @return string
     */
    public static function transferToRoot($move_node)
    {
        $parent = KartikTreeNode::find()->where(
            [
                'hs_tree_id' => $move_node->hs_tree_id,
                'id' => new Expression('root')
            ]
        )->all();
        foreach ($parent as $item) {
            $roots[$item->id] = $item->getCodePath();
        }
        $root_reference_code = $move_node->getCodePath();
        $root_code = explode(FundsController::DELIMITER, $root_reference_code);

        if (!array_search(end($root_code), $roots)) {
            $move_node->makeRoot();
            return Yii::t('app', 'The node is moved to the root');
        }
        return Yii::t('app', 'A node with which code already exists');
    }

    /**
     * @param $move_node
     * @param $internal_node_id
     * @return string
     */
    public static function movingInsideNodes($move_node, $internal_node_id)
    {
        $root_parent = KartikTreeNode::findOne($internal_node_id);
        if ($move_node->type == FundsController::NODE_TYPE && $root_parent->type == FundsController::RECORD_TYPE) {
            return Yii::t('app', 'You can not move nodes to a record');
        }
        $childrens = $root_parent->children(1)->all();
        foreach ($childrens as $children) {
            if (
                $children->type == FundsController::RECORD_TYPE
                &&
                $root_parent->type == FundsController::NODE_TYPE
                && $move_node->type == FundsController::NODE_TYPE
            ) {
                return Yii::t('app', 'You can not move to the lower node that has a record');
            } elseif (
                $move_node->type == FundsController::RECORD_TYPE
                &&
                $root_parent->type == FundsController::NODE_TYPE
            ) {
                $codes = self::getCodeChildrens($root_parent->id);
            } else {
                $children_reference_code = explode(FundsController::DELIMITER, $children->getCodePath());
                $codes[$children->id] = end($children_reference_code);
            }
        }
        if ($codes !== null) {
            self::saveNode($move_node, $codes);

        } else {
            $move_node->prependTo($root_parent);
            $parents = KartikTreeNode::findOne($move_node->id)->parents(1)->all();
            $hs_tree_node = HsTreeNode::findOne($parents[0]->id);
            $move_node->hsTreeNode->conservation_term = $hs_tree_node->conservation_term;
            $move_node->hsTreeNode->final_destination_id = $hs_tree_node->final_destination_id;
            $move_node->hsTreeNode->save();
        }
        self::changeFullCodeRecords($move_node);
        return Yii::t('app', 'The node is moved');
    }

    /**
     * @param $move_node
     */
    public static function changeFullCodeRecords($move_node)
    {
        $parent = KartikTreeNode::findOne($move_node->id)->parents(1)->one();
        $childrens = $parent->children()->all();
        foreach ($childrens as $children) {
            if ($children->type == FundsController::RECORD_TYPE) {
                $record = Records::findOne(['node_id' => $children->id]);
                $record->full_code = CodeService::getFullCodeRecord($record);
                $record->date = date('Y-m-d', $record->date);
                $record->final_date = $record->final_date ? date('Y-m-d', $record->final_date) : '';
                $record->save();
            }
        }
    }

    /**
     * @param $move_node
     * @param array $codes
     */
    public static function saveNode($move_node, array $codes)
    {

        $item = 1;
        $root_code = explode(
            FundsController::DELIMITER,
            KartikTreeNode::findOne($move_node->id)->getCodePath()
        );
        if (end($root_code) == '') {
            $root_code[] = Records::findOne(['node_id' => $move_node->id])->code;
        }
        foreach ($codes as $k => $code) {
            if (end($root_code) > $code && $item == count($codes)) {
                $move_node->insertAfter(KartikTreeNode::findOne($k));
                return;
            } elseif (end($root_code) < $code && $item <= count($codes)) {
                $move_node->insertBefore(KartikTreeNode::findOne($k));
                return;
            } else {
                $item++;
            }
        }
    }

    /**
     * @param integer $parent
     * @return array
     */
    public static function getCodeChildrens($parent)
    {
        $childrens =KartikTreeNode::findOne($parent)->children(1)->all();
        foreach ($childrens as $children) {
            $codes[$children->id] = Records::findOne(['node_id' => $children->id])->code;
        }
        return $codes;
    }
}
