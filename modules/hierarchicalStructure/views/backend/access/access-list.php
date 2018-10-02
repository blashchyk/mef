<?php
use yii\helpers\Html;
use yii\grid\GridView;
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);

/** @var $dataProvider */
$this->title = Yii::t('app', 'Access');
?>
<?php if (Yii::$app->session->get('message')) : ?>
    <div class="messages">
        <h2>Email Send</h2>
    </div>
    <?php Yii::$app->session->remove('message'); ?>
<?php endif; ?>

<div class="hierarchical-structure-index">
    <div id="response"></div>
    <div class="row list-header">
        <div class="col-md-8"><h2><?= Yii::t('app', 'View all Access permissions'); ?></h2></div>
        <?php if (Yii::$app->user->can('accessRequests.backend.create')) :  ?>
            <div class="col-md-4"><?= Html::a(
                    Yii::t('app', 'Add new Request'),
                    [ '/hierarchicalStructure/access/create'],
                    ['class' => 'btn btn-success pull-right create-hs-btn']
                ); ?></div>
        <?php endif; ?>
    </div>
    <div class="row hs-table-list">
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'code',
                    'dateFormat',
                    'name',
                    'finality',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => Yii::t('app', 'Confirmation'),
                        'headerOptions' => ['width' => '100'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{confirmation}',
                        'buttons' => [
                            'confirmation' => function($url, $request) {
                                return $request->confirmation == 1 ? '<span class="glyphicon glyphicon-ok"></span>' . Html::a(
                                    '<span class="glyphicon glyphicon-envelope"></span>',
                                    ['/hierarchicalStructure/access/email', 'id' => $request->id],
                                    ['data-confirm' => Yii::t('yii', 'Are you sure you want to send the email again?')]
                                ) : Html::a(
                                    '<span class="glyphicon glyphicon-envelope"></span>',
                                    ['/hierarchicalStructure/access/email', 'id' => $request->id],
                                    ['data-confirm' => Yii::t('yii', 'Are you sure you want to send email?')]
                                );
                            }
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=> Yii::t('app', 'Actions'),
                        'headerOptions' => ['width' => '100'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $request) {
                                return Yii::$app->user->can('accessRequests.backend.update') ? Html::a(
                                    '<span class="glyphicon glyphicon-edit" data-title="Update"></span>',
                                    ['/hierarchicalStructure/access/update', 'id' => $request->id]
                                ) : '';
                            },

                            'delete' => function ($url, $request) {
                                return Yii::$app->user->can('accessRequests.backend.delete') ? Html::a(
                                    '<span class="glyphicon glyphicon-trash" data-title="Delete"></span>',
                                    ['/hierarchicalStructure/access/delete', 'id' => $request->id],
                                    ['data-confirm' => Yii::t('yii', 'Are you sure you want to delete this access request?')]
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
