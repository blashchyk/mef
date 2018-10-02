<?php

namespace modules\page\models;

use Yii;
use yii\db\ActiveRecord;
use modules\i18n\models\Language;

/**
 * This is the model class for table "{{%page_i18n}}".
 *
 * @property integer $id
 * @property string $language
 * @property string $link_name
 * @property string $title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $header
 * @property string $content
 *
 * @property Language $language0
 * @property Page $page
 */
class PageI18n extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_i18n}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['content'], 'string'],
            [['language'], 'string', 'max' => 5],
            [['link_name', 'title', 'meta_keywords', 'meta_description', 'header'], 'string', 'max' => 100],
            [['link_name', 'title', 'meta_keywords', 'meta_description', 'header'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'link_name' => Yii::t('app', 'Link Name'),
            'title' => Yii::t('app', 'Page Title'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'header' => Yii::t('app', 'Header'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['language' => 'language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'id']);
    }
}
