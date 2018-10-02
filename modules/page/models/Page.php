<?php

namespace modules\page\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\TimestampBehavior;
use common\behaviors\CreatorBehavior;
use common\behaviors\SortingBehavior;
use common\behaviors\I18nBehavior;
use common\behaviors\ReadOnlyBehavior;
use modules\i18n\models\Language;
use common\models\User;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $user_id
 * @property string $link_name
 * @property string $slug
 * @property integer $sorting
 * @property integer $visible
 * @property string $title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $header
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Category $parent
 * @property PageI18n[] $pageI18ns
 * @property Language[] $languages
 */
class Page extends ActiveRecord
{
    const VISIBLE_NO = 0;
    const VISIBLE_YES = 1;
    const VISIBLE_LOGGED = 2;
    const VISIBLE_NOT_LOGGED = 3;

    public static function getVisibilityStatuses()
    {
        return [
            self::VISIBLE_YES => Yii::t('yii', 'Yes'),
            self::VISIBLE_LOGGED => Yii::t('app', 'Only logged'),
            self::VISIBLE_NOT_LOGGED => Yii::t('app', 'Only not logged'),
            self::VISIBLE_NO => Yii::t('yii', 'No'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
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
                'i18nModelClass' => PageI18n::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug'], 'unique'],
            [['parent_id', 'user_id', 'sorting', 'created_at', 'updated_at'], 'integer'],
            [['link_name', 'slug', 'title', 'meta_keywords', 'meta_description', 'header'], 'trim'],
            [['visible'], 'in', 'range' => range(self::VISIBLE_NO, self::VISIBLE_NOT_LOGGED)],
            [['link_name', 'slug'], 'required'],
            [['content'], 'string'],
            [['link_name', 'slug', 'title', 'meta_keywords', 'meta_description', 'header'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Category'),
            'user_id' => Yii::t('app', 'Owner'),
            'link_name' => Yii::t('app', 'Link Name'),
            'slug' => Yii::t('app', 'Slug'),
            'sorting' => Yii::t('app', 'Sorting'),
            'visible' => Yii::t('app', 'Visible'),
            'title' => Yii::t('app', 'Title'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'header' => Yii::t('app', 'Header'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
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
    public function getPageI18ns()
    {
        return $this->hasMany(PageI18n::className(), ['id' => 'id']);
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
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['language' => 'language'])->viaTable('{{%page_i18n}}', ['id' => 'id']);
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
     * @return Page
     */
    public static function getPageBySlug($slug)
    {
        return self::findOne(['slug' => $slug]);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return self::find()->select(['link_name', 'id'])->indexBy('id')->column();
    }

    public static function getPagesByCategory($categoryId)
    {
        return self::find()->where(['parent_id' => $categoryId])->all();
    }

    /**
     * @return string
     */
    public function getPostsId($id)
    {
        return self::find()->where(['id' => $id])->one();
    }

    /**
     * @return string
     */
    public function getVisibleCategory()
    {
        return $this->hasOne(Category::className(), ['visible' => 'visible']);
    }
}
