<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\setting\models\Setting;

/* @var $this yii\web\View */
/* @var $model modules\setting\models\Setting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">

        <div class="panel-heading"><b><?= Yii::t('app', 'Site Settings') ?></b></div>

        <div class="panel-body">

            <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'disabled' => !$model->isNewRecord, 'class' => 'record-name form-control']) ?>

            <?= $form->field($model, 'key')->textInput(['maxlength' => true, 'disabled' => $model->type == Setting::TYPE_SYSTEM, 'class' => 'record-slug form-control']) ?>

            <?php $field = $form->field($model, 'value'); ?>
            <?php if (in_array($model->value_type, [Setting::TYPE_INTEGER, Setting::TYPE_STRING, Setting::TYPE_EMAIL])) : ?>
                <?= $field->textInput(['maxlength' => true]) ?>
            <?php elseif ($model->value_type == Setting::TYPE_TEXT) : ?>
                <?= $field->textarea(['rows' => 4]) ?>
            <?php elseif ($model->value_type == Setting::TYPE_BOOLEAN) : ?>
                <?= $field->dropDownList(Setting::getBooleanTypes()) ?>
            <?php endif; ?>

        </div>

    </div>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
