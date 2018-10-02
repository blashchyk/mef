<?php

namespace modules\i18n\controllers\backend;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use modules\i18n\models\Translation;
use modules\i18n\models\Message;
use modules\i18n\models\TranslationSearch;
use common\controllers\BaseController;

/**
 * DefaultController implements the CRUD actions for Translation model.
 */
class DefaultController extends BaseController
{
    /**
     * @return array
     */
    public function permissionMapping()
    {
        return [
            'view' => 'index',
            'update-translation' => 'update',
            'delete-list' => 'delete',
        ];
    }

    /**
     * Lists all Translation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TranslationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Translation model.
     * @param integer $id
     * @param string $language
     * @return mixed
     */
    public function actionView($id, $language)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $language),
        ]);
    }

    /**
     * Creates a new Translation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Translation();
        $model->loadDefaultValues();
        $model->message = new Message();

        if ($model->load(Yii::$app->request->post()) && $model->message->load(Yii::$app->request->post()) && $model->message->save()) {
            $model->id = $model->message->id;
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Translation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $language
     * @return mixed
     */
    public function actionUpdate($id, $language)
    {
        $model = $this->findModel($id, $language);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function actionUpdateTranslation()
    {
        $post = Yii::$app->request->post();

        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!empty($post['hasEditable'])) {
            $key = json_decode($post['editableKey']);
            $attribute = $post['editableAttribute'];
            $index = $post['editableIndex'];
            $value = $post['Translation'][$index][$attribute];
            $model = $this->findModel($key->id, $key->language);
            $model->$attribute = $value;
            if ($model->save()) {
                return [
                    'output' => $value,
                ];
            }
        }

        return [
            'message' => Yii::t('app', 'Saving value error.'),
        ];
    }

    /**
     * Deletes an existing Translation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $language
     * @return mixed
     */
    public function actionDelete($id, $language)
    {
        $this->findModel($id, $language)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes existing User models.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDeleteList()
    {
        $keys = Yii::$app->request->post('ids');
        $success = false;

        if (!empty($keys)) {
            foreach ($keys as $key) {
                $model = $this->findModel($key['id'], $key['language']);
                $success = $model->delete();
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => $success,
        ];
    }

    /**
     * Finds the Translation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $language
     * @return Translation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $language)
    {
        if (($model = Translation::findOne(['id' => $id, 'language' => $language])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
