<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model modules\order\models\Order */
?>
<h2><?= Yii::t('app', 'Order Details'); ?></h2>
<?php Pjax::begin(); ?>
<?= GridView::widget([
    'dataProvider' => $orderItems,
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
