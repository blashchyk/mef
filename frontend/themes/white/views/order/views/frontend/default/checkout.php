<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\country\models\Country;

$fieldOptions = [
    'inputOptions' => ['class' => 'form-control'],
    'options' => ['class' => 'col-lg-12'],
];
$smallFieldOptions = [
    'inputOptions' => ['class' => 'form-control'],
    'options' => ['class' => 'col-lg-6'],
];
?>

<?php if (!empty($items) && count($items) > 0) : ?>
    <?php if (!Yii::$app->user->isGuest) : ?>
        <div class="col-lg-10 col-lg-offset-1 panel panel-default">
            <div class="panel-body">

            <?php $form = ActiveForm::begin(['id' => 'checkout-form']); ?>

                <?= $form->field($model, 'first_name', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'last_name', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'country_id', $smallFieldOptions)->dropdownList(Country::getList(), ['prompt'=>'']) ?>

                <?= $form->field($model, 'zip', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'city', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'address', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'phone', $smallFieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'description', $fieldOptions)->textarea(['rows' => 4]) ?>

                <div class="clearfix"></div><br />

                <div class="col-lg-12">
                    <table class="table">
                        <tr>
                            <th width="25%"><?= Yii::t('app', 'Item Price') ?></th>
                            <th class="text-red">$<span id="cart-price"><?= $cartPrice ?></span></th>
                        </tr>
                        <tr>
                            <th><?= Yii::t('app', 'VAT tax') ?></th>
                            <th class="text-red"><span id="vat-tax"><?= (int) $vatTax ?></span>%</th>
                        </tr>
                        <tr>
                            <th><?= Yii::t('app', 'Total Price') ?></th>
                            <th class="text-red">$<span id="total-price"><?= $totalPrice ?></span></th>
                        </tr>
                    </table>

                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Checkout') : Yii::t('app', 'Update'), ['class' => 'btn btn-red']) ?>
                    <?= Html::a(Yii::t('app', 'Back'), ['cart'], ['class' => 'btn btn-blue']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php else : ?>
        <p><?= Yii::t('app', 'Please, login to continue the order.') ?></p>
        <?= Html::a(Yii::t('app', 'Login'), ['/user/login'], ['class' => 'btn btn-red btn-lg']) ?>
    <?php endif; ?>
<?php else : ?>
    <p><?= Yii::t('app', 'Your cart is empty. Please, add new product to the cart.') ?></p>
    <?= Html::a(Yii::t('app', 'Catalog'), ['/catalog/index'], ['class' => 'btn btn-red btn-lg']) ?>
<?php endif; ?>