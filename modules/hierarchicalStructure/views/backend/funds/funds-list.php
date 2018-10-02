<?php
use yii\helpers\Html;
use yii\grid\GridView;
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);

/** @var $dataProvider */

$this->title = Yii::t('app', 'All Funds');
?>
<div class="hierarchical-structure-index">
    <div id="response"></div>
    <div class="row list-header">
        <div class="col-md-8"><h2><?= Yii::t('app', 'View all funds'); ?></h2></div>
        <?php if (Yii::$app->user->can('hierarchicalStructure.funds.create')) :  ?>
            <div class="col-md-4"><?= Html::a(
                    Yii::t('app', 'Add new Fund'),
                    [ '/hierarchicalStructure/funds/create'],
                    ['class' => 'btn btn-success pull-right create-hs-btn']
                ); ?></div>
        <?php endif; ?>
    </div>
    <div class="row hs-table-list">
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=> Yii::t('app', 'Public'),
                        'headerOptions' => ['width' => '100'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{public}',
                        'buttons' => [

                            'public' => function ($url, $fund) {
                                return Yii::$app->user->can('hierarchicalStructure.funds.update') && $fund->public_fund == 0 ? Html::a(
                                    '<span class="glyphicon glyphicon-remove" data-title="Rewrite"></span>',
                                    [
                                        '/hierarchicalStructure/funds/update',
                                        'fundId' => $fund->id,
                                        'public' => 1
                                    ],
                                    ['data-confirm' => Yii::t('yii', 'Do you really want to make this fund public?')]
                                ) : Html::a(
                                    '<span class="glyphicon glyphicon-ok" data-title="Rewrite"></span>',
                                    [
                                        '/hierarchicalStructure/funds/update',
                                        'fundId' => $fund->id,
                                        'public' => 0
                                    ],
                                    ['data-confirm' => Yii::t('yii', 'Do you really want to make this fund not public?')]
                                );
                            },
                        ],
                    ],
                    [
                        'attribute' => 'code',
                        'headerOptions' => ['width' => '25%'],
                    ],
                    'title',
                    'nameHsTree',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=> Yii::t('app', 'Actions'),
                        'headerOptions' => ['width' => '100'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            /**
                             * @var modules\hierarchicalStructure\models\Records $fund
                             */
                            'view' => function ($url, $fund, $key) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open" data-title="View"></span>',
                                    ['/hierarchicalStructure/funds/view', 'fundId' => $fund->id]);
                            },

                            'update' => function ($url, $fund) {
                                return Yii::$app->user->can('hierarchicalStructure.funds.update') ? Html::a(
                                    '<span class="glyphicon glyphicon-edit" data-title="Update"></span>',
                                    ['/hierarchicalStructure/funds/update', 'fundId' => $fund->id]
                                ) : '';
                            },

                            'delete' => function ($url, $fund) {
                                return Yii::$app->user->can('hierarchicalStructure.funds.delete') ? Html::a(
                                    '<span class="glyphicon glyphicon-trash" data-title="Delete"></span>',
                                    ['/hierarchicalStructure/funds/delete', 'fundId' => $fund->id],
                                    ['data-confirm' => Yii::t('yii', 'Are you sure you want to delete this Fund with all nodes?')]
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
