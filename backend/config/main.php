<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'sourceLanguage' => 'en',
    'language' => 'pt',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'homeUrl' => '/admin',
    'bootstrap' => ['log'],
    'defaultRoute' => 'hierarchicalStructure/default/index',
    'components' => [
        'request' => [
            'baseUrl' => '/admin',
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['auth/login']
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => YII_DEBUG ? 'error/error' : 'error/index',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'role' => 'role/index',
                'role/<action:[\w-]+>' => 'role/<action>',
                'user' => 'user/index',
                'user/<action:[\w-]+>' => 'user/<action>',
                '<module:[\w\-]+>' => '<module>/default/index',
                '<module:[\w\-]+>/<id:\d+>/<action:[\w-]+>' => '<module>/default/<action>',
                '<module:[\w\-]+>/<action:[\w-]+>' => '<module>/default/<action>',
                '<module:[\w\-]+>/<controller:\w+>/<id:\d+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '{{%i18n_message}}',
                    'messageTable' => '{{%i18n_translation}}',
                    'sourceLanguage' => 'en',

                ],
                'kvtree*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@vendor/kartik-v/yii2-tree-manager/messages',
                    'forceTranslation' => true
                ],
            ],
        ],
        'assetManager' => [
            'forceCopy' => YII_DEBUG,
        ]
        /*'i18n' => [
            'translations' => [
                'app*' => [
                    'basePath' => '@backend/messages',
                ],
            ],
        ],*/
    ],
    'params' => $params,
    'modules' => require(__DIR__ . '/modules.php'),
];
