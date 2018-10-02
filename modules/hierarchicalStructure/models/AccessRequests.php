<?php

namespace modules\hierarchicalStructure\models;


use yii\db\ActiveRecord;

class AccessRequests extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%access_requests}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'code'], 'required'],
            ['email', 'email'],
            [['excel', 'pdf', 'xml', 'confirmation'], 'integer'],
            [['name', 'phone', 'address', 'finality'], 'string', 'max' => 255],
            [['date'], 'integer'],

        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->date = time($this->date);
        return parent::beforeSave($insert);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app', 'Email'),
            'code' => \Yii::t('app', 'Reference code'),
            'excel' => \Yii::t('app', 'Format Excel'),
            'pdf' => \Yii::t('app', 'Format PDF'),
            'xml' => \Yii::t('app', 'Format XML'),
            'confirmation' => \Yii::t('app', 'Confirmation'),
            'name' => \Yii::t('app', 'Name'),
            'phone' => \Yii::t('app', 'Phone'),
            'address' => \Yii::t('app', 'Address'),
            'date' => \Yii::t('app', 'Date'),
            'finality' => \Yii::t('app', 'Finality'),
            'dateFormat' => \Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return false|string
     */
    public function getDateFormat()
    {
        return date('Y-m-d', $this->date);
    }
}
