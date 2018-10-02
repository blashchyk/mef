<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modules\mail\models\Mail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mail-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">

        <div class="panel-heading"><b><?= Yii::t('app', 'User Email') ?></b></div>

        <div class="panel-body">

            <?= $form->field($model, 'sender_email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sender_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

            <?php if (!$model->isNewRecord) : ?>
                <?= $form->field($model, 'created')->textInput(['disabled' => true]) ?>
            <?php endif; ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

        </div>

    </div>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
