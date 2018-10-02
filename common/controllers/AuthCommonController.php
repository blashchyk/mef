<?php
namespace common\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\components\AuthSocial;
use common\models\forms\LoginForm;
use common\models\User;
use common\models\forms\PasswordResetRequestForm;
use common\models\forms\PasswordForm;

/**
 * Auth controller
 */
class AuthCommonController extends Controller
{
    const SIGNUP_THANK_YOU = 0;
    const SIGNUP_ERROR = 1;
    const SIGNUP_CONFIRMED = 2;
    const SIGNUP_TOKEN_ERROR = 3;
    const PASSWORD_RESET_LINK = 4;
    const PASSWORD_RESET_ERROR = 5;
    const PASSWORD_SAVED = 6;

    const EVENT_USER_LOGIN = 'userLogin';

    /**
     * @param $options
     * @return array
     */
    private static function getMessages($options)
    {
        return [
            self::SIGNUP_THANK_YOU => Yii::t('app', 'Thank you for signup. An activation link is sent to {email} to verify your email address.', $options),
            self::SIGNUP_ERROR => Yii::t('app', 'There is a registering user error. Please correct validation errors.'),
            self::SIGNUP_CONFIRMED => Yii::t('app', 'Your signup is confirmed. Thank you for using our site.'),
            self::SIGNUP_TOKEN_ERROR => Yii::t('app', 'Access token error. Please check your confirmation link.'),
            self::PASSWORD_RESET_LINK => Yii::t('app', 'A reset password link is sent to your email. Please, сheck your email for further instructions.'),
            self::PASSWORD_RESET_ERROR => Yii::t('app', 'Sorry, we are unable to reset password for email provided.'),
            self::PASSWORD_SAVED => Yii::t('app', 'New password is successfully saved. Thank you for using our site.'),
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        $profilePage = Url::to(['/user/profile']);
        if (!Yii::$app->user->isGuest) {
            $profilePage = Url::to(['/user/social']);
        }

        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [new AuthSocial(false, $profilePage), 'onAuthSuccess'],
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        return $this->goHome();
    }

    /**
     * Confirm user signup up.
     *
     * @return mixed
     */
    public function actionConfirmSignup($token)
    {
        $model = User::findIdentityByAccessToken($token);
        /** @var User $model */
        if (!empty($model) && $model->confirmSignup() && Yii::$app->getUser()->login($model)) {
            $this->showMessage(self::SIGNUP_CONFIRMED, null, 'success');
            $this->trigger(self::EVENT_USER_LOGIN);
        } else {
            $this->showMessage(self::SIGNUP_TOKEN_ERROR);
        }
        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                $this->showMessage(self::PASSWORD_RESET_LINK, null, 'success');
                return $this->refresh();
            } else {
                $this->showMessage(self::PASSWORD_RESET_ERROR);
            }
        }

        return $this->render('request_password_reset', [
            'model' => $model
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token = null)
    {

        try {
            $model = new PasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            $this->showMessage(self::PASSWORD_SAVED, null, 'success');
            if ($model->isGuest) {
                return $this->goHome();
            }
            $this->trigger(self::EVENT_USER_LOGIN);
        }

        return $this->render('reset_password', [
            'model' => $model
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
        }

        $id = Yii::$app->user->id;
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * @param $errorId
     * @param array $options
     * @param string $type
     */
    private function showMessage($errorId, $options = [], $type = 'error')
    {
        Yii::$app->getSession()->setFlash($type, [self::getMessages($options)[$errorId]]);
    }
}
