<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model modules\user\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'options' => ['class' => 'col-lg-6'],
    'inputOptions' => ['class' => 'form-control input-lg'],
];
$dateFieldOptions = ['options' => $fieldOptions['inputOptions'] + ['readonly' => true]];

$userAgeLimit  = 100;
$datePickerRange = (date('Y') - $userAgeLimit) . ':' . date('Y');
?>

<p>
    <?= Yii::t('app', 'Please fill out the following fields to signup:') ?>
</p>

<div class="site-signup">

    <div class="col-lg-10 col-lg-offset-1 alert alert-info">

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username', $fieldOptions) ?>

            <?= $form->field($model, 'email', $fieldOptions) ?>

            <?= $form->field($model, 'password', $fieldOptions)->passwordInput() ?>

            <?= $form->field($model, 'confirm_password', $fieldOptions)->passwordInput() ?>

            <?= $form->field($model, 'first_name', $fieldOptions)->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'last_name', $fieldOptions)->textInput(['maxlength' => true]) ?>

            <div class="col-lg-6">
                <br />
                <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary btn-lg pull-right', 'name' => 'signup-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>