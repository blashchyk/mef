<?php

namespace modules\snippet\models;

use modules\i18n\models\Language;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%snippet_i18n}}".
 *
 * @property integer $id
 * @property string $language
 * @property string $content
 *
 * @property Language $language0
 * @property Snippet $id0
 */
class SnippetI18n extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%snippet_i18n}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['content'], 'string'],
            [['language'], 'string', 'max' => 5],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language' => 'language']],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Snippet::className(), 'targetAttribute' => ['id' => 'id']],
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
    public function getId()
    {
        return $this->hasOne(Snippet::className(), ['id' => 'id']);
    }
}
