<?php

use kartik\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model modules\order\models\Order */
?>
<div class="container">

    <div class="row">
        <div class="col-sm-3 order-view">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'user.username',
                    'fullName',
                    'price:currency',
                    [
                        'attribute' => 'vat_tax',
                        'value' => function ($data) {
                            return !empty($data->vat_tax) ? $data->vat_tax . '%' : null;
                        },
                    ],
                    'totalPrice:currency',
                    'transaction_id',
                    'description:ntext',
                    'created',
                    'statusName',
                    //'updated',
                ],
            ]) ?>
        </div>
        <div class="col-sm-3">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'country.name',
                    'zip',
                    'city',
                    'address',
                    'phone'
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $orderItems,
                'columns' => [
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
