<?php
use modules\hierarchicalStructure\assets\backend\HsAsset;
use yii\helpers\Html;
HsAsset::register($this);
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;


$fieldOptions = [
    'template' => '{label}<div class="col-md-8 col-sm-9">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-md-2 col-sm-3 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];
?>

<div class="">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'form-horizontal',
        ]
    ]); ?>
    <?php foreach ($allNodes as $value) : ?>
        <?= $form->field($record, 'node_id[]', $fieldOptions)->dropDownList($value, [
            'prompt' => Yii::t('app', 'Create node'),
        ]) ?>
    <?php endforeach; ?>

    <?= $form->field($record, 'fond_id')->hiddenInput(['value' => $fundId])->label(false) ?>
    <?= $form->field($record, 'code', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'title', $fieldOptions)->textInput() ?>

    <?= $form->field($record, 'date', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'final_date', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'level_description', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'extent_description', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($record, 'creator', $fieldOptions)->textInput() ?>

    <?= $form->field($record, 'administrative_history', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($record, 'archival_history', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($record, 'trans', $fieldOptions)->textInput() ?>

    <?= $form->field($record, 'content', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($record, 'information', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($record, 'accruals', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'arrangement', $fieldOptions)->textInput() ?>

    <?= $form->field($record, 'access', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'reproduction', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'language', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'characteristics', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($record, 'aids', $fieldOptions)->widget(CKEditor::className()) ?>

    <?= $form->field($record, 'location_originals', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'location_copies', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'related_units', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'publication_note', $fieldOptions)->widget(CKEditor::className()) ?>

    <?= $form->field($record, 'note', $fieldOptions)->widget(CKEditor::className()) ?>

    <?= $form->field($record, 'archivist_note', $fieldOptions)->widget(CKEditor::className()) ?>
    <?= $form->field($record, 'rules', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'date_descriptions', $fieldOptions)->textInput() ?>

    <?= $form->field($file, 'record_id')->hiddenInput(['value' => $record->id])->label(false) ?>
    <?= $form->field($file, 'path')->fileInput() ?>
    <?php if (isset($files)) : ?>
        <div class="container files">
            <div class="row">
                <div class="col-md-2">
                    <ul>
                        <?php foreach ($files as $value) : ?>
                            <li><?=Html::a(
                                    substr($value->path, strripos($value->path, '/') + 1, 20),
                                    ['download-file', 'id' => $value->id],
                                    [
                                        'class' => 'btn btn-warning',
                                        'data-title' => substr($value->path,
                                            strripos($value->path, '/') + 1)
                                    ]
                                );?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-2">
                    <ul>
                        <?php foreach ($files as $value) : ?>
                            <li><?= Html::a(
                                    '<span class="btn btn-danger">' . Yii::t('app', 'Delete') . '</span>',
                                    ['delete-file', 'id' => $value->id, 'active' => 'download'],
                                    ['data-confirm' => Yii::t('yii', 'Are you sure you want to delete this File?')]
                                );?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($record->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success', 'name' => 'active','value' => '#Identity']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
