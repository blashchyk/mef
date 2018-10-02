<?php
namespace modules\dashboard\controllers\backend;

use Yii;
use common\controllers\BaseController;
use common\models\UserSearch;
use modules\page\models\PageSearch;
use modules\catalog\models\ProductSearch;
use modules\order\models\OrderSearch;

/**
 * Default controller for the `dashboard` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $params['pageSize'] = 5;

        $userModel = new UserSearch();
        $pageModel = new PageSearch();
        $productModel = new ProductSearch();
        $orderModel = new OrderSearch();

        $userProvider = $userModel->search($params);
        $pageProvider = $pageModel->search($params);
        $productProvider = $productModel->search($params);
        $orderProvider = $orderModel->search($params);

        return $this->render('index', [
            'userModel' => $userModel,
            'pageModel' => $pageModel,
            'productModel' => $productModel,
            'orderModel' => $orderModel,
            'userProvider' => $userProvider,
            'pageProvider' => $pageProvider,
            'productProvider' => $productProvider,
            'orderProvider' => $orderProvider,
        ]);
    }
}
