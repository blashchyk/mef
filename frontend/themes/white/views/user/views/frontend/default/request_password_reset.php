<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-request-password-reset">

    <div class="section bg-white">

        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <div class="container login">
                <div class="panel-body col-lg-8 col-lg-offset-2">

                    <p>
                        <?= Yii::t('app', 'Please fill out your email. A link to reset password will be sent there.') ?>
                    </p>

                    <?= $form->field($model, 'email') ?>

                    <div>
                        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-red']) ?>
                    </div>

                    <br />

                    <p>
                        <?= Yii::t('app', 'Return to the') ?> <?= Html::a(Yii::t('app', 'login form'), ['login']) ?>.
                    </p>

                </div>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>