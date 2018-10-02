<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'inputOptions' => ['class' => 'form-control input-lg'],
];
?>

<p>
    <?= Yii::t('app', 'Please fill out your email. A link to reset password will be sent there.') ?>
</p>

<div class="site-request-password-reset">

    <div class="col-lg-8 col-lg-offset-2 alert alert-info">

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <?= $form->field($model, 'email', $fieldOptions) ?>

            <div>
                <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-lg btn-primary']) ?>
            </div>

            <div class="note">
                <?= Yii::t('app', 'Return to the') ?> <?= Html::a(Yii::t('app', 'login form'), ['login']) ?>.
            </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>