<?php
use kartik\select2\Select2;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\snippet\models\Snippet;
use modules\page\models\Page;
use modules\snippet\models\SnippetPage;

/* @var $this yii\web\View */
/* @var $model modules\snippet\models\Snippet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="snippet-form col-lg-8 alert alert-info">
    <?php $form = ActiveForm::begin(); ?>
    <?= Tabs::widget([
        'items' => [
            [
                'label' => Yii::t('app', 'Snippet'),
                'content' => $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'record-name form-control'])
                    . $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'record-slug form-control'])
                    . $form->field($model, 'content')->textarea(['rows' => 8])
                    . $form->field($model, 'location')->dropDownList(Snippet::getLocations())
                    . $form->field($model, 'visible')->dropDownList(Snippet::getVisibilityStatuses())
                    . $form->field($model, 'page_ids', ['options' => ['class' => 'snippet-page-ids form-group' . ($model->visible != Snippet::VISIBLE_ON_SELECTED ? ' hidden' : '')]])->widget(Select2::className(), [
                        'data' => Page::getList(),
                        'options' => [
                            'multiple' => true,
                            'name' => 'assignment[]',
                            'value' => SnippetPage::getPageList($model->id),
                        ],
                    ])
            ],
            [
                'label' => Yii::t('app', 'Translation'),
                'content' => $this->render('_translations', [
                    'form' => $form,
                    'model' => $model,
                    'languages' => $languages,
                ])
            ]
        ]
    ]) ?>

    <div class="text-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
