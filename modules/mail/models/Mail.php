<?php

namespace modules\mail\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use common\behaviors\TimestampBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\components\Mailer;

/**
 * This is the model class for table "{{%mail}}".
 *
 * @property integer $id
 * @property string $from_email
 * @property string $from_name
 * @property string $subject
 * @property string $body
 * @property integer $opened
 * @property integer $created_at
 * @property integer $updated_at
 */
class Mail extends ActiveRecord
{
    public $verifyCode;

    const OPENED_NO = 0;
    const OPENED_YES = 1;

    const SCENARIO_CONTACT = 'contact';

    public static function getOpenStatuses()
    {
        return [
            self::OPENED_NO => Yii::t('yii', 'No'),
            self::OPENED_YES => Yii::t('yii', 'Yes'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mail}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            ReadOnlyBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_name', 'sender_email', 'subject', 'body'], 'required'],
            [['body'], 'string'],
            [['opened', 'created_at', 'updated_at'], 'integer'],
            [['sender_email', 'sender_name', 'subject'], 'string', 'max' => 255],
            [['sender_email'], 'email'],
            ['verifyCode', 'captcha', 'on' => [self::SCENARIO_CONTACT], 'captchaAction' => '/site/default/captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sender_email' => Yii::t('app', 'Sender Email'),
            'sender_name' => Yii::t('app', 'Sender Name'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Letter Body'),
            'opened' => Yii::t('app', 'Opened'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
            'sender' => Yii::t('app', 'Sender'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * @return boolean
     */
    public function open()
    {
        $this->opened = self::OPENED_YES;
        return $this->save();
    }

    /**
     * @return boolean
     */
    public function send()
    {
        if ($this->save()) {
            return (new Mailer())
                ->sendEmail($this);
        }
        return false;
    }

    /**
     * @param bool $opened
     * @return bool
     */
    public function setOpened($opened = true)
    {
        $this->opened = $opened;
        return $this::save(false);
    }

    /**
     * @return boolean
     */
    public function reverseOpened()
    {
        if ($this->opened) {
            return $this->setOpened(false);
        }
        return $this->setOpened();
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender_name
            . (!empty($this->sender_email) ? ' <' . Html::mailto($this->sender_email, $this->sender_email) . '>' : '');
    }

    public static function initWithDefaults()
    {
        $model = new self();
        if (!Yii::$app->user->isGuest) {
            $model->sender_name = Yii::$app->user->identity->fullName;
            $model->sender_email = Yii::$app->user->identity->email;
        }
        return $model;
    }
}
