<?php
use modules\country\models\Country;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Countries'), 'url' => ['/country'], 'badge' => Country::find()->count()],
            //['label' => Yii::t('app', 'Add Country'), 'url' => ['/country/create']],
        ],
    ],
];
