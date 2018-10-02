<?php
namespace backend\controllers;

use common\controllers\AuthCommonController;
use common\models\forms\LoginForm;

/**
 * Auth controller
 */
class AuthController extends AuthCommonController
{
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }
}
