<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\user\User */

use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'options' => ['class' => 'col-lg-6'],
    'inputOptions' => ['class' => 'form-control'],
];
$dateFieldOptions = ['options' => $fieldOptions['inputOptions'] + ['readonly' => true]];

$userAgeLimit  = 100;
$datePickerRange = (date('Y') - $userAgeLimit) . ':' . date('Y');
?>

<div class="site-signup">

    <div class="section bg-white">

        <div class="container"><br/>

            <div class="col-sm-12">
                <h2 class="block-title"><?= Yii::t('app', 'Registration Form') ?></h2>
            </div>

            <p>
                <?= Yii::t('app', 'Please fill out the following fields to signup:') ?>
            </p>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username', $fieldOptions) ?>

                <?= $form->field($model, 'email', $fieldOptions) ?>

                <?= $form->field($model, 'password', $fieldOptions)->passwordInput() ?>

                <?= $form->field($model, 'confirm_password', $fieldOptions)->passwordInput() ?>

                <?= $form->field($model, 'first_name', $fieldOptions)->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'last_name', $fieldOptions)->textInput(['maxlength' => true]) ?>

                <div class="col-lg-12">
                    <br />
                    <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary-magnet pull-left', 'name' => 'signup-button']) ?>
                </div>

                <div class="clearfix"></div>

            <?php ActiveForm::end(); ?><br/>

            <h3 class="title-block second-child"><?= Yii::t('app', 'Sign Up With') ?>...</h3>

            <?= AuthChoice::widget([
                'baseAuthUrl' => ['/user/auth'],
                'popupMode' => false,
            ]) ?>

        </div>

    </div>

</div>