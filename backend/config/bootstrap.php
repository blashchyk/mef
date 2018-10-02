<?php
use kartik\grid\GridView;

\Yii::$container->set('yii\grid\GridView', [
    'layout' => "{items}\n{pager}", // "{summary}\n{items}\n{pager}"
]);
\Yii::$container->set('kartik\grid\GridView', [
    'layout' => "{items}\n{pager}",
    'summary' => '<div class="summary"><b>{begin}-{end}</b> ' . \Yii::t('yii', 'of') . ' <b>{totalCount}</b> &nbsp;</div>',
    'persistResize' => true,
    'panelHeadingTemplate' => '<div class="btn-toolbar pull-left">{toolbar}</div><div class="kv-panel-pager pull-right">{pager}</div><div class="pull-right">{summary}</div><div class="clearfix"></div>',
    'panelBeforeTemplate' => '',
    'panelFooterTemplate' => '<div class="pull-left">{footer}</div><div class="kv-panel-pager pull-right">{pager}</div><div class="pull-right">{summary}</div><div class="clearfix"></div>',
    'export' => [
        'menuOptions' => ['class' => 'dropdown-menu dropdown-menu-left'],
        'target' => GridView::TARGET_SELF,
        'showConfirmAlert' => false,
        'showColumnSelector' => true,
    ],
    'exportConfig' => [
        GridView::HTML => true,
        GridView::CSV => true,
        GridView::TEXT => true,
        GridView::EXCEL => true,
        GridView::PDF => [
            'config' => [
                'methods' => [
                    'SetHeader' => [
                        [
                            'odd' => [
                                'L' => ['content' => Yii::t('app', 'Generated') . ': ' . date('M d, Y h:i')],
                                'C' => ['content' => Yii::t('app', 'Data Export')],
                                'R' => ['content' => Yii::t('app', 'Page') . ': {PAGENO}']
                            ]
                        ]
                    ],
                    'SetFooter' => false
                ],
            ]
        ],
    ],
]);
\Yii::$container->set('yii\widgets\ActiveForm', ['options' => ['class' => 'form-horizontal']]);
\Yii::$container->set('yii\widgets\ActiveField', [
    'template' => '{label}<div class="col-md-10 col-sm-10">{input}{hint}{error}</div>', // "{label}\n{input}\n{hint}\n{error}"
    'labelOptions' => ['class' => 'control-label col-sm-2 col-md-2 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
]);
\Yii::$container->set('kartik\file\FileInput', [
    'options' => [
        'accept' => 'image/*',
    ],
    'pluginEvents' => [
        'fileclear' => 'function() { ImageHelper.clearInputName(); }',
    ],
]);

\Yii::$container->set('dosamigos\ckeditor\CKEditor', [
    'preset' => 'standard',
    'options' => ['rows' => 6],
    'clientOptions' => [
        'toolbar' => [
            ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
            ['NumberedList', 'BulletedList', '-', 'Blockquote'],
            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
            ['Link', 'Unlink', 'Anchor'],
            '/',
            ['Styles', 'Format', 'Font', 'FontSize'],
            ['TextColor', 'BGColor'],
            ['Maximize'],
            ['abbr', 'inserthtml'],
        ],
    ]
]);
