<?php

namespace modules\hierarchicalStructure\controllers\backend;


use common\controllers\BaseController;
use modules\hierarchicalStructure\models\SearchRecords;
use Yii;
use yii\helpers\Html;

/**
 * Class SearchController
 * @package modules\hierarchicalStructure\controllers\backend
 */
class SearchController extends BaseController
{
    /**
     * @return array
     */
    public function permissionMapping()
    {
        return [
            'index' => 'hierarchicalStructure.backend.index',
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchRecords();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
