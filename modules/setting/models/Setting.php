<?php

namespace modules\setting\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\ReadOnlyBehavior;

/**
 * This is the model class for table "{{%setting}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $value_type
 * @property string $title
 * @property string $key
 * @property string $value
 */
class Setting extends ActiveRecord
{
    const TYPE_CUSTOM = 0;
    const TYPE_SYSTEM = 1;

    const TYPE_YES = 0;
    const TYPE_NO = 1;

    const TYPE_STRING = 0;
    const TYPE_TEXT = 1;
    const TYPE_BOOLEAN = 2;
    const TYPE_INTEGER = 3;
    const TYPE_EMAIL = 4;

    public static $allSettings = null;

    public static function getTypes()
    {
        return [
            self::TYPE_SYSTEM => Yii::t('app', 'System'),
            self::TYPE_CUSTOM => Yii::t('app', 'Custom'),
        ];
    }

    public static function getBooleanTypes()
    {
        return [
            self::TYPE_YES => Yii::t('app', 'Yes'),
            self::TYPE_NO => Yii::t('app', 'No'),
        ];
    }

    public static function getValueTypes()
    {
        return [
            self::TYPE_STRING => Yii::t('app', 'String'),
            self::TYPE_TEXT => Yii::t('app', 'Text'),
            self::TYPE_BOOLEAN => Yii::t('app', 'Boolean'),
            self::TYPE_INTEGER => Yii::t('app', 'Integer'),
            self::TYPE_EMAIL => Yii::t('app', 'Email'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            ReadOnlyBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'value_type'], 'integer'],
            [['title', 'key'], 'required'],
            [['title', 'key', 'value'], 'trim'],
            [['title', 'key', 'value'], 'string', 'max' => 100],
            ['value', 'integer',
                'when' => function ($model) { return $model->value_type == Setting::TYPE_INTEGER; },
                'whenClient' => 'function (attribute, value) { return ' . $this->value_type == Setting::TYPE_INTEGER . ';}'
            ],
            ['value', 'boolean',
                'when' => function ($model) { return $model->value_type == Setting::TYPE_BOOLEAN; },
                'whenClient' => 'function (attribute, value) { return ' . $this->value_type == Setting::TYPE_BOOLEAN . ';}'
            ],
            ['value', 'email',
                'when' => function ($model) { return $model->value_type == Setting::TYPE_EMAIL; },
                'whenClient' => 'function (attribute, value) { return ' . $this->value_type == Setting::TYPE_EMAIL . ';}'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'value_type' => Yii::t('app', 'Value Type'),
            'title' => Yii::t('app', 'Title'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return self::getTypes()[$this->type];
    }

    /**
     * @return string
     */
    public function getValueTypeName()
    {
        return self::getValueTypes()[$this->value_type];
    }

    /**
     * @return mixed
     */
    public static function getValue($key)
    {
        //return self::find()->select(['value'])->where(['key' => $key])->scalar();
        if (empty(self::$allSettings)) {
            self::$allSettings = self::find()->select(['value', 'key'])->indexBy('key')->column();
        }

        return !empty(self::$allSettings[$key]) ? self::$allSettings[$key] : null;
    }
}
