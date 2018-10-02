<?php

use modules\hierarchicalStructure\assets\backend\HsAsset;
use yii\helpers\Html;
HsAsset::register($this);
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

$fieldOptions = [
    'template' => '{label}<div class="col-md-10 col-sm-10">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-md-2 col-sm-2 col-xs-12 update_label'],
    'errorOptions' => ['class' => 'text-danger'],
];

if ($k === 0) {
    $option = [
        'options' => ['rows' => 6, 'class' => 'hidden_block'],
    ];
}
?>

<div class="table table-striped table-bordered detail-update">

    <?php $form = ActiveForm::begin([
            'action' => '/admin/hierarchicalStructure/funds/update-records?recordId=' . $record->id,
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'form-horizontal',
        ]
    ]); ?>

    <?php $activeTab = !empty($activeTab) ? $activeTab : $active; ?>


    <?= $form->field($record, 'fond_id')->hiddenInput(['value' => $fundId])->label(false) ?>
    <?= $form->field($record, 'code', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'title', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'dateFormat', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'finalDate', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'level_description', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'extent_description', $fieldOptions)->widget(CKEditor::className(), $option) ?>
    <?= $form->field($record, 'creator', $fieldOptions)->textInput() ?>

    <?= $form->field($record, 'administrative_history', $fieldOptions)->widget(CKEditor::className(), $option) ?>
    <?= $form->field($record, 'archival_history', $fieldOptions)->widget(CKEditor::className(), $option) ?>
    <?= $form->field($record, 'trans', $fieldOptions)->textInput() ?>

    <?= $form->field($record, 'content', $fieldOptions)->widget(CKEditor::className(), $option) ?>
    <?= $form->field($record, 'information', $fieldOptions)->widget(CKEditor::className(), $option) ?>
    <?= $form->field($record, 'accruals', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'arrangement', $fieldOptions)->textInput() ?>

    <?= $form->field($record, 'access', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'reproduction', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'language', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'characteristics', $fieldOptions)->widget(CKEditor::className(), $option) ?>
    <?= $form->field($record, 'aids', $fieldOptions)->widget(CKEditor::className(), $option) ?>

    <?= $form->field($record, 'location_originals', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'location_copies', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'related_units', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'publication_note', $fieldOptions)->widget(CKEditor::className(), $option) ?>

    <?= $form->field($record, 'note', $fieldOptions)->widget(CKEditor::className(), $option) ?>

    <?= $form->field($record, 'archivist_note', $fieldOptions)->widget(CKEditor::className(), $option) ?>
    <?= $form->field($record, 'rules', $fieldOptions)->textInput() ?>
    <?= $form->field($record, 'date_descriptions', $fieldOptions)->textInput() ?>

    <?= $form->field($file, 'record_id')->hiddenInput(['value' => $record->id])->label(false) ?>
    <?php if (empty($files)) : ?>
        <?= $form->field($file, 'path')->fileInput() ?>
    <?php endif; ?>

    <?php if (isset($files)) : ?>
        <div class="container files">
            <div class="row">
                <div class="col-md-2">
                    <ul>
                        <?php foreach ($files as $value) : ?>
                            <li><?=Html::a(
                                    substr($value->path, strripos($value->path, '/') + 1, 10),
                                    ['funds/download-file', 'id' => $value->id],
                                    ['class' => 'btn btn-warning', 'data-title' => substr($value->path, strripos($value->path, '/') + 1)]);?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-2">
                    <ul>
                        <?php foreach ($files as $value) : ?>
                            <li><?= Html::a(
                                    '<span class="btn btn-danger">' . Yii::t('app', 'Delete') . '</span>',
                                    ['funds/delete-file', 'id' => $value->id, 'fundId' => $fundId],
                                    ['data-confirm' => Yii::t('yii', 'Are you sure you want to delete this File?')]
                                );?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['view', 'fundId' => $fundId], ['class' => 'btn btn-primary update_button']) ?>
        <?= Html::submitButton($record->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success', 'name' => 'active','value' => '#Identity']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
