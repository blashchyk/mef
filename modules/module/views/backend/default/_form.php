<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\module\models\Module;

/* @var $this yii\web\View */
/* @var $model modules\module\models\Module */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="module-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">

        <div class="panel-heading"><b><?= Yii::t('app', 'Module Settings') ?></b></div>

        <div class="panel-body">
            
            <?= $form->field($model, 'parent_id')->dropdownList(Module::getList(), ['prompt'=>'', 'disabled' => !$model->isNewRecord]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'record-name form-control']) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'record-slug form-control', 'disabled' => !$model->isNewRecord]) ?>

            <?= $form->field($model, 'visible')->dropdownList(Module::getVisibilityStatuses()) ?>

        </div>

    </div>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
