<?php
use modules\order\models\OrderItem;
use yii\helpers\Html;
use kartik\grid\GridView;
?>

<div class="order-list panel panel-default">
    <div class="panel-body">
    <br />
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'resizeStorageKey' => 'orderGrid',
        'layout' => "{items}\n{pager}",
        'bordered' => false,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            'fullAddress:text:Address',
            'phone',
            'price:currency',
            [
                'attribute' => 'vat_tax',
                'value' => function ($data) {
                    return !empty($data->vat_tax) ? $data->vat_tax . '%' : null;
                },
            ],
            [
                'attribute' => 'totalPrice',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::tag('b', Yii::$app->formatter->asCurrency($data->totalPrice));
                },
            ],
            'created:raw:Date',

            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function () {
                    return GridView::ROW_COLLAPSED;
                },
                'enableRowClick' => true,
                'rowClickExcludedTags' => ['a', 'button', 'input', 'span'],
                'enableCache' => false,
                'detail' => function ($model) {
                    return $this->render('_detail', [
                        'model' => $model,
                        'orderItems' => OrderItem::getList($model->id, 20)
                    ]);
                },
                'expandOneOnly' => true,
                'detailOptions' => ['class' => 'detail-container'],
                'detailRowCssClass' => 'grid-detail',
                'detailAnimationDuration' => 'fast',
            ],
        ],
    ]); ?>
    </div>
</div>