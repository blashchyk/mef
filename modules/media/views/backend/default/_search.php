<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use modules\media\models\Category;

/* @var $this yii\web\View */
/* @var $model modules\media\models\MediaSearch */
/* @var $form yii\widgets\ActiveForm */

$fieldOptions = [
    'options' => ['class' => 'col-lg-3 pull-left'],
    'template' => '{label}<div class="col-md-9 col-sm-9">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-3 col-md-3'],
];
?>

<div class="media-search">

    <div class="media-form alert alert-search">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'enableClientValidation' => false,
        ]); ?>

        <?php // echo $form->field($model, 'id') ?>

        <?= $form->field($model, 'parent_id', $fieldOptions)->dropdownList(Category::getList(), ['prompt'=>'']) ?>

        <?= $form->field($model, 'user_id', $fieldOptions)->dropdownList(User::getList(), ['prompt'=>'']) ?>

        <?= $form->field($model, 'name', $fieldOptions) ?>

        <?php // echo $form->field($model, 'file') ?>

        <?php // echo $form->field($model, 'sorting') ?>

        <?php // echo $form->field($model, 'created_at') ?>

        <?php // echo $form->field($model, 'updated_at') ?>

        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'pull-left btn btn-default btn-search']) ?>

        <?php ActiveForm::end(); ?>

        <div class="clear"></div>

    </div>

</div>
