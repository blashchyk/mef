<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => 'Yii2 CMS',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'homeUrl' => '/',
    'defaultRoute' => 'hierarchicalStructure',
    'components' => [
        'request' => [
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['/auth/login']
        ],
        'errorHandler' => [
            'errorAction' => YII_DEBUG ? 'error/error' : 'error/index',
        ],
        'urlManager' => [
            'rules' => [
                //'<action:\w+>/'=>'site/content/',
                //'<controller:\w+>/<action:\w+>/<slug>' => '<controller>/<action>',
                'profile/<action:[\w-]+>' => 'profile/default/<action>',
                'blog/<action:\w+>' => 'page/default/<action>',
                'gallery/<action:\w+>' => 'media/default/<action>',
                'site/captcha' => 'site/default/captcha',

                '<module:[\w\-]+>' => '<module>/default/index',
                '<module:[\w\-]+>/<action>' => '<module>/default/<action>',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'trace'],
                    'logVars' => ['_COOKIE', '_SESSION'],
                ],
            ],
        ],
        'view' => [
            'theme' => [
                //'basePath' => '@frontend/themes/white/css',
                //'baseUrl' => '@frontend/themes/white',
                'pathMap' => [
                    '@frontend/views' => '@frontend/views',
                ],
            ],
        ],
        'assetManager' => [
            'forceCopy' => YII_DEBUG,
        ]
    ],
    'params' => $params,
    'modules' => require(__DIR__ . '/modules.php'),
];
