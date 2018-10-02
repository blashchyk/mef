<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use modules\menu\models\MenuItem;

$model = new MenuItem();
?>

<?php $fieldOptions = [
    'template' => '{label}<div class="col-md-9 col-sm-9">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-3 col-md-3'],
    'inputOptions' => ['class' => 'form-control input-sm']
] ?>

<?php $form = ActiveForm::begin(['id' => 'add-text-form']); ?>

    <?= $form->field($model, '[0]link_name', $fieldOptions)->textInput(['maxlength' => true])->label(Yii::t('app', 'Caption')) ?>

    <?= Html::submitButton(Yii::t('app', 'Add Item'), ['class' => 'add-text-button btn btn-success pull-right']) ?>

<?php ActiveForm::end(); ?>

<div class="clear"></div>
