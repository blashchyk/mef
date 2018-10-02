<?php

namespace modules\hierarchicalStructure\controllers\backend;


use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\HsTreeNode;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\Records;
use yii\db\Expression;

trait StructureHelper
{
    /**
     * @param integer $fundId
     * @param integer $hs_tree
     * @return array
     */
    public function getAllLowerNodes($fundId, $hs_tree)
    {
        $this->setPhpIniValue();
        $hsTreeId = KartikTreeNode::find()->where(['hs_tree_id' => $hs_tree])
            ->andWhere(['fund_id' => null, 'lft' => new Expression('rgt - 1')])
            ->orWhere(['fund_id' => $fundId])
            ->all();
        foreach ($hsTreeId as $value) {
            $code = $value->getCodePath();
            $nodeId[$value->id] = (substr($code, -1) != FundsController::DELIMITER)
                ? $code . FundsController::PLUS . $value->name
                : $this->getReferenceCode($value, $code);
        }
        asort($nodeId);
        return $nodeId;
    }

    /**
     * @param array $nodeId
     * @return array
     */
    public function getReferenceCode($value, $code)
    {
        $item = 1;
        while (empty($parent = $value->parents($item)->one())) {
            $item++;
        }
        $record = Records::findOne(['node_id' => $value->id]);
        return trim($code, FundsController::DELIMITER) .
            (
                $parent->type == FundsController::RECORD_TYPE
                    ? FundsController::PLUS . $parent->parents(1)->one()->name
                    : ''
            )
            . FundsController::PLUS . $parent->name . FundsController::PLUS . $record->title;
    }

    public function setPhpIniValue()
    {
        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '1024M');
    }

    /**
     * @param string $path
     */
    public function createDirectory($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }


    /**
     * @param $path
     * @return int
     */
    public function versionFile($path)
    {
        $fp = @fopen($path, 'rb');

        if (!$fp) {
            return 0;
        }
        fseek($fp, 0);
        preg_match('/\d\.\d/', fread($fp, 20), $match);
        fclose($fp);
        if (isset($match[0])) {
            return $match[0];
        } else {
            return 0;
        }
    }
}
