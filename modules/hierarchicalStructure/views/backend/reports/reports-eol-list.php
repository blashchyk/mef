<?php
use yii\helpers\Html;
use yii\grid\GridView;
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);
/** @var $dataProvider */

$this->title = Yii::t('app', 'Report Eol');
?>
<div class="hierarchical-structure-index eol">
    <div id="response"></div>
    <div class="row list-header">
        <div class="col-md-8"><h2><?= Yii::t('app', 'View all Eol'); ?></h2></div>
        <?= Html::a(Yii::t('app', 'Delete Red Marked Records'),
            ['/hierarchicalStructure/reports/delete-all'],
            ['class' => 'btn btn-success pull-right create-hs-btn'],
            ['data-confirm' => Yii::t('yii', 'Are you sure you want to delete the entry?')]); ?>
    </div>
    <div class="row hs-table-list">
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $eol,
                'columns' => [
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=> Yii::t('app', 'Eliminate'),
                        'headerOptions' => ['width' => '100'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{eliminate}',
                        'buttons' => [
                            'eliminate' => function ($url, $record) {
                                return $record->report == 0 ? (Yii::$app->user->can('hierarchicalStructure.funds.update') && $record->eliminate == 0 ? Html::a(
                                    '<span class="glyphicon glyphicon-ok" data-title="Rewrite"></span>',
                                    [
                                        '/hierarchicalStructure/reports/update-eol',
                                        'recordId' => $record->id,
                                        'eliminate' => 1
                                    ],
                                    ['data-confirm' => Yii::t('yii', 'Are you sure you want to delete the entry?')]
                                ) : Html::a(
                                    '<span class="glyphicon glyphicon-remove" data-title="Rewrite"></span>',
                                    [
                                        '/hierarchicalStructure/reports/update-eol',
                                        'recordId' => $record->id,
                                        'eliminate' => 0
                                    ],
                                    ['data-confirm' => Yii::t('yii', 'Are you sure you want to restore the record?')]
                                )) : '<span class="report"></span>';
                            },
                        ],
                    ],
                        'completeRecordCode',
                        'title',
                    [

                        'attribute' => 'allDate',
                        'headerOptions' => ['width' => '25%'],
                    ],
                    'consTerm',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=> Yii::t('app', 'Actions'),
                        'headerOptions' => ['width' => '100'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, $record) {
                                return Yii::$app->user->can('hierarchicalStructure.reports.delete') && $record->report == 1 ? Html::a(
                                    '<span class="glyphicon glyphicon-trash" data-title="Delete"></span>',
                                    ['funds/delete-records', 'recordId' => $record->id],
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
