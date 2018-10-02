<?php
use modules\setting\models\Setting;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Settings'), 'url' => ['/setting'], 'badge' => Setting::find()->count()],
            //['label' => Yii::t('app', 'Add Setting'), 'url' => ['/setting/create']],
        ],
    ],
];
