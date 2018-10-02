<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\theme\models\Theme;

/* @var $this yii\web\View */
/* @var $model modules\slider\models\SliderSearch */
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

        <?php // echo $form->field($model, 'user_id', $fieldOptions)->dropdownList(User::getList(), ['prompt'=>'']) ?>

        <?= $form->field($model, 'name', $fieldOptions) ?>

        <?= $form->field($model, 'type', $fieldOptions)->dropdownList($model->getTypes(), ['prompt'=>'']) ?>

        <?= $form->field($model, 'theme_id', $fieldOptions)->dropdownList(Theme::getList(), ['prompt'=>'']) ?>

        <?php // echo $form->field($model, 'id') ?>

        <?php // echo $form->field($model, 'user_id') ?>

        <?php // echo $form->field($model, 'name') ?>

        <?php // echo $form->field($model, 'image') ?>

        <?php // echo $form->field($model, 'description') ?>

        <?php // echo $form->field($model, 'video_url') ?>

        <?php // echo $form->field($model, 'forward_url') ?>

        <?php // echo $form->field($model, 'type') ?>

        <?php // echo $form->field($model, 'visible') ?>

        <?php // echo $form->field($model, 'sorting') ?>

        <?php // echo $form->field($model, 'created_at') ?>

        <?php // echo $form->field($model, 'updated_at') ?>

        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-default']) ?>

        <?php ActiveForm::end(); ?>

        <div class="clear"></div>
    </div>
</div>

