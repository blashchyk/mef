<?php

namespace modules\faq\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\TimestampBehavior;
use common\behaviors\I18nBehavior;
use common\behaviors\CreatorBehavior;
use common\behaviors\SortingBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\models\User;
use modules\i18n\models\Language;

/**
 * This is the model class for table "{{%faq_category}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $slug
 * @property string $keywords
 * @property integer $visible
 * @property integer $sorting
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property CategoryI18n[] $categoryI18ns
 * @property Language[] $languages
 * @property Item[] $items
 */
class Category extends ActiveRecord
{
    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;

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
        return '{{%faq_category}}';
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
            [['user_id', 'sorting', 'created_at', 'updated_at'], 'integer'],
            [['visible'], 'boolean'],
            [['name', 'slug'], 'required'],
            [['keywords'], 'string', 'max' => 255],
            [['name', 'slug'], 'string', 'max' => 100],
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
            'user_id' => Yii::t('app', 'User'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'keywords' => Yii::t('app', 'Keywords'),
            'visible' => Yii::t('app', 'Visible'),
            'sorting' => Yii::t('app', 'Sorting'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
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
    /*public function getItems()
    {
        return $this->items;
    }*/

    public function getItemI18ns()
    {
        return $this->hasMany(ItemI18n::className(), ['id' => 'id']);
    }

    public function getCategoryI18ns()
    {
        return $this->hasMany(CategoryI18n::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['language' => 'language'])->viaTable('{{%faq_category_i18n}}', ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['parent_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
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
}
