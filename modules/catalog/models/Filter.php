<?php

namespace modules\catalog\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\SortingBehavior;

/**
 * This is the model class for table "{{%ctlg_filter}}".
 *
 * @property integer $id
 * @property string $field
 * @property string $type
 * @property integer $category_id
 * @property integer $visible
 *
 * @property Category $category
 */
class Filter extends ActiveRecord
{
    const TYPE_STRING = 0;
    const TYPE_TYPEAHEAD = 1;
    const TYPE_RANGE = 2;
    const TYPE_SELECT = 3;
    const TYPE_SELECT2 = 4;
    const TYPE_MULTIPLE = 5;

    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;

    public static function getValueTypes()
    {
        return [
            self::TYPE_STRING => Yii::t('app', 'String'),
            self::TYPE_TYPEAHEAD => Yii::t('app', 'Typeahead'),
            self::TYPE_RANGE => Yii::t('app', 'Range'),
            self::TYPE_SELECT => Yii::t('app', 'Select'),
            self::TYPE_SELECT2 => Yii::t('app', 'Select2'),
            self::TYPE_MULTIPLE => Yii::t('app', 'Multiple'),
        ];
    }

    public static function getVisibilityStatuses()
    {
        return [
            self::VISIBLE_YES => Yii::t('yii', 'Yes'),
            self::VISIBLE_NO => Yii::t('yii', 'No'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ctlg_filter}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            SortingBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field'], 'required'],
            [['type', 'category_id', 'sorting', 'visible'], 'integer'],
            [['field'], 'string', 'max' => 100],
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
            'field' => Yii::t('app', 'Field'),
            'type' => Yii::t('app', 'Type'),
            'category_id' => Yii::t('app', 'Category'),
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
     * @param bool $visible
     * @return bool
     */
    public function setVisible($visible = true)
    {
        $this->visible = $visible;
        return $this::save(false);
    }

    /**
     * @return boolean
     */
    public function reverseVisible()
    {
        if ($this->visible) {
            return $this->setVisible(false);
        }
        return $this->setVisible();
    }

    /**
     * @return array
     */
    /*public static function getAll()
    {
        return self::find()->select(['field', 'id'])->indexBy('id')->column();
    }*/
}
