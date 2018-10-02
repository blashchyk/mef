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
$fieldSelectOptions = [
    'template' => '{label}<div class="col-md-5 col-sm-8">{input}{hint}{error}</div><div class="col-md-1 col-sm-1"><button class="btn btn-info button_select" type="button">+</button></div>',
    'labelOptions' => ['class' => 'control-label col-md-2 col-sm-3 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];
$fieldSelectOptionsUpdate = [
    'template' => '{label}<div class="col-md-5 col-sm-8">{input}{hint}{error}</div><div class="col-md-1 col-sm-1"><button class="btn btn-danger button_select" type="button">-</button></div>',
    'labelOptions' => ['class' => 'control-label col-md-2 col-sm-3 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];
?>
<div class="fond-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php if(Yii::$app->controller->action->id == 'update') : ?>
        <div class="<?= ($fund->hsTree[0]->name == FundsController::WITHOUT_HS) ? 'hidden' : ''; ?>">
            <button class="btn btn-info button_select_update" type="button">Add HS</button>
            <?php for ($i=0; $i < count($fund->hsTree); $i++) : ?>
                <?= $form->field($fund, 'formHsTree['.$i.']', $fieldSelectOptionsUpdate)->dropDownList(HsTree::listAll(), [
                    'prompt' => Yii::t('app', 'Choose HS'),
                ]) ?>
            <?php endfor; ?>
            <div class="update_hidden hidden">
                <?= $form->field($fund, 'formHsTree[]', $fieldSelectOptionsUpdate)->dropDownList(HsTree::listAll(), [
                    'prompt' => Yii::t('app', 'Choose HS'),
                ]) ?>
            </div>
            <div class="add_select"></div>
        </div>
        <?php else : ?>
        <button class="btn btn-info button_select_update" type="button">Add HS</button>
        <?= $form->field($fund, 'formHsTree[]', $fieldSelectOptionsUpdate)->dropDownList(HsTree::listAll(), [
        'prompt' => Yii::t('app', 'Choose HS'),
    ]) ?>
        <div class="update_hidden hidden">
            <?= $form->field($fund, 'formHsTree[]', $fieldSelectOptionsUpdate)->dropDownList(HsTree::listAll(), [
                'prompt' => Yii::t('app', 'Choose HS'),
            ]) ?>
        </div>
        <div class="add_select"></div>
    <?php endif; ?>
    <?= $form->field($fund, 'code', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'title', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'date', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'final_date', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'level_description', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'extent_description', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($fund, 'creator', $fieldOptions)->textInput() ?>

    <?= $form->field($fund, 'administrative_history', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($fund, 'archival_history', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($fund, 'trans', $fieldOptions)->textInput() ?>

    <?= $form->field($fund, 'content', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($fund, 'information', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($fund, 'accruals', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'arrangement', $fieldOptions)->textInput() ?>

    <?= $form->field($fund, 'access', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'reproduction', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'language', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'characteristics', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($fund, 'aids', $fieldOptions)->widget(CKEditor::className()) ?>

    <?= $form->field($fund, 'location_originals', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'location_copies', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'related_units', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'publication_note', $fieldOptions)->widget(CKEditor::className()) ?>

    <?= $form->field($fund, 'note', $fieldOptions)->widget(CKEditor::className()) ?>

    <?= $form->field($fund, 'archivist_note', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($fund, 'rules', $fieldOptions)->textInput() ?>
    <?= $form->field($fund, 'date_descriptions', $fieldOptions)->textInput() ?>
    <div class="form-group">
        <div class="col-md-8">
            <?= Html::submitButton($fund->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $fund->isNewRecord ? 'btn btn-success pull-right update' : 'btn btn-primary pull-right update']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>