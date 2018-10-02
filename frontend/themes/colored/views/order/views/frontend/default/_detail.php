<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model modules\order\models\Order */
?>
<br />
<div class="lead text-red"><b><?= Yii::t('app', 'Order Details'); ?></b></div>
<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $orderItems,
    'bordered' => false,
    'layout' => "{items}\n{pager}",
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