<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\country\models\Country;

$fieldOptions = [
    'inputOptions' => ['class' => 'form-control input-lg'],
    'options' => ['class' => 'col-lg-12'],
];
$smallFieldOptions = [
    'inputOptions' => ['class' => 'form-control input-lg'],
    'options' => ['class' => 'col-lg-6'],
];
?>

<?php if (!empty($items) && count($items) > 0) : ?>
    <?php if (!Yii::$app->user->isGuest) : ?>
        <div class="col-lg-10 col-lg-offset-1 alert alert-info">

            <?php $form = ActiveForm::begin(['id' => 'checkout-form']); ?>

                <?= $form->field($model, 'first_name', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'last_name', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'country_id', $smallFieldOptions)->dropdownList(Country::getList(), ['prompt'=>'']) ?>

                <?= $form->field($model, 'zip', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'city', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'address', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description', $fieldOptions)->textarea(['rows' => 4]) ?>

                &nbsp;
                <div class="col-lg-12 panel panel-default">
                    <br />
                    <p class="pull-right lead">
                        <b><?= Yii::t('app', 'Item Price') ?>:</b> $<span id="cart-price"><?= $cartPrice ?></span><br />
                        <b><?= Yii::t('app', 'VAT tax') ?>:</b> <span id="vat-tax"><?= (int) $vatTax ?></span>%<br />
                        <b><?= Yii::t('app', 'Total Price') ?>:</b> $<span id="total-price"><?= $totalPrice ?></span>
                    </p>
                </div>

                <div class="pull-right">
                    <?= Html::a(Yii::t('app', 'Back'), ['cart'], ['class' => 'btn btn-primary btn-lg']) ?>
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Checkout') : Yii::t('app', 'Update'), ['class' => 'btn btn-success btn-lg']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php else : ?>
        <p><?= Yii::t('app', 'Please, login to continue the order.') ?></p>
        <?= Html::a(Yii::t('app', 'Login'), ['/user/login'], ['class' => 'btn btn-primary btn-lg']) ?>
    <?php endif; ?>
<?php else : ?>
    <p><?= Yii::t('app', 'Your cart is empty. Please, add new product to the cart.') ?></p>
    <?= Html::a(Yii::t('app', 'Catalog'), ['/catalog/index'], ['class' => 'btn btn-primary btn-lg']) ?>
<?php endif; ?>