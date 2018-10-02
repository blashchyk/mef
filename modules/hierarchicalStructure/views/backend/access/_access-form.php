<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\assets\backend\HsAsset;
use dosamigos\ckeditor\CKEditor;
use modules\hierarchicalStructure\controllers\backend\FundsController;
HsAsset::register($this);
$fieldOptions = [
    'template' => '{label}<div class="col-md-6 col-sm-9">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-md-2 col-sm-3 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];
$fieldCheckboxOptions = [
    'template' => '{label}<div class="col-md-offset-2 col-md-6 col-sm-9">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-md-offset-2 col-md-2 col-sm-3 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];
?>
<div class="fond-form">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($request, 'name', $fieldOptions)->textInput() ?>
        <?= $form->field($request, 'phone', $fieldOptions)->textInput() ?>
        <?= $form->field($request, 'address', $fieldOptions)->textInput() ?>
        <?= $form->field($request, 'date', $fieldOptions)->textInput(['value' => date('Y-m-d'), 'disabled' => true]) ?>
        <?= $form->field($request, 'finality', $fieldOptions)->textInput() ?>
        <?= $form->field($request, 'email', $fieldOptions)->textInput() ?>
        <?= $form->field($request, 'code', $fieldOptions)->textInput() ?>
        <?= $form->field($request, 'excel', $fieldCheckboxOptions)->checkbox() ?>
        <?= $form->field($request, 'pdf', $fieldCheckboxOptions)->checkbox() ?>
        <?= $form->field($request, 'xml', $fieldCheckboxOptions)->checkbox() ?>
    <div class="form-group">
        <div class="col-md-8">
            <?= Html::submitButton($request->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $request->isNewRecord ? 'btn btn-success pull-right update' : 'btn btn-primary pull-right update']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>