<?php

namespace modules\catalog\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\behaviors\TimestampBehavior;
use common\behaviors\CreatorBehavior;
use common\behaviors\SortingBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\behaviors\I18nBehavior;
use common\components\MultipleModel;
use modules\i18n\models\Language;
use common\models\User;

/**
 * This is the model class for table "{{%ctlg_category}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $user_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $visible
 * @property string $sorting
 * @property integer $created_at
 * @property integer $updated_at
 * @property User $user
 * @property CategoryI18n[] $categoryI18ns
 * @property Language[] $languages
 * @property Category $parent
 * @property Category[] $categories
 * @property Product[] $products
 * @property Field[] $fields
 * 
 * @package modules\catalog\models\frontend
 */
class Category extends ActiveRecord
{
    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;

    public $additionalFields = [];

    public static function getVisibilityStatuses()
    {
        return [
            self::VISIBLE_NO => Yii::t('app', 'No'),
            self::VISIBLE_YES => Yii::t('app', 'Yes'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ctlg_category}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            CreatorBehavior::className(),
            SortingBehavior::className(),
            ReadOnlyBehavior::className(),
            [
                'class' => I18nBehavior::className(),
                'i18nModelClass' => CategoryI18n::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'user_id', 'sorting', 'created_at', 'updated_at'], 'integer'],
            [['name', 'slug'], 'required'],
            [['description'], 'string'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['visible'], 'boolean'],
            [['slug'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent Category'),
            'user_id' => Yii::t('app', 'Owner'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'description' => Yii::t('app', 'Description'),
            'visible' => Yii::t('app', 'Visible'),
            'sorting' => Yii::t('app', 'Sorting'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * Init method
     */
    public function init()
    {
        parent::init();

        $this->additionalFields = [new Field()];
    }

    /**
     * After find method
     */
    public function afterFind()
    {
        if (count($this->fields) > 0) {
            $this->additionalFields = $this->fields;
        }

        parent::afterFind();
    }

    /**
     * @return boolean
     */
    public function afterValidate()
    {
        return parent::afterValidate() && MultipleModel::validateMultiple($this->additionalFields);
    }

    /**
     * @param boolean $insert
     * @param mixed $changedAttributes
     * @return boolean
     */
    public function afterSave($insert, $changedAttributes)
    {
        $fieldIds = ArrayHelper::map($this->fields, 'id', 'id');
        $this->additionalFields = MultipleModel::createMultiple(Field::className(), $this->fields);
        MultipleModel::loadMultiple($this->additionalFields, Yii::$app->request->post());
        $fieldDeleteIds = array_diff($fieldIds, array_filter(ArrayHelper::map($this->additionalFields, 'id', 'id')));
        Field::deleteAll(['id' => $fieldDeleteIds]);

        foreach ($this->additionalFields as $field) {
            $field->category_id = $this->id;
            $field->save(false);
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryI18ns()
    {
        return $this->hasMany(CategoryI18n::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['language' => 'language'])->viaTable('{{%ctlg_category_i18n}}', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFields()
    {
        return $this->hasMany(Field::className(), ['category_id' => 'id']);
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
    public static function getList()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }
}
