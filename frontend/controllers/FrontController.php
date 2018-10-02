<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use modules\page\models\frontend\Page;
use modules\setting\models\Setting;
use modules\theme\models\Theme;

/**
 * UserController implements the CRUD actions for User model.
 */
class FrontController extends Controller
{
    public function behaviors()
    {
        //заглушка для RBAC
        //пока на фронтенде нет проверок RBAC
        /*return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function () {
                            if (Yii::$app->user->isGuest) {
                                Yii::$app->user->loginRequired();
                            }
                            $controller = Yii::$app->controller->id;
                            $action = Yii::$app->controller->action->id;
                            return Yii::$app->user->can($action);
                        }
                    ],
                ],
            ],
        ];*/

        return [];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        $language = Yii::$app->session->get('language', 'pt');
        Yii::$app->language = $language;

        $slug = Yii::$app->request->pathInfo;
        if (empty($slug)) {
            $slug = $this->defaultAction;
        }

        $routePath = explode('/', $slug);
        $maxSlugLength = 2;
        if (count($routePath) > $maxSlugLength) {
            $slug = $routePath[0] . '/' . $routePath[1];
        }
        $page = Page::getPageBySlug($slug);
        $title = null;

        $view = Yii::$app->view;

        if (!empty($page)) {
            if (!$page->visible) {
                throw new NotFoundHttpException();
            }
            $page->header = !empty($page->header) ? $page->header : $page->link_name;
            $title = !empty($page->title) ? $page->title : $page->header;
            $view->params['page'] = $page;
        }

        $siteTitle = implode(' - ', array_filter([$title, Setting::getValue('site_title')]));
        $metaKeywords = implode(', ', array_filter([!empty($page) ? $page->meta_keywords : null, Setting::getValue('site_meta_keywords')]));
        $metaDescription = implode('. ', array_filter([!empty($page) ? $page->meta_description : null, Setting::getValue('site_meta_description')]));

        $view->title = $siteTitle;
        $view->registerMetaTag(['name' => 'keywords', 'content' => $metaKeywords]);
        $view->registerMetaTag(['name' => 'description', 'content' => $metaDescription]);

        $theme = Theme::getDefault();
        $view->params['theme'] = $theme;

        if (!empty($theme) && $theme->id != Theme::THEME_BASIC) {
            $view->theme->pathMap = [
                '@frontend/views' => '@frontend/themes/' . $theme->slug . '/views',
                '@modules' => '@frontend/themes/' . $theme->slug . '/views',


                //frontend/themes/white/views/frontend/user/
                ///var/www/yii-kit/frontend/themes/colored/views/frontend/user/default/signup.php
            ];

            $view->theme->baseUrl = Yii::getAlias('@image.theme') . '/' . $theme->slug;
            $configPath = Yii::getAlias('@frontend') . '/themes/' . $theme->slug . '/config/config.php';

            if (file_exists($configPath)) {
                require($configPath);
            }
        }

        return parent::beforeAction($action);
    }

    /**
     * @return bool|string
     */
    public function getViewPath()
    {
        $theme = Theme::getDefault();
        if (!empty($theme) && $theme->id != Theme::THEME_BASIC) {
            $viewPath = Yii::getAlias('@frontend/themes/'
                . $theme->slug
                . '/views/frontend/'
                . Yii::$app->controller->module->id . '/'
                . Yii::$app->controller->id);

            if (file_exists($viewPath . '/' . Yii::$app->controller->action->id . '.php')
                    //|| Yii::$app->controller->module->id == 'user'
                    || Yii::$app->controller->action->id == 'content' && file_exists($viewPath . '/' . Yii::$app->request->pathInfo . '.php')) {
                //echo $viewPath;
                //exit();
                return $viewPath;
            }
        }
        return parent::getViewPath();
    }
}
