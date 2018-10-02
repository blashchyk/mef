<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\catalog\models\Product;
use modules\catalog\models\Filter;
use modules\catalog\models\Category;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\Filter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filter-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-default">

        <div class="panel-heading"><b><?= Yii::t('app', 'Filter') ?></b></div>

        <div class="panel-body">

            <?= $form->field($model, 'category_id')->dropdownList(Category::getList(), ['prompt' => Yii::t('app', 'All Categories')]) ?>

            <?= $form->field($model, 'field')->dropdownList(Product::getFields($model->category_id), ['prompt' => '']) ?>

            <?= $form->field($model, 'type')->dropdownList(Filter::getValueTypes()) ?>

            <?= $form->field($model, 'visible')->dropdownList($model->getVisibilityStatuses()) ?>

        </div>

    </div>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>