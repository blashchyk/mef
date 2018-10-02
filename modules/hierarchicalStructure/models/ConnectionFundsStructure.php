<?php

namespace modules\hierarchicalStructure\models;


use yii\db\ActiveRecord;
use yii\web\ForbiddenHttpException;

class ConnectionFundsStructure extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%connection_funds_structure}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['fund_id', 'hs_id'], 'safe'],
        ];
    }
}
