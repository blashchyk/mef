<?php
namespace common\models\forms;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password edit form
 */
class PasswordForm extends Model
{
    public $password;
    public $confirm_password;
    public $old_password;

    public $identity;
    public $isGuest;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token = null, $config = [])
    {
        $this->isGuest = Yii::$app->user->isGuest || !empty($token);
        if (!$this->isGuest) {
            $this->identity = Yii::$app->user->identity;
        } elseif (!empty($token) && is_string($token)) {
            $this->identity = User::findByPasswordResetToken($token);
            if (!$this->identity) {
                throw new InvalidParamException(Yii::t('app', 'Wrong password reset token.'));
            }
        }
        parent::__construct($config);
    }

    /**
     * @inheritdocm
     */
    public function rules()
    {
        return [
            [['password', 'confirm_password'], 'required'],
            [['password', 'confirm_password', 'old_password'], 'string', 'min' => 6],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
            [['old_password'], 'required',
                'when' => function ($model) { return !$model->isGuest && !empty($model->identity->password_hash); },
                'whenClient' => 'function (attribute, value) { return ' . (!$this->isGuest && !empty($this->identity->password_hash)) . '; }',
            ],
            [['old_password'], 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->isGuest && !$this->identity->validatePassword($this->old_password)) {
            $this->addError($attribute, Yii::t('app', 'Old Password is incorrect.'));
        }
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        return $this->identity->resetPassword($this->password);
    }
}
