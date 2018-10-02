<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\i18n\models\Language;

/* @var $this yii\web\View */
/* @var $model modules\i18n\models\Translation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="translation-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">
    <div class="panel-heading"><b><?= Yii::t('app', 'Translation') ?></b></div>

        <div class="panel-body">

            <?= $form->field($model, 'language')->dropdownList(Language::getList(false), ['disabled' => !$model->isNewRecord]) ?>

            <?= $form->field($model->message, 'message')->textarea(['maxlength' => true, 'disabled' => !$model->isNewRecord, 'rows' => 3]) ?>

            <?= $form->field($model, 'translation')->textarea(['maxlength' => true, 'rows' => 3]) ?>

        </div>

    </div>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
