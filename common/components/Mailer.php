<?php

namespace common\components;

use Yii;
use yii\base\Object;
use modules\setting\models\Setting;

class Mailer extends Object
{
    private $adminEmail = 'admin@test.com';
    private $adminName = 'Admin';

    const SUBJECT_SIGNUP = 0;
    const SUBJECT_PASSWORD_RESET = 1;

    /**
     * Mailer constructor.
     * @param null $config
     */
    public function __construct($config = null)
    {
        $adminEmail = Setting::getValue('admin_email');
        $adminName = Setting::getValue('admin_name');

        if (!empty($adminEmail)) {
            $this->adminEmail = $adminEmail;
        }
        if (!empty($adminName)) {
            $this->adminName = $adminName;
        }

        parent::__construct($config);
    }

    /**
     * @return array
     */
    private static function getSubjects()
    {
        return [
            self::SUBJECT_SIGNUP => Yii::t('app', 'Signup Confirmation'),
            self::SUBJECT_PASSWORD_RESET => Yii::t('app', 'Password Reset Link'),
        ];
    }

    /**
     * @param $mail
     * @return bool
     */
    public function sendEmail($mail)
    {
        return Yii::$app->mailer->compose()
            ->setTo($this->adminEmail)
            ->setFrom([$mail->sender_email => $mail->sender_name])
            ->setSubject(Yii::$app->name . ': ' . $mail->subject)
            ->setTextBody($mail->body)
            ->send();
    }

    /**
     * @param $user
     * @return bool
     */
    public function sendSignupEmail($user)
    {
        return Yii::$app->mailer->compose(['html' => 'signup-html', 'text' => 'signup-text'], ['user' => $user])
            ->setTo($user->email)
            ->setFrom([$this->adminEmail => $this->adminName])
            ->setSubject($this->getSubject(self::SUBJECT_SIGNUP))
            ->send();
    }

    /**
     * @param $user
     * @return $this
     */
    public function sendPasswordEmail($user)
    {
        $receiverEmail = $user->email;
        $receiverName = $user->username;
        $adminName = $this->adminName;
        $adminEmail = $this->adminEmail;
        $subject = $this->getSubject(self::SUBJECT_PASSWORD_RESET);
        $message = Yii::$app->mailer->compose('passwordReset-html', ['user' => $user])
            ->setTo([$receiverEmail => $receiverName])
            ->setFrom([$adminEmail => $adminName])
            ->setSubject("$subject");
        $message->send();
        return $message;
    }

    /**
     * @param $subjectCode
     * @return string
     */
    private function getSubject($subjectCode)
    {
        return Yii::$app->name . ': ' . self::getSubjects()[$subjectCode];
    }
}
