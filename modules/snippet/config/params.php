<?php
use modules\snippet\models\Snippet;

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Snippets'), 'url' => ['/snippet'], 'badge' => Snippet::find()->count()],
            ['label' => Yii::t('app', 'Add Snippet'), 'url' => ['/snippet/create']],
        ],
    ],
];
