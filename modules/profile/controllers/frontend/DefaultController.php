<?php

namespace modules\profile\controllers\frontend;

use Yii;
use yii\web\NotFoundHttpException;
use modules\profile\models\Profile;
use common\controllers\BaseController;

/**
 * DefaultController implements the CRUD actions for Page model.
 */
class DefaultController extends BaseController
{

    /**
     * @return array
     */
    public function permissionMapping()
    {
        return [
            'index' => 'profile.frontend.index',
            'update' => 'profile.frontend.update',
        ];
    }

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $this->findModel(Yii::$app->user->getIdentity()->getId()),
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->getIdentity()->getId());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::find()->where(['user_id' => $id])->with(['user', 'country'])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

}
