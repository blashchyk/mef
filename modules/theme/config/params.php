<?php
use modules\theme\models\Theme;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Themes'), 'url' => ['/theme'], 'badge' => Theme::find()->count()],
            ['label' => Yii::t('app', 'Add Theme'), 'url' => ['/theme/create']],
        ],
    ],
];
