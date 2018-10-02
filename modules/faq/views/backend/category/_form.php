<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\i18n\models\Language;
use modules\faq\models\Category;

/* @var $this yii\web\View */
/* @var $model modules\faq\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(); ?>

    <?= Tabs::widget([
        'items' => [
            [
            'label' => Yii::t('app', 'General'),
            'active' => true,
            'options' => ['id' => 'general'],
            'content' => $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control record-name'])
                . $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'form-control record-slug'])
                . $form->field($model, 'keywords')->textInput(['maxlength' => true])
                . $form->field($model, 'visible')->dropdownList(Category::getVisibilityStatuses())
                . (!$model->isNewRecord ?
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
        ]
    ]); ?>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
