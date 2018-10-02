<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    //require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
    //require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'homeUrl' => '/api',
    'bootstrap' => ['log'],
    'defaultRoute' => '',
    'components' => [
        'request' => [
            'baseUrl' => '/api',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',

            ],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'loginUrl' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@api/runtime/logs',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['api_request'],
                    'logFile' => '@api/runtime/requests',
                    'logVars' => [],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'error/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                'GET <format:(json|xml)>/hs/list' => 'hierarchicalStructure/hs/list-hs',
                'GET <format:(json|xml)>/hs/<hsKey:[a-zA-Z0-9]{3,16}>/0' => 'hierarchicalStructure/hs/list-root-nodes',
                'GET <format:(json|xml)>/hs/<hsKey:[a-zA-Z0-9]{3,16}>/<codePath:[+-]?\d+\.?\d*>' => 'hierarchicalStructure/hs/list-child',
            ],
        ],
    ],
    'params' => $params,
    'modules' => require(__DIR__ . '/modules.php'),
];
