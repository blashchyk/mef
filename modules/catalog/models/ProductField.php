<?php

namespace modules\catalog\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%ctlg_product_field}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $field_id
 * @property string $value
 *
 * @property CtlgField $field
 * @property CtlgProduct $product
 */
class ProductField extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ctlg_product_field}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'field_id'], 'required'],
            [['product_id', 'field_id'], 'integer'],
            [['value'], 'string', 'max' => 255,
                //'when' => function($model) { return !is_int($model->value); },
                //'whenClient' => 'function (attribute, value) { alert($("#productfield-12-value").val()); return true; }',
            ],
            //[['value'], 'integer'],
            [['field_id'], 'exist', 'skipOnError' => true, 'targetClass' => Field::className(), 'targetAttribute' => ['field_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product'),
            'field_id' => Yii::t('app', 'Field'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @param $field
     * @return array
     */
    public function getValueListSelect($field)
    {
        $fieldId = preg_replace('/[^0-9]/', '', $field);
        $field = 'value';

        $query = $this->find()->select([$field, $field])
            ->where(['field_id' => $fieldId])
            ->orderBy($field);

        return $query->indexBy($field)->column();
    }
}
