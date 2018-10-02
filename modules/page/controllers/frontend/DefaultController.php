<?php
namespace modules\page\controllers\frontend;

use Yii;
use modules\media\models\frontend\Media;
use modules\page\models\frontend\Page;
use modules\page\models\frontend\Category;
use frontend\controllers\FrontController;

/**
 * Blog controller
 */
class DefaultController extends FrontController
{
    /**
     * Displays blog page.
     *
     * @return mixed
     */
    public function actionIndex($slug = null)
    {
        $queryParams = Yii::$app->request->queryParams;

        $pageModel = new Page();
        $categoryModel = new Category();
        $mediaModel = new Media();

        $topPosts = $pageModel->getTopItems();
        $dataProvider = $pageModel->getVisibleItems($slug, $queryParams);
        $categories = $categoryModel->getVisibleItems();
        $images = $mediaModel->getTopItems();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'topPosts' => $topPosts,
            'categories' => $categories,
            'images' => $images,
        ]);
    }

    /**
     *Displays blog post page
     */
    public function actionPost($slug)
    {
        $pageModel = new Page();
        $categoryModel = new Category();
        $mediaModel = new Media();

        $topPosts = $pageModel->getTopItems();
        $categories = $categoryModel->getVisibleItems();
        $images = $mediaModel->getTopItems();

        $model = Page::find()->where(['slug' => $slug])->one();

        return $this->render('post', [
            'model' => $model,
            'topPosts' => $topPosts,
            'categories' => $categories,
            'images' => $images,
        ]);
    }
}
