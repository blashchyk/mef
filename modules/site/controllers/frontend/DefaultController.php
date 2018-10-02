<?php
namespace modules\site\controllers\frontend;

use common\components\AuthSocial;
use Yii;
use modules\mail\models\Mail;
use modules\media\models\frontend\Media;
use modules\media\models\frontend\Category;
use modules\page\models\frontend\Page;
use common\models\User;
use modules\catalog\models\frontend\Product;
use modules\quote\models\frontend\Quote;
use frontend\controllers\FrontController;
use yii\helpers\Url;

/**
 * Site controller
 */
class DefaultController extends FrontController
{
    const EMAIL_SENT = 0;
    const EMAIL_ERROR = 1;

    private static function getMessages($options)
    {
        return [
            self::EMAIL_SENT => Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible.'),
            self::EMAIL_ERROR => Yii::t('app', 'There is an sending email error.'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        $profilePage = Url::to(['/']);
        if (!Yii::$app->user->isGuest) {
            $profilePage = Url::to(['/user/social']);
        }

        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [new AuthSocial(false, $profilePage), 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionContent()
    {
        $action = Yii::$app->request->get('action');
        $method = 'action' . ucfirst($action);

        if ($this->hasMethod($method)) {
            return $this->$method();
        }

        return $this->render('@frontend/views/layouts/_page');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $productModel = new Product();
        $products = $productModel->getTopItems(3);

        $pageModel = new Page();
        $blog = $pageModel->getTopItems(4);

        $mediaCategoryModel = new Category();
        $galleryCategory = $mediaCategoryModel->getVisibleItems();
        $mediaModel = new Media();
        $gallery = $mediaModel->getTopItems(4);

        $quoteModel = new Quote();
        $quotes = $quoteModel ->getVisibleItems(3);

        return $this->render('index', [
            'products' => $products,
            'blog' => $blog,
            'gallery' => $gallery,
            'galleryCategory' => $galleryCategory,
            'quotes' => $quotes,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = Mail::initWithDefaults();
        $model->scenario = Mail::SCENARIO_CONTACT;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->send()) {
                $this->showMessage(self::EMAIL_SENT, null, 'success');
                return $this->refresh();
            } else {
                $this->showMessage(self::EMAIL_ERROR);
            }
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $users = User::findAll(['id' => Yii::$app->authManager->getUserIdsByRole('admin')]);

        return $this->render('about', [
            'users' => $users
        ]);
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
