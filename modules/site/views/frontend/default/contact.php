<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\site\forms\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'inputOptions' => ['class' => 'form-control input-lg'],
];
?>

<p>
    <?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.') ?>
</p>

<div class="site-contact">

    <div class="col-lg-8 col-lg-offset-2 alert alert-info">

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'sender_name', $fieldOptions) ?>

            <?= $form->field($model, 'sender_email', $fieldOptions) ?>

            <?= $form->field($model, 'subject', $fieldOptions) ?>

            <?= $form->field($model, 'body', $fieldOptions)->textArea(['rows' => 4]) ?>

            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                'captchaAction' => '/site/captcha',
                'template' => '<div class="row"><div class="col-lg-2">{image}</div><div class="col-lg-10">{input}</div></div>',
                'options' => ['class' => 'form-control input-lg'],
            ]) ?>

            <div class="pull-right">
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-lg btn-primary', 'name' => 'contact-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
