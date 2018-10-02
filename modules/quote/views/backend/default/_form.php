<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use modules\i18n\models\Language;

/* @var $this yii\web\View */
/* @var $model modules\quote\models\Quote */
/* @var $form yii\widgets\ActiveForm */
$languages = Language::getList(false);
?>

<div class="quote-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'Generel'),
                'active' => true,
                'options' => ['id' => 'general'],
                'content' => $this->render('_image', ['form' => $form, 'model' => $model])
                    . $form->field($model, 'name')->textInput(['maxlength' => true])
                    . $form->field($model, 'description')->textarea(['rows' => 6])
                    . $form->field($model, 'visible')->dropdownList($model->getVisibilityStatuses())
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
                    'languages' => $languages,
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
