<?php

namespace backend\controllers;

use common\controllers\BaseController;
use common\models\FormGridIds;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\models\User;
use common\models\UserSearch;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    public function permissionMapping()
    {
        return [
            'update-role' => 'role.update',
            'index' => 'user.index',
            'update' => 'user.update',
            'create' => 'user.create',
            'delete' => 'user.delete',
            'activate' => 'user.update',
            'activate-list'=> 'user.update',
            'delete-list' => 'user.delete',
            'delete-image' => 'user.delete',
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->loadDefaultValues();
        $model->verified = true;
        $model->generateAccessToken();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'activeTab' => Yii::$app->request->get('tab'),
            ]);
        }
    }

    /**
     * Updates role(rbac) by user
     * If update is successful, the browser will be redirected to the 'index' page.
     * @return Response
     */
    public function actionUpdateRole()
    {
        $request = Yii::$app->request;

        if (!$request->isPost) {
            return $this->redirect(['index']);
        }

        $roleName = $request->post('roleName');
        $user = $this->findModel((int) $request->post('id'));

        if (!$user || !Yii::$app->authManager->updateRoleByUser($roleName, $user)) {
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Error update role.'));
        }
        return $this->redirect(['index']);
    }

    /**
     * Change the active attribute in User model.
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $model->reverseActive();

        return $this->redirect(['index']);
    }

    /**
     * Change the active attribute in User models.
     * @param bool $active
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionActivateList($active = true)
    {
        $success = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form = $this->formIds();
        if (!$form) {
            return [
                'success' => false,
            ];
        }

        try {
            foreach ($form->ids as $id) {
                $model = $this->findModel($id);
                $success = $model->setActive($active);
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
            ];
        }

        return [
            'success' => $success,
        ];
    }

    /**
     * Deletes an existing User model.
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
     * Deletes existing User models.
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDeleteList()
    {
        $success = false;
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form = $this->formIds();
        if (!$form) {
            return [
                'success' => false,
            ];
        }

        try {
            foreach ($form->ids as $id) {
                $model = $this->findModel($id);
                $success = $model->delete();
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
            ];
        }

        return [
            'success' => $success,
        ];
    }

    /**
     * Delete image from an existing User model.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteImage($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $success = $this->findModel($id)->deleteImage();
        } catch (\Exception $e) {
            return [
                'success' => false,
            ];
        }

        return [
            'success' => $success,
        ];
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Get form ids. Do not use getFormIds to not create new property
     * @return bool|FormGridIds
     */
    protected function formIds()
    {
        $form = new FormGridIds();
        $form->ids = Yii::$app->request->post('ids', []);

        if (!$form->validate()) {
            return false;
        }

        return $form;
    }
}
