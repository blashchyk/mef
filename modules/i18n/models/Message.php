<?php

namespace modules\i18n\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%i18n_message}}".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property Translation[] $translations
 */
class Message extends ActiveRecord
{
    const CATEGORY_APP = 'app';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%i18n_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
            [['category'], 'default', 'value' => self::CATEGORY_APP],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getIds()
    {
        return self::find()->select(['id'])->where(['category' => self::CATEGORY_APP])->indexBy('id')->column();
    }
}
