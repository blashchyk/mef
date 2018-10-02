<?php

namespace modules\hierarchicalStructure\models;


use modules\hierarchicalStructure\controllers\backend\FundsController;
use yii\db\ActiveRecord;

/**
 * Class Files
 * @package modules\hierarchicalStructure\models
 */
class Files extends ActiveRecord
{
    public $archive;
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%files}}';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['record_id'], 'integer'],
            ['version', 'safe'],
            [['path', 'type'], 'string', 'max' => 255],
            ['path', 'unique'],
            [['archive'], 'file', 'extensions' => 'zip'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'path' => \Yii::t('app', 'Upload file'),
            'total' => \Yii::t('app', 'Total'),
            'extension' => \Yii::t('app', 'Extension'),
            'archive' => \Yii::t('app', 'Archive download')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(Records::className(), ['id' => 'record_id']);
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return Files::find()->where(['type' => $this->type, 'version' => $this->version])->count();
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        $type = Files::findOne(['type' => $this->type]);
        $array = explode(FundsController::DELIMITER, $type->path);
        return end($array);
    }
}
