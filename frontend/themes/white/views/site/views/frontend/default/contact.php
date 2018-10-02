<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use modules\setting\models\Setting;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'template' => '<div class="col-xs-12">{input}{hint}{error}</div>',
];
$textFieldOptions = [
    'template' => '<div class="form-group">{input}</div>'
]
?>

<div class="site-contact">

    <div class="col-sm-6">
        <h3 class="title-block first-child"><?= Yii::t('app', 'Contact Info') ?></h3>
        <ul class="contact-info">
            <?php if (Setting::getValue('contact_address')) : ?>
                <li>
                    <i class="fa fa-map-marker"></i>
                    <div class="contact-info-content">
                        <div class="title"><?= Yii::t('app', 'Address') ?>:</div>
                        <div class="description"><?= Setting::getValue('contact_address') ?></div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (Setting::getValue('contact_phone')) : ?>
                <li>
                    <i class="fa fa-phone"></i>
                    <div class="contact-info-content">
                        <div class="title"><?= Yii::t('app', 'Telephone') ?>:</div>
                        <div class="description"><?= Setting::getValue('contact_phone') ?></div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (Setting::getValue('contact_fax')) : ?>
                <li>
                    <i class="fa fa-fax"></i>
                    <div class="contact-info-content">
                        <div class="title"><?= Yii::t('app', 'Fax') ?>:</div>
                        <div class="description"><?= Setting::getValue('contact_fax') ?></div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (Setting::getValue('contact_twitter')) : ?>
                <li>
                    <i class="fa fa-twitter"></i>
                    <div class="contact-info-content">
                        <div class="title">Twitter:</div>
                        <div class="description"><?= Setting::getValue('contact_twitter') ?></div>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="col-sm-6">

        <h3 class="title-block second-child"><?= Yii::t('app', 'Drop Us A Few Lines') ?></h3>

        <p>
            <?= Yii::t('app', 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.') ?>
        </p>

        <hr />

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <div class="row">

                <?= $form->field($model, 'sender_email', $fieldOptions)->textInput([ 'class' => 'form-control form-control_xs-margin', 'placeholder' => Yii::t('app', 'E-mail')]) ?>

                <?= $form->field($model, 'sender_name', $fieldOptions)->textInput([ 'placeholder' => Yii::t('app', 'Full Name')]) ?>

                <?= $form->field($model, 'subject', $fieldOptions)->textInput(['placeholder' => Yii::t('app', 'Subject')]) ?>

            </div>

            <?= $form->field($model, 'body', $textFieldOptions)->textArea(['rows' => 3, 'class' => 'form-control', 'id' => 'message', 'placeholder' => Yii::t('app', 'Message')]) ?>

            <?= $form->field($model, 'verifyCode', $fieldOptions)->widget(Captcha::className(), [
                'captchaAction' => '/site/captcha',
                'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-9">{input}</div></div>',
                'options' => ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Verification Code')],
            ]) ?>

            <div class="pull-left">
                <?= Html::submitButton(Yii::t('app', 'Submit') . '<i class="fa fa-paper-plane-o"></i>', ['class' => 'btn btn-red', 'name' => 'contact-button']) ?>
            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
