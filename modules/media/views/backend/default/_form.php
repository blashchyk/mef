<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use common\widgets\Gallery;
use modules\media\models\Media;
use modules\media\models\Category;

/* @var $this yii\web\View */
/* @var $model modules\media\models\Media */
/* @var $form yii\widgets\ActiveForm */
?>

<?= Gallery::widget() ?>

<?php
$fileOptions = $thumbnailOptions = ['template' => '{label}<div class="col-md-9 col-xs-9">{input}{hint}{error}</div>'
        . '<div class="col-md-1 col-xs-1 no-indent">'
            . Html::button(Yii::t('app', 'Copy'), ['class' => 'btn btn-primary btn-clipboard', 'data-clipboard-target' => '#media-imageurl'])
        . '</div>'];
$thumbnailOptions['template'] = str_replace('imageurl', 'imagethumbnailurl', $fileOptions['template']);
?>

<div class="media-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>

    <div class="panel panel-default">

        <div class="panel-heading"><b><?= Yii::t('app', 'Media File') ?></b></div>

        <div class="panel-body">

            <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                'pluginOptions' => [
                    'initialPreview' => [
                        !empty($model->file)
                            ? ($model->type == Media::TYPE_IMAGE
                                ? '<a href="' . $model->imageUrl . '" title="' . $model->name . '" data-gallery>'
                                    . Html::img($model->imageThumbnailUrl, ['class' => 'img-preview', 'title' => $model->name, 'alt' => $model->name])
                                    . '<br />'
                                    . '</a>'
                                : '<video width="230" controls src="' . $model->imageUrl . '">'
                                    . Yii::t('app', 'Your browser does not support video')
                                    . '</video>')
                            : null
                    ],
                    'overwriteInitial' => true,
                    'pluginLoading' => true,
                    'showCaption' => false,
                    'showUpload' => false,
                    'showRemove' => false,
                    'showClose' => false,
                    'browseClass' => 'btn btn-success',
                    'browseLabel' => '',
                    'removeLabel' => '',
                    'browseIcon' => '<i class="glyphicon glyphicon-picture"></i>',
                    'previewTemplates' => [
                        'generic' => '<div class="file-preview-frame" id="{previewId}" data-fileindex="{fileindex}">
                                {content}
                            </div>',
                        'image' => '<div class="file-preview-frame" id="{previewId}" data-fileindex="{fileindex}">
                                <img src="{data}" class="img-preview" title="{caption}" alt="{caption}">
                            </div>',
                    ]
                ],
            ]) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'parent_id')->dropdownList(Category::getList(), ['prompt'=>'']) ?>

            <?= $form->field($model, 'visible')->dropDownList(Media::getVisibilityStatuses()) ?>

            <?php if (!$model->isNewRecord) : ?>

                <?= $form->field($model, 'imageUrl', $fileOptions)->textInput(['maxlength' => true, 'readonly' => true]) ?>

                <?php if ($model->type == Media::TYPE_IMAGE) : ?>
                    <?= $form->field($model, 'imageThumbnailUrl', $thumbnailOptions)->textInput(['maxlength' => true, 'readonly' => true]) ?>
                <?php endif; ?>

                <?= $form->field($model, 'creator')->textInput(['disabled' => true]) ?>

                <?= $form->field($model, 'created')->textInput(['disabled' => true]) ?>

                <?= $form->field($model, 'updated')->textInput(['disabled' => true]) ?>

            <?php endif; ?>

        </div>

    </div>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>