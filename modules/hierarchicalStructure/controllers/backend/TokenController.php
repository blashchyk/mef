<?php
namespace modules\hierarchicalStructure\controllers\backend;

use common\controllers\BaseController;
use common\services\UserService;
use Yii;

class TokenController extends BaseController
{
    public function permissionMapping()
    {
        return [
            'index' => 'hierarchicalStructure.backend.index',
            'reset-token' => 'hierarchicalStructure.backend.index',
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $userService = new UserService();
        $user = $userService->getCurrentUser();

        return $this->render('index', [
            'user' => $user,
        ]);
    }

    /**
     * @return array|bool
     */
    public function actionResetToken()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!Yii::$app->request->isAjax) {
            return false;
        }

        $userService = new UserService();
        $user = $userService->resetAccessToken();

        if (!$user) {
            return [
                'status' => 'error',
                'message' => Yii::t('app', 'Can`t save user model')
            ];
        }

        return [
            'status' => 'success',
            'message' => Yii::t('app', Yii::t('app', 'The token was successfully overwritten')),
            'newToken' => $user->access_token
        ];
    }
}