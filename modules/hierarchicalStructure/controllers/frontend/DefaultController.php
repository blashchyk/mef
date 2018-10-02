<?php

namespace modules\hierarchicalStructure\controllers\frontend;

use frontend\controllers\FrontController;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\Records;
use modules\hierarchicalStructure\models\SearchRecords;
use yii\web\NotFoundHttpException;

/**
 * Class DefaultController
 * @package modules\hierarchicalStructure\controllers\frontend
 */
class DefaultController extends FrontController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchRecords();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($fundId, $id = null)
    {
        $fund = Funds::findOne($fundId);
        $records = Records::find()->where(['fond_id' => $fund->id])->orderBy(['node_id' => SORT_ASC])->all();
        if (empty($fund)) {
            throw new NotFoundHttpException('Fund is not found!');
        }
        $disabledButtons = [];
        return $this->render('view', [
            'isAdmin' => true,
            'fund' => $fund,
            'disabledButtons' => $disabledButtons,
            'records' => $records,
            'id' => $id,
        ]);
    }
}
