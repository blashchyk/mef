<?php
use modules\mail\models\Mail;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Emails'), 'url' => ['/mail'], 'badge' => Mail::find()->count()],
            ['label' => Yii::t('app', 'Add Email'), 'url' => ['/mail/create']],
        ],
    ],
];
