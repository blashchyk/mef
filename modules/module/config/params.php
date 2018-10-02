<?php
use modules\module\models\Module;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Modules'), 'url' => ['/module'], 'badge' => Module::find()->count()],
            //['label' => Yii::t('app', 'Add Module'), 'url' => ['/module/create']],
        ],
    ],
];
