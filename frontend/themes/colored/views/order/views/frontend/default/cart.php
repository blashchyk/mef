<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$amounts = range(0, 100);
unset($amounts[0]);
?>
<div class="section">
    <div class="container">
        <div class="col-sm-12">
            <h2 class="block-title"><?= Yii::t('app', 'Order Details') ?></h2>
        </div>
        <?php if (!empty($items) && count($items) > 0) : ?>
            <table id="w0" class="table cart-list">
                <thead>
                    <tr>
                        <th><?= Yii::t('app', 'Product') ?></th>
                        <th><?= Yii::t('app', 'Amount') ?></th>
                        <th><?= Yii::t('app', 'Item Price') ?></th>
                        <th><?= Yii::t('app', 'Batch Price') ?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><?= $item->name ?></td>
                        <td>
                            <?php $form = ActiveForm::begin(['action' => ['/order/update', 'id' => $item->id], 'id' => 'qqqqqqqqqq']); ?>
                                <?= Html::dropDownList('amount', $item->amount, $amounts, ['class' => 'amount']) ?>
                            <?php ActiveForm::end(); ?>
                        </td>
                        <td><?= Yii::$app->formatter->asCurrency($item->price) ?></td>
                        <td><?= Yii::$app->formatter->asCurrency($item->amount * $item->price) ?></td>
                        <td>
                            <?= Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), ['/order/remove', 'id' => $item->id], [
                                'title' => Yii::t('app', 'Delete'),
                                'aria-label' => Yii::t('app', 'Delete'),
                                'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?')
                            ]); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <p class="pull-right lead">
                <b><?= Yii::t('app', 'Total Price') ?>:</b>
                <?= Yii::$app->formatter->asCurrency($cartPrice) ?>
            </p>
            <div class="clearfix"></div>
            <p  class="pull-right">
                <?= Html::a(Yii::t('app', 'Checkout'), ['checkout'], ['class' => 'btn btn-primary-magnet']) ?>
            </p>
        <?php else : ?>
            <p><?= Yii::t('app', 'Your cart is empty. Please, add new product to the cart.') ?></p>
            <?= Html::a(Yii::t('app', 'Catalog'), ['/catalog/index'], ['class' => 'btn btn-primary-magnet']) ?>
        <?php endif; ?>
    </div>
</div>