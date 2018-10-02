<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', Yii::t('app', 'Login'));
$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'inputOptions' => ['class' => 'form-control input-lg'],
];
?>

<div class="site-login">

    <div class="col-lg-8 col-lg-offset-2 alert alert-info">

        <p>
            <?= Yii::t('app', 'Please fill out the following fields to login:') ?>
        </p>

        <br/>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username', $fieldOptions) ?>

            <?= $form->field($model, 'password', $fieldOptions)->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="note">
                <?= Yii::t('app', 'If you forgot your password you can') ?> <?= Html::a(Yii::t('app', 'reset it'), ['request-password-reset']) ?>.
            </div>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', Yii::t('app', 'Login')), ['class' => 'btn btn-lg btn-primary', 'name' => 'login-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>