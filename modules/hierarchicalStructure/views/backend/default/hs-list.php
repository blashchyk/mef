<?php
use yii\helpers\Html;
use yii\grid\GridView;
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);

/** @var $dataProvider */

$this->title = Yii::t('app', 'All HS');
?>
<div class="hierarchical-structure-index">
    <div id="response"></div>
    <div class="row list-header">
        <div class="col-md-8"><h2><?= Yii::t('app', 'View all hs'); ?></h2></div>
        <?php if (Yii::$app->user->can('hierarchicalStructure.backend.create')) :  ?>
        <div class="col-md-4"><?= Html::a(
                Yii::t('app', 'Add new HS'),
                [ '/hierarchicalStructure/default/create'],
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
                'attribute' => 'name',
                'headerOptions' => ['width' => '25%'],
            ],
            'description',
            'key',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> Yii::t('app', 'Actions'),
                'headerOptions' => ['width' => '100'],
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    /**
                     * @var modules\hierarchicalStructure\models\HsTree $hs
                     */
                    'view' => function ($url, $hs, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open" data-title="View"></span>',
                            ['/hierarchicalStructure/default/view', 'hsId' => $hs->id]);
                    },

                    'update' => function ($url, $hs) {
                        return Yii::$app->user->can('hierarchicalStructure.backend.update') ? Html::a(
                                '<span class="glyphicon glyphicon-edit" data-title="Update"></span>',
                                ['/hierarchicalStructure/default/update', 'hsId' => $hs->id]
                            ) : '';
                    },

                    'delete' => function ($url, $hs) {
                        return Yii::$app->user->can('hierarchicalStructure.backend.delete') ? Html::a(
                                '<span class="glyphicon glyphicon-trash" data-title="Delete"></span>',
                                ['/hierarchicalStructure/default/delete', 'hsId' => $hs->id],
                                ['data-confirm' => Yii::t('yii', 'Are you sure you want to delete this HS with all nodes?')]
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
