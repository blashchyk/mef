<?php

namespace modules\i18n\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\ReadOnlyBehavior;

/**
 * This is the model class for table "{{%translation}}".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * @property Message $id0
 */
class Translation extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%i18n_translation}}';
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
            [['language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['translation'], 'filter', 'filter' => 'trim'],
            [['language'], 'string', 'max' => 5]
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
            'translation' => Yii::t('app', 'Translation'),
            'sourceMessage' => Yii::t('app', 'Source Message'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveRecord
     */
    public function setMessage($message)
    {
        return $this->message = $message;
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
        return $this->hasOne(Message::className(), ['id' => 'id']);
    }

    /**
     * @return string
     */
    public function getSourceMessage()
    {
        return !empty($this->message) ? $this->message->message : null;
    }
}
