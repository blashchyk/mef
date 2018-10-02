<?php
use yii\helpers\Html;
use yii\grid\GridView;
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);

/** @var $dataProvider */
$this->title = Yii::t('app', 'Obsolete files');
?>
<div class="hierarchical-structure-index">
    <div id="response"></div>
    <div class="row list-header">
        <div class="col-md-8"><h2><?= Yii::t('app', 'View all files'); ?></h2></div>
    </div>
    <div class="row hs-table-list">
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'type',
                    'version',
                    'extension',
                    'total',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => Yii::t('app', 'Support'),
                        'headerOptions' => ['width' => '100'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{support}',
                        'buttons' => [
                                'support' => function ($url, $file) {
                                    return Yii::$app->user->can('hierarchicalStructure.reports.update') && $file->support == 1 ? Html::a(
                                            '<span class="glyphicon glyphicon-ok"></span>',
                                            ['/hierarchicalStructure/reports/support', 'version' => $file->version, 'type' => $file->type],
                                            ['data-confirm' => Yii::t('yii', 'Are you sure you want to mark this file as unsupported?')]
                                    ) : Html::a(
                                        '<span class="glyphicon glyphicon-remove"></span>',
                                        ['/hierarchicalStructure/reports/support', 'version' => $file->version, 'type' => $file->type, 'support' => \modules\hierarchicalStructure\controllers\backend\ReportsController::SUPPORTED],
                                        ['data-confirm' => Yii::t('yii', 'Are you sure you want to mark this file as supported?')]
                                    );
                                },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
