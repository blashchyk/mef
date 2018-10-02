<?php

namespace modules\hierarchicalStructure\models;


use yii\db\ActiveRecord;

class ReportsFiles extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%reports_files}}';
    }

    public function rules()
    {
        return [
            [['file'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'date' => \Yii::t('app', 'Date'),
            'file' => \Yii::t('app', 'File'),
        ];
    }
}
