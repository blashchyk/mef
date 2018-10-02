<?php
use modules\profile\models\Profile;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Profiles'), 'url' => ['/profile'], 'badge' => Profile::find()->count()],
        ],
    ],
];
