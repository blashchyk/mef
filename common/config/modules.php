<?php

$modules = [
    'gridview' =>  [
        'class' => '\kartik\grid\Module',
    ],
    'datecontrol' =>  [
        'class' => '\kartik\datecontrol\Module'
    ],
    'treemanager' =>  [
        'class' => '\kartik\tree\Module',
        'treeViewSettings' => [
            'displayValue' => 0,
            'fontAwesome' => false,
            'softDelete' => true,
            'showIDAttribute' => false,
            //'breadcrumbs' => ['glue' => ' / '],
            'iconEditSettings' => ['show' => 'none'],
        ]
    ],
];

return $modules;
