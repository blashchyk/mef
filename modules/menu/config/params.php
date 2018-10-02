<?php
use modules\menu\models\Menu;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Menus'), 'url' => ['/menu'], 'badge' => Menu::find()->count()],
            ['label' => Yii::t('app', 'Add Menu'), 'url' => ['/menu/create']],
        ],
    ],
];
