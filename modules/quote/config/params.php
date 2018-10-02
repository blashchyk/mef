<?php
use modules\quote\models\Quote;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Quotes'), 'url' => ['/quote'], 'badge' => Quote::find()->count()],
            ['label' => Yii::t('app', 'Add Quotes'), 'url' => ['/quote/create']],
        ],
    ],
];
