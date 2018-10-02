<?php
namespace modules\catalog\controllers\frontend;

use Yii;
use yii\web\Response;
use modules\catalog\models\frontend\Category;
use modules\catalog\models\frontend\Product;
use frontend\controllers\FrontController;

/**
 * Site controller
 */
class DefaultController extends FrontController
{
    /**
     * Displays Category Page.
     *
     * @return mixed
     */
    public function actionIndex($slug = null)
    {
        $queryParams = Yii::$app->request->queryParams;

        $categoryModel = new Category();
        $productModel = new Product();

        $selectedCategory = null;
        if (!empty($queryParams['Product']['slug'])) {
            $slug = $queryParams['Product']['slug'];
        }
        if (!empty($slug)) {
            $selectedCategory = Category::find()->where(['slug' => $slug])->one();
            $productModel->slug = $slug;
        }

        $dataProvider = $productModel->getVisibleItemList($queryParams);
        $сategories = $categoryModel->getVisibleItems();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'сategories' => $сategories,
            'selectedCategory' => $selectedCategory,
            'productModel' => $productModel,
        ]);
    }

    /**
     * Display single product page
     */
    public function actionProduct($slug)
    {
        $productModel = new Product();
        $topImages = $productModel->getTopItems();
        $model = Product::find()->where(['slug' => $slug])->one();

        return $this->render('product', [
            'model' => $model,
            'topImages' => $topImages,
        ]);
    }

    /**
     * @param $field
     * @param $query
     * @return array
     */
    public function actionValueList($field, $query, $slug = null)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Product();
        $model->slug = $slug;
        return $model->getValueListHelper($field, $query);
    }
}
