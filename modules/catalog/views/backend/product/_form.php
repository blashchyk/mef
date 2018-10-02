<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\i18n\models\Language;
use modules\catalog\models\Category;
use modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\Product */
/* @var $form yii\widgets\ActiveForm */

$languages = Language::getList(false);
$priceFieldOptions = [
    'template' => '{label}
        <div class="col-sm-10">
            <div class=input-group col-sm-10">
                <span class="input-group-addon"><span class="glyphicon glyphicon-usd"></span></span>
                {input}
            </div>
            {error}
            {hint}
        </div>'
];
?>

<div class="product-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>

    <div>

        <?= Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'General'),
                    'active' => true,
                    'options' => ['id' => 'general', 'class' => 'panel-body'],
                    'content' => $this->render('_image', ['form' => $form, 'model' => $model])
                        . $form->field($model, 'parent_id')->dropdownList(Category::getList())
                        . $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'record-name form-control'])
                        . $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'record-slug form-control'])
                        . $form->field($model, 'producer')->textInput(['maxlength' => true])
                        . $form->field($model, 'price', $priceFieldOptions)->textInput([])
                        . $form->field($model, 'description')->textarea(['rows' => 6])
                        . $form->field($model, 'visible')->dropdownList(Product::getVisibilityStatuses())
                        . $this->render('_fields', ['form' => $form, 'model' => $model])
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
