<?php
namespace modules\site\controllers\backend;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use common\components\AuthSocial;
use common\controllers\BaseController;

/**
 * Site controller
 */
class DefaultController extends BaseController
{
    const PASSWORD_RESET_LINK = 4;
    const PASSWORD_RESET_ERROR = 5;
    const PASSWORD_SAVED = 6;

    private static function getMessages($options)
    {
        return [
            self::PASSWORD_RESET_LINK => Yii::t('app', 'A reset password link is sent to your email. Please, сheck your email for further instructions.'),
            self::PASSWORD_RESET_ERROR => Yii::t('app', 'Sorry, we are unable to reset password for email provided.'),
            self::PASSWORD_SAVED => Yii::t('app', 'New password is successfully saved. Thank you for using our site.'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'auth', 'language'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $profilePage = Url::to(['/user/default/update', 'id' => Yii::$app->user->id, 'tab' => 'networks']);
        $loginPage = Url::to(['/auth/login']);

        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [new AuthSocial(true, $profilePage, $loginPage), 'onAuthSuccess'],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Change Language.
     *
     * @return mixed
     */
    public function actionLanguage($language)
    {
        Yii::$app->session->set('language', $language);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionReadOnly()
    {
        return $this->render('read_only');
    }

    private function showMessage($errorId, $options = [], $type = 'error')
    {
        Yii::$app->getSession()->setFlash($type, [self::getMessages($options)[$errorId]]);
    }
}
