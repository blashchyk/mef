<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'inputOptions' => ['class' => 'form-control'],
];
?>
<div class="site-signup">

    <div class="col-lg-8 col-lg-offset-2 panel panel-default">

        <div class="panel-body">

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?php if (!$model->isGuest && !empty($model->identity->password_hash)) : ?>
                <?= $form->field($model, 'old_password', $fieldOptions)->passwordInput() ?>
            <?php endif; ?>

            <?= $form->field($model, 'password', $fieldOptions)->passwordInput() ?>

            <?= $form->field($model, 'confirm_password', $fieldOptions)->passwordInput() ?>

            <div class="pull-left">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-red pull-left']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>