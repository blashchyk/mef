<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use common\components\Mailer;
use common\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\modules\user\models\User',
                'filter' => ['verified' => User::VERIFIED_YES, 'active' => user::ACTIVE_YES],
                'message' => Yii::t('app', 'There is no user with such email.')
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'verified' => User::VERIFIED_YES,
            'active' => User::ACTIVE_YES,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save(false)) {
                return (new Mailer())->sendPasswordEmail($user);
            }
        }

        return false;
    }
}
