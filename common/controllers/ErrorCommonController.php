<?php

namespace common\controllers;

use Yii;
use yii\web\Controller;

class ErrorCommonController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {
            $statusCode = $exception->statusCode;
            $message = $exception->getMessage();
            $name = 'Error (#' . $statusCode . ')';
        } else {
            $message = "You don't have permission to access!";
            $name = 'Error!';
        }

        return $this->render('error', [
            'exception' => $exception,
            'name' => $name,
            'message' => $message
        ]);
    }
}