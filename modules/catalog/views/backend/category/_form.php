<?php
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\i18n\models\Language;
use modules\catalog\models\Category;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

        <?php $activeTab = !empty($activeTab) ? $activeTab : 'general'; ?>

        <?= Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'General'),
                    'active' => empty($activeTab) || $activeTab == 'general',
                    'options' => ['id' => 'general', 'class' => 'panel-body'],
                    'content' => $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'record-name form-control'])
                        . $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'record-slug form-control'])
                        . $form->field($model, 'description')->textarea(['rows' => 6])
                        . $form->field($model, 'visible')->dropdownList(Category::getVisibilityStatuses())
                        . (!$model->isNewRecord ?
                            $form->field($model, 'creator')->textInput(['disabled' => true])
                            . $form->field($model, 'created')->textInput(['disabled' => true])
                            . $form->field($model, 'updated')->textInput(['disabled' => true])
                            : '')
                ],
                [
                    'label' => Yii::t('app', 'Fields'),
                    'active' => $activeTab == 'fields',
                    'options' => ['id' => 'fields'],
                    'content' => $this->render('_fields', [
                        'form' => $form,
                        'model' => $model,
                    ])
                ],
                [
                    'label' => Yii::t('app', 'Translations'),
                    'active' => $activeTab == 'translations',
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