<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$fieldOptions = [
    'options' => ['class' => 'col-lg-3 pull-left'],
    'template' => '{label}<div class="col-md-9 col-sm-9">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-3 col-md-3'],
];
/* @var $this yii\web\View */
/* @var $model modules\faq\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faq-category-search">
    <div class="faq-category-form alert alert-search">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'enableClientValidation' => false,
        ]); ?>

        <?= $form->field($model, 'user_id', $fieldOptions) ?>

        <?= $form->field($model, 'name', $fieldOptions) ?>

        <?= $form->field($model, 'keywords', $fieldOptions) ?>

        <?php // echo $form->field($model, 'visible') ?>

        <?php // echo $form->field($model, 'sorting') ?>

        <?php // echo $form->field($model, 'created_at') ?>

        <?php // echo $form->field($model, 'update_at') ?>

        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'pull-left btn btn-default btn-search']) ?>
        <?php //= Html::resetButton(Yii::t('app', 'Reset'), ['class'  'btn btn-default']) ?>

        <?php ActiveForm::end(); ?>

        <div class="clear"></div>

    </div>
</div>