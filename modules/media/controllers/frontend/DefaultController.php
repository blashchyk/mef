<?php
namespace modules\media\controllers\frontend;

use modules\media\models\frontend\Media;
use modules\media\models\frontend\Category;
use frontend\controllers\FrontController;

/**
 * Gallery controller
 */
class DefaultController extends FrontController
{
    /**
     * Displays index page.
     *
     * @return mixed
     */
    public function actionIndex($slug = null)
    {
        $model = new Media();
        $categoryModel = new Category();
        $dataProvider = $model->getVisibleItems($slug);
        $categories = $categoryModel->getVisibleItems();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categories' => $categories,
        ]);
    }
}
