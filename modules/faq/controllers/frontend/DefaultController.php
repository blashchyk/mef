<?php
namespace modules\faq\controllers\frontend;

use modules\faq\models\frontend\Category;
use frontend\controllers\FrontController;

/**
 * FAQ Controller
 */
class DefaultController extends FrontController
{
    /**
     * Displays FAQ page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Category();
        $dataProvider = $model->getVisibleItems();

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }
}
