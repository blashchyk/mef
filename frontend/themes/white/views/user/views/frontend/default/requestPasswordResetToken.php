<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'inputOptions' => ['class' => 'form-control'],
    'template' => '{input}',
];
?>

<div class="site-request-password-reset">

    <div class="col-lg-8 col-lg-offset-2">

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <p>
                <?= Yii::t('app', 'Please fill out your email. A link to reset password will be sent there.') ?>
            </p>

            <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                <?= $form->field($model, 'email', $fieldOptions) ?>

            </div>
            <br/>

            <div class="pull-left">
                <?= Html::submitButton('Send', ['class' => 'btn btn-red pull-left']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>