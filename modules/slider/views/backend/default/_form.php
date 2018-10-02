<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use dosamigos\ckeditor\CKEditor;
use modules\theme\models\Theme;
use modules\i18n\models\Language;

/* @var $this yii\web\View */
/* @var $model modules\slider\models\Slider */
/* @var $form yii\widgets\ActiveForm */

$languages = Language::getList(false);
?>

<div class="slider-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>

    <?php
    $imageOptions = $thumbnailOptions = ['template' => '{label}<div class="col-md-9 col-xs-9">{input}{hint}{error}</div>'
        . '<div class="col-md-1 col-xs-1 no-indent">'
        . Html::button(Yii::t('app', 'Copy'), ['class' => 'btn btn-primary btn-clipboard', 'data-clipboard-target' => '#media-imageurl'])
        . '</div>'];
    $thumbnailOptions['template'] = str_replace('imageurl', 'imagethumbnailurl', $imageOptions['template']);

    $sliderDescription = $form->field($model, 'description', [
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

    <div>

        <?= Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'General'),
                    'active' => true,
                    'options' => ['id' => 'general', 'class' => 'panel-body'],
                    'content' => $this->render('_image', ['form' => $form, 'model' => $model])
                        . $form->field($model, 'name')->textInput(['maxlength' => true])
                        . $form->field($model, 'type')->dropdownList($model->getTypes())
                        . $form->field($model, 'video_url')->textInput(['maxlength' => true])
                        . $form->field($model, 'button_caption')->textInput(['maxlength' => true])
                        . $form->field($model, 'forward_url')->textInput(['maxlength' => true])
                        . $form->field($model, 'visible')->dropdownList($model->getVisibilityStatuses())
                        . $form->field($model, 'theme_id')->dropdownList(Theme::getList())
                        . $form->field($model, 'position')->dropdownList($model->getPositions())
                        . (!$model->isNewRecord ?
                            $form->field($model, 'creator')->textInput(['disabled' => true])
                            . $form->field($model, 'created')->textInput(['disabled' => true])
                            . $form->field($model, 'updated')->textInput(['disabled' => true])
                            : '')
                        . Html::tag('div', $sliderDescription, ['class' => 'page-content'])
                ],
                [
                    'label' => Yii::t('app', 'Translations'),
                    'options' => ['id' => 'translations'],
                    'content' => $this->render('_translations', [
                        'form' => $form,
                        'model' => $model,
                        'languages' => $languages,
                    ])
                ],
            ],
        ]); ?>

    </div>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>