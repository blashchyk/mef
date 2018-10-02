<?php

namespace modules\hierarchicalStructure\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%hs_final_destination}}".
 *
 * @property integer $id
 * @property string $abbreviation
 * @property string $description
 */
class HsFinalDestination extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hs_final_destination}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['abbreviation', 'description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'abbreviation' => Yii::t('app', 'Abbreviation'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHsTreeNode()
    {
        return $this->hasMany(HsTreeNode::className(), ['final_destination_id' => 'id']);
    }
}
