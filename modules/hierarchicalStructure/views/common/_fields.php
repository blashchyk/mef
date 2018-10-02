<?php
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditor;
use kartik\date\DatePicker;
use \modules\hierarchicalStructure\models\HsTreeNode;
use \modules\hierarchicalStructure\models\HsFinalDestination;
use yii\helpers\ArrayHelper;

/**
 * @var $hsId
 * @var $node modules\hierarchicalStructure\models\KartikTreeNode
 */

$hsModel = $node->isNewRecord ? new HsTreeNode() : $node->hsTreeNode;
$inputOpts = [];
if ($node->isReadonly()) {
    $inputOpts['readonly'] = true;
}
if ($node->isDisabled()) {
    $inputOpts['disabled'] = true;
}

$fieldOptions = [
    'template' => '{label}<div class="col-md-10 col-sm-10">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-md-2 col-sm-2 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];

$CKEditorToolbar = [
    ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
    ['NumberedList', 'BulletedList', '-', 'Blockquote'],
    ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
    ['Link', 'Unlink', 'Anchor'],
    '/',
    ['Styles', 'Format', 'Font', 'FontSize'],
    ['TextColor', 'BGColor'],
    ['Maximize'],
    ['abbr', 'inserthtml']
];
$uploadURL = Url::to(['/page/upload-image/', 'id' => $node->id]);
?>
<div class="row">
    <div class="col-sm-12">
        <?= $form->field($node, 'hs_tree_id')->hiddenInput(['value'=> $hsId])->label(false); ?>
        <?= $form->field($hsModel, 'code', $fieldOptions)->textInput($inputOpts); ?>
        <?= $form->field($node, 'name', $fieldOptions)->textInput($inputOpts); ?>
        <?=  $form->field($hsModel, 'description', $fieldOptions)->widget(CKEditor::className(), [
            'preset' => 'standard',
            'options' => ['rows' => 6],
            'clientOptions' => [
                'filebrowserUploadUrl' => $uploadURL,
                'toolbar' => $CKEditorToolbar
            ],
        ]) ?>

        <?=  $form->field($hsModel, 'notes_application', $fieldOptions)->widget(CKEditor::className(), [
            'preset' => 'standard',
            'options' => ['rows' => 6],
            'clientOptions' => [
                'filebrowserUploadUrl' => $uploadURL,
                'toolbar' => $CKEditorToolbar
            ],
        ]) ?>

        <?=  $form->field($hsModel, 'notes_exclusion', $fieldOptions)->widget(CKEditor::className(), [
            'preset' => 'standard',
            'options' => ['rows' => 6],
            'clientOptions' => [
                'filebrowserUploadUrl' => $uploadURL,
                'toolbar' => $CKEditorToolbar
            ],
        ]) ?>

        <?= $form->field($hsModel, 'active', $fieldOptions)->checkbox([], false) ?>

        <?= $form->field($hsModel, 'conservation_term', $fieldOptions)->textInput(); ?>

        <?= $form->field($hsModel, 'final_destination_id', $fieldOptions)->dropDownList( ArrayHelper::map(HsFinalDestination::find()->all(), 'id', 'description'), [
                'prompt' => Yii::t('app', 'Choose final destination'),
        ]); ?>

    </div>
</div>
