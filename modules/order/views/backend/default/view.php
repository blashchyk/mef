<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model modules\order\models\Order */

$this->title = Yii::t('app', 'View Order') . ': ' . $model->created;
?>
<div class="order-view">

    <div class="row">
        <div class="col-sm-6">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'user.username',
                    'fullName',
                    'country.name',
                    'zip',
                    'city',
                    'address',
                    'phone',
                    'price:currency',
                    'transaction_id',
                    [
                        'attribute' => 'vat_tax',
                        'value' => function ($data) {
                            return !empty($data->vat_tax) ? $data->vat_tax . '%' : null;
                        },
                    ],
                    'totalPrice:currency',
                    'description:ntext',
                    'created',
                    'statusName',
                    //'updated',
                ],
            ]) ?>
            <div class="pull-right">
                <?= Html::a(Html::tag('span', null, ['class' => 'glyphicon glyphicon-arrow-left']) . ' ' . Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <h1><?= Yii::t('app', 'Order Items') ?>:</h1>
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $orderItems,
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
                        [
                            'attribute' => 'product_id',
                            'value' => 'product.name',
                            'label' => Yii::t('app', 'Product'),
                        ],
                        'amount',
                        'item_price:currency',
                        [
                            'label' => Yii::t('app', 'Batch Price'),
                            'value' => function ($data) {
                                return Yii::$app->formatter->asCurrency($data->amount * $data->item_price);
                            }
                        ]
                    ]
                ])?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
