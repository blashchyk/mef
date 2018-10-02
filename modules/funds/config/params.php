<?php

return [
    'params' => [
        'admin_modules' => [
            ['label' => Yii::t('app', 'Funds'), 'url' => ['/hierarchicalStructure/funds/index']],
            ['label' => Yii::t('app', 'Import'), 'url' => ['/hierarchicalStructure/funds/import']],
            ['label' => Yii::t('app', 'Export'), 'url' => ['/hierarchicalStructure/funds/export']],
            ['label' => Yii::t('app', 'Search'), 'url' => ['/hierarchicalStructure/search/index']],
        ],
    ],
];
