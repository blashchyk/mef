<?php
use modules\order\models\Order;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Orders'), 'url' => ['/order'], 'badge' => Order::find()->count()],
        ],
    ],
];
