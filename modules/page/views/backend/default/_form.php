<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use dosamigos\ckeditor\CKEditor;
use modules\page\models\Page;
use modules\page\models\Category;
use modules\i18n\models\Language;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(); ?>

    <?php $pageContent = $form->field($model, 'content', [
        'template' => "{label}\n{input}\n{hint}\n{error}",
        'labelOptions' => ['class' => '']
    ])->widget(CKEditor::className(), [
        //'preset' => 'basic',
        'preset' => 'standard',
        'options' => ['rows' => 6],
        'clientOptions' => [
            'filebrowserUploadUrl' => Url::to(['/page/upload-image/', 'id' => $model->id]),
            'toolbar' => [
                ['Source', '-', 'Save', 'NewPage', 'Preview', '-', 'Templates'],
                ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Print', 'SpellChecker', 'Scayt'],
                ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
                ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
                '/',
                ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
                ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'],
                ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
                ['Link', 'Unlink', 'Anchor'],
                ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'],
                '/',
                ['Styles', 'Format', 'Font', 'FontSize'],
                ['TextColor', 'BGColor'],
                ['Maximize', 'ShowBlocks', '-', 'About'],
                ['abbr', 'inserthtml']
            ]
        ],
    ]) ?>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'General'),
                'active' => true,
                'options' => ['id' => 'general'],
                'content' => $form->field($model, 'link_name')->textInput(['maxlength' => true, 'class' => 'record-name form-control'])
                    . $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'record-slug form-control'])
                    . $form->field($model, 'header')->textInput(['maxlength' => true])
                    . $form->field($model, 'visible')->dropdownList(Page::getVisibilityStatuses())
                    . $form->field($model, 'parent_id')->dropdownList(Category::getList(), ['prompt'=>''])
                    // https://github.com/2amigos/yii2-ckeditor-widget
                    . Html::tag('div', $pageContent, ['class' => 'page-content'])
            ],
            [
                'label' => Yii::t('app', 'Meta Tags'),
                'options' => ['id' => 'metatags'],
                'content' => $form->field($model, 'title')->textInput(['maxlength' => true])
                    . $form->field($model, 'meta_keywords')->textInput(['maxlength' => true])
                    . $form->field($model, 'meta_description')->textInput(['maxlength' => true])
            ],
            [
                'label' => Yii::t('app', 'Settings'),
                'options' => ['id' => 'settings'],
                'visible' => !$model->isNewRecord,
                'content' =>
                    (!$model->isNewRecord  ?
                        $form->field($model, 'creator')->textInput(['disabled' => true])
                        . $form->field($model, 'created')->textInput(['disabled' => true])
                        . $form->field($model, 'updated')->textInput(['disabled' => true])
                        : '')
            ],
            [
                'label' => Yii::t('app', 'Translations'),
                'options' => ['id' => 'translations'],
                'content' => $this->render('_translations', [
                    'form' => $form,
                    'model' => $model,
                    'languages' => Language::getList(false),
                ])
            ],
        ],
    ]); ?>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>
    
</div>