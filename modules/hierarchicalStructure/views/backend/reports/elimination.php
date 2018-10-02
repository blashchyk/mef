<?php
use yii\helpers\Html;
use yii\grid\GridView;
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);
/** @var $dataProvider */

$this->title = Yii::t('app', 'Elimination Reports');
?>
<div class="hierarchical-structure-index elimination">
    <div id="response"></div>
    <div class="row list-header">
        <div class="col-md-8">
            <h2><?= Yii::t('app', 'View all Elimination Reports'); ?></h2>
        </div>
        <?= Html::a(Yii::t('app', 'Generate report OTD'),
            ['/hierarchicalStructure/reports/generate'],
            ['class' => 'btn btn-success pull-right create-hs-btn']
        ); ?>
    </div>

    <div class="row hs-table-list">
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'date',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=> Yii::t('app', 'Initial Vertion (OTD)'),
                        'headerOptions' => ['width' => '50%'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{initial}',
                        'buttons' => [
                            'initial' => function ($url, $report) {
                                return Yii::$app->user->can('hierarchicalStructure.reports.update') ? Html::a(
                                    '<span class="glyphicon glyphicon-floppy-open" data-title="Download"></span>',
                                    ['/hierarchicalStructure/reports/generate-otd', 'reportId' => $report->id]
                                ) : '';
                            },
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=> Yii::t('app', 'Uploaded Version (PDF)'),
                        'headerOptions' => ['width' => '25%'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{initial}',
                        'buttons' => [
                            'initial' => function ($url, $report) {
                                return Yii::$app->user->can('hierarchicalStructure.reports.update') ? Html::a(
                                    '<span class="glyphicon glyphicon-download-alt" data-title="Download"></span>',
                                    ['/hierarchicalStructure/reports/generate-pdf', 'reportId' => $report->id]
                                ) : '';
                            },
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=> Yii::t('app', 'Actions'),
                        'headerOptions' => ['width' => '100'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{view} {delete}',
                        'buttons' => [
                            'view' => function ($url, $report) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open" data-title="View"></span>',
                                    ['/hierarchicalStructure/reports/pdf-open', 'reportId' => $report->id, 'view' => 1]);
                            },
                            'delete' => function ($url, $report) {
                                return Yii::$app->user->can('hierarchicalStructure.reports.delete') ? Html::a(
                                    '<span class="glyphicon glyphicon-trash" data-title="Delete"></span>',
                                    ['/hierarchicalStructure/reports/delete', 'reportId' => $report->id],
                                    ['data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Record with all nodes?')]
                                ) : '';
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
