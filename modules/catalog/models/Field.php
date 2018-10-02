<?php

namespace modules\catalog\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%ctlg_field}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $field
 * @property string $type
 * @property string $sorting
 * @property integer $visible
 *
 * @property Category $category
 * @property ProductField[] $ProductFields
 */
class Field extends ActiveRecord
{
    const TYPE_STRING = 0;
    const TYPE_TEXT = 1;
    const TYPE_BOOLEAN = 2;
    const TYPE_INTEGER = 3;

    public static function getValueTypes()
    {
        return [
            self::TYPE_STRING => Yii::t('app', 'String'),
            self::TYPE_TEXT => Yii::t('app', 'Text'),
            self::TYPE_BOOLEAN => Yii::t('app', 'Boolean'),
            self::TYPE_INTEGER => Yii::t('app', 'Integer'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ctlg_field}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['category_id', 'type', 'sorting', 'visible'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category'),
            'name' => Yii::t('app', 'Name'),
            'type' => Yii::t('app', 'Type'),
            'sorting' => Yii::t('app', 'Sorting'),
            'visible' => Yii::t('app', 'Visible'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductFields()
    {
        return $this->hasMany(ProductField::className(), ['field_id' => 'id']);
    }
}
