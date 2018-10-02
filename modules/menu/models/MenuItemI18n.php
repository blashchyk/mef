<?php

namespace modules\menu\models;

use Yii;
use \yii\db\ActiveRecord;
use modules\i18n\models\Language;

/**
 * This is the model class for table "{{%menu_item_i18n}}".
 *
 * @property integer $id
 * @property string $language
 * @property string $link_name
 *
 * @property Language $language0
 * @property MenuItem $menuItem
 */
class MenuItemI18n extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_item_i18n}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['language'], 'string', 'max' => 5],
            [['link_name'], 'string', 'max' => 100],
            [['link_name'], 'trim'],
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
    public function getMenuItem()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'id']);
    }
}
