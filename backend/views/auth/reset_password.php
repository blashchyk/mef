<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\forms\PasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'inputOptions' => ['class' => 'form-control input-lg'],
];
?>
<div class="site-signup">

    <div class="col-lg-8 col-lg-offset-2 alert alert-info">

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?php if (!$model->isGuest && !empty($model->identity->password_hash)) : ?>
                <?= $form->field($model, 'old_password', $fieldOptions)->passwordInput() ?>
            <?php endif; ?>

            <?= $form->field($model, 'password', $fieldOptions)->passwordInput() ?>

            <?= $form->field($model, 'confirm_password', $fieldOptions)->passwordInput() ?>

            <div class="pull-right">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary btn-lg pull-right']) ?>
            </div>

            <div class="clearfix"></div>

        <?php ActiveForm::end(); ?>

    </div>

</div>