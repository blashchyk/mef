<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use modules\menu\models\MenuItem;

$model = new MenuItem();
$model->scenario = MenuItem::SCENARIO_ADD_LINK;
?>

<?php $fieldOptions = [
    'template' => '{label}<div class="col-md-9 col-sm-9">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-3 col-md-3'],
    'inputOptions' => ['class' => 'form-control input-sm']
] ?>

<?php $form = ActiveForm::begin(['id' => 'add-link-form']); ?>

    <?= $form->field($model, '[0]url', $fieldOptions)->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, '[0]link_name', $fieldOptions)->textInput(['maxlength' => true]) ?>

    <?= Html::submitButton(Yii::t('app', 'Add Link'), ['class' => 'add-link-button btn btn-success pull-right']) ?>

<?php ActiveForm::end(); ?>

<div class="clear"></div>
