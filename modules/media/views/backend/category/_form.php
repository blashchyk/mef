<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\media\models\Category;

/* @var $this yii\web\View */
/* @var $model modules\media\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="media-category-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">

        <div class="panel-heading"><b><?= Yii::t('app', 'Media Category') ?></b></div>

        <div class="panel-body">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'record-name form-control']) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'record-slug form-control']) ?>

            <?= $form->field($model, 'visible')->dropdownList(Category::getVisibilityStatuses()) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?php if (!$model->isNewRecord) : ?>

                <?= $form->field($model, 'creator')->textInput(['disabled' => true]) ?>

                <?= $form->field($model, 'created')->textInput(['disabled' => true]) ?>

                <?= $form->field($model, 'updated')->textInput(['disabled' => true]) ?>

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
