<?php

use kartik\datecontrol\Module;

$config = [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'sourceLanguage' => 'en',
    'language' => 'pt',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=dbname',
            'username' => 'username',
            'password' => 'password',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                //'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                'auth/<action:[\w-]+>' => 'auth/<action>',
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
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    //https://console.developers.google.com/apis/credentials?project=yii2-cms
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '882986957416-kjngefqsqq937pmldbuk4ec20b943ius.apps.googleusercontent.com',
                    'clientSecret' => 'vsHz7lkEqOQq5WEFvRyh2ksh',
                ],
                'facebook' => [
                    //https://developers.facebook.com/apps/1677872889155104/dashboard/
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '1677872889155104',
                    'clientSecret' => '79b3e34fe33a78d7b3d6f18c3c08cde9',
                ],
                'twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
                    'consumerKey' => 'YFY3D4L6C2xNI0WpNtZYVIwPt',
                    'consumerSecret' => 'RbQgeHVU2AP1cGnTsWHK9sh0cjwGc2cTnyhtlE8d3EOjbxk3vL',
                ],
                'vkontakte' => [
                    //http://vk.com/editapp?id=5225211&section=info
                    'class' => 'yii\authclient\clients\VKontakte',
                    'clientId' => '5225211',
                    'clientSecret' => 'wzefF2RwBDU5TnJpL1Yq',
                ],
                /*'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                ],
                'linkedin' => [
                    'class' => 'yii\authclient\clients\LinkedIn',
                ],
                'live' => [
                    'class' => 'yii\authclient\clients\Live',
                ],
                'yandexOpenId' => [
                    'class' => 'yii\authclient\clients\YandexOpenId',
                    //'class' => 'yii\authclient\clients\YandexOAuth',
                ],*/
            ],
        ],
        'storage' => [
            'class' => 'common\components\Storage',
        ],
        'authManager' => [
            'class' => 'common\rbac\DbIcoManager',
        ],
        /*'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['user','moder','admin'], // здесь прописываем роли
            // зададим куда будут сохраняться наши файлы конфигураций RBAC
            'itemFile' => '@common/components/rbac/items.php',
            'assignmentFile' => '@common/components/rbac/assignments.php',
            'ruleFile' => '@common/components/rbac/rules.php'
        ],*/
        'formatter' => [
            'datetimeFormat' => 'php:M d, Y H:i',
            'nullDisplay' => '',
            //'dateFormat' => 'dd.MM.yyyy',
            //'decimalSeparator' => ',',
            //'thousandSeparator' => ' ',
            'currencyCode' => 'USD',
        ],
        'paypal' => [
            'class' => 'common\components\PayPal',
            'clientId' => 'AWPb8IKXmaW5j9e8j4SpT5cyTeAjFFRS6wWtK3eF8sdibVGiWoQXG5svT-ugbnL0iwP_u6JZ2sexxsrC',
            'clientSecret' => 'EMnk9X8m_X4g9JzyhyfCgGjaS-0Qf8zwJb5d4yIJL7hLOx8P-Ne6JcQ1ANua5jNk2F8YMM9J05W3G5ZM',
        ],
    ],
    'params' => [
        // format settings for displaying each date attribute (ICU format example)
        'dateControlDisplay' => [
            Module::FORMAT_DATE => 'php:M d, Y',
            Module::FORMAT_TIME => 'HH:mm:ss',
            //Module::FORMAT_DATETIME => 'dd-MM-yyyy hh:mm:ss a',
        ],

        // format settings for saving each date attribute (PHP format example)
        'dateControlSave' => [
            Module::FORMAT_DATE => 'php:U',
            Module::FORMAT_TIME => 'php:H:i:s',
            //Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
        ],
        'autoWidgetSettings' => [
            Module::FORMAT_DATE => ['pluginOptions' => [
                'autoclose' => true,
                'dateSettings' => [
                    'longDays' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    'shortDays' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    'shortMonths' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'longMonths' => ['January', 'February', 'March', 'April', 'May', 'June',
                        'July', 'August', 'September', 'October', 'November', 'December'],
                    'meridiem' => ['AM', 'PM']
                ]
            ]],
        ],
    ],
    'bootstrap' => require(__DIR__ . '/modules-bootstrap.php'),
    'modules' => require(__DIR__ . '/modules.php'),
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*' ,  '192.168.56.*', '75.157.241.9'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class' => 'generators\crud\Generator',
                'templates' => [
                    'cms' => '@generators/crud/cms',
                ]
            ],
            'model' => [
                'class' => 'generators\model\Generator',
                'templates' => [
                    'cms' => '@generators/model/cms',
                ]
            ]
        ],
    ];
}

return $config;
