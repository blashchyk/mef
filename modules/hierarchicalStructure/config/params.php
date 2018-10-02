<?php
use modules\hierarchicalStructure\models\HsTreeNode;

return [
    'params' => [
        'admin_modules' => [
            [
                'label' => Yii::t('app', 'HS'),
                'url' => ['/hierarchicalStructure'],
                'badge' => HsTreeNode::find()->count()
            ],
            [
                'label' => Yii::t('app', 'Import'),
                'url' => ['/hierarchicalStructure/default/upload-excel'],
                'visible' => Yii::$app->user->can('hierarchicalStructure.backend.update')
            ],
            [
                'label' => Yii::t('app', 'Export'),
                'url' => ['/hierarchicalStructure/default/export'],
                'visible' => Yii::$app->user->can('hierarchicalStructure.backend.update')
            ],
            [
                'label' => Yii::t('app', 'API Token'),
                'url' => ['/hierarchicalStructure/token/index']
            ],
        ],
    ],
];
