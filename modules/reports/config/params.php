<?php

return [
    'params' => [
        'admin_modules' => [
            [
                'label' => Yii::t('app', 'Elimination records'),
                'url' => ['/hierarchicalStructure/reports/eol'],
                'visible' => Yii::$app->user->can('hierarchicalStructure.reports.index')
            ],
            [
                'label' => Yii::t('app', 'Elimination reports'),
                'url' => ['/hierarchicalStructure/reports/elimination'],
                'visible' => Yii::$app->user->can('hierarchicalStructure.reports.index')
            ],
        ],
    ],
];
