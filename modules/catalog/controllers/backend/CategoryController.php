<?php

namespace modules\catalog\controllers\backend;

use common\controllers\BaseController;
use Yii;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use modules\catalog\models\Category;
use modules\catalog\models\CategorySearch;

/**
 * CatalogController implements the CRUD actions for Catalog model.
 */
class CategoryController extends BaseController
{

    public function permissionMapping()
    {
        return [
            'view' => 'catalog.backend.category.index',
            'show' => 'catalog.backend.category.update',
            'show-list' => 'catalog.backend.category.update',
            'delete-list' => 'catalog.backend.category.delete',
            'sort' => 'catalog.backend.category.index',
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();
        $model->loadDefaultValues();

        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save(false)) {
            $transaction->commit();
            return $this->redirect(['index']);
        } else {
            $transaction->rollBack();
            return $this->render('create', [
                'model' => $model,
                'activeTab' => Yii::$app->request->get('tab'),
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $transaction = Yii::$app->db->beginTransaction();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save(false)) {
            $transaction->commit();
            return $this->redirect(['index']);
        } else {
            $transaction->rollBack();
            return $this->render('update', [
                'model' => $model,
                'activeTab' => Yii::$app->request->get('tab'),
            ]);
        }
    }

    /**
     * Change the active attribute in Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionShow($id)
    {
        $model = $this->findModel($id);
        $model->reverseVisible();

        return $this->redirect(['index']);
    }

    /**
     * Change the active attribute in Category models.
     * @param bool $active
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionShowList($visible = true)
    {
        $ids = Yii::$app->request->post('ids');
        $success = false;

        foreach ($ids as $id) {
            $model = $this->findModel($id);
            $success = $model->setVisible($visible);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => $success,
        ];
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes existing Category models.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDeleteList()
    {
        $ids = Yii::$app->request->post('ids');
        $success = false;

        foreach ($ids as $id) {
            $model = $this->findModel($id);
            $success = $model->delete();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => $success,
        ];
    }

    /**
     * Get sorted results
     */
    public function actionSort()
    {
        $model = new Category();

        $sortedIds = Yii::$app->request->post('sortedList');
        $success = !empty($sortedIds) ? $model->updateSorting($sortedIds) : null;

        Yii::$app->response->format = Response::FORMAT_JSON;

        return ['success' => $success];
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
