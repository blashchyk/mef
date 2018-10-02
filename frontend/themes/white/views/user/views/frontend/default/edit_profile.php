<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Gallery;
use kartik\file\FileInput;

$this->params['breadcrumbs'][] = $this->title;

$fieldOptions = [
    'options' => ['class' => 'col-lg-6'],
    'inputOptions' => ['class' => 'form-control'],
];
$dateFieldOptions = ['options' => $fieldOptions['inputOptions'] + ['readonly' => true]];

$userAgeLimit  = 100;
$datePickerRange = (date('Y') - $userAgeLimit) . ':' . date('Y');
?>
<div class="site-signup">

    <div class="col-lg-10 col-lg-offset-1 panel panel-default">

        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'form-signup', 'options' => ['enctype' => 'multipart/form-data']]); ?>

            <div class="col-lg-12">

                <?= Gallery::widget() ?>

                <?= $form->field($model, 'avatar')->widget(FileInput::classname(), [
                    'pluginOptions' => [
                        'initialPreview' => [
                            !empty($model->avatar)
                                ? '<a href="' . $model->imageUrl . '" title="' . $model->username . '" data-gallery>'
                                . Html::img($model->imageThumbnailUrl, ['class' => 'img-preview', 'title' => $model->username, 'alt' => $model->username])
                                . '<br />'
                                . '</a>'
                                : null
                        ],
                        'overwriteInitial' => true,
                        'pluginLoading' => true,
                        'showCaption' => false,
                        'showUpload' => false,
                        'showClose' => false,
                        'removeClass' => 'btn btn-sm btn-red',
                        'browseClass' => 'btn btn-sm btn-blue',
                        'browseLabel' => '',
                        'removeLabel' => '',
                        'browseIcon' => '<i class="glyphicon glyphicon-picture"></i>',
                        'previewTemplates' => [
                            'generic' => '<div class="file-preview-frame" id="{previewId}" data-fileindex="{fileindex}">{content}</div>',
                            'image' => '<div class="file-preview-frame" id="{previewId}" data-fileindex="{fileindex}"><img src="{data}" class="img-preview" title="{caption}" alt="{caption}"></div>',
                        ]
                    ],
                ]) ?>

            </div>

            <?= $form->field($model, 'username', $fieldOptions)->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email', $fieldOptions)->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'first_name', $fieldOptions)->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'last_name', $fieldOptions)->textInput(['maxlength' => true]) ?>

            <div class="col-lg-12">
                <br />
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-red pull-left']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>