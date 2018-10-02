<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\catalog\models\Category;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */

$fieldOptions = [
    'options' => ['class' => 'col-lg-3 pull-left'],
    'template' => '{label}<div class="col-md-9 col-sm-9">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-3 col-md-3'],
];
?>

<div class="product-search">

    <div class="media-form alert alert-search">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'enableClientValidation' => false,
        ]); ?>

        <?= $form->field($model, 'parent_id', $fieldOptions)->dropdownList(Category::getList(), ['prompt' => '']) ?>

        <?= $form->field($model, 'user_id', $fieldOptions)->dropdownList(User::getList(), ['prompt'=>'']) ?>

        <?= $form->field($model, 'name', $fieldOptions) ?>

        <?php //= $form->field($model, 'slug') ?>

        <?php // echo $form->field($model, 'image') ?>

        <?php // echo $form->field($model, 'price') ?>

        <?php // echo $form->field($model, 'description') ?>

        <?php // echo $form->field($model, 'visible') ?>

        <?php // echo $form->field($model, 'sorting') ?>

        <?php // echo $form->field($model, 'created_at') ?>

        <?php // echo $form->field($model, 'updated_at') ?>

        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-default']) ?>

        <?php ActiveForm::end(); ?>

        <div class="clear"></div>

    </div>

</div>
