<?php
use modules\slider\models\Slider;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Slider'), 'url' => ['/slider'], 'badge' => Slider::find()->count()],
            ['label' => Yii::t('app', 'Add Slider'), 'url' => ['/slider/create']],
        ],
    ],
];
