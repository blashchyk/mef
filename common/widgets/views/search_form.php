<?php
use yii\bootstrap\ActiveForm;
use kartik\slider\Slider;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
use yii\bootstrap\Html;
use yii\helpers\Url;
use modules\catalog\models\Filter;
?>

<h1 class="title-block second-child"><?= Yii::t('app', 'Search') ?></h1>

<?php $form = ActiveForm::begin(['method' => 'GET',]); ?>

    <?php $getDefaultFilterList = []; ?>

    <?php foreach ($model->getDefaultFilters() as $filter) : ?>
        <?= $form->field($model, $filter, ['options' => ['class' => 'hidden']])->hiddenInput(['maxlength' => true]) ?>
        <?php $getDefaultFilterList[$filter] = $model->getAttribute($filter) ?>
    <?php endforeach; ?>

    <?php foreach ($model->getFilters() as $filter) : ?>

        <?php if (empty($filter->category) || !empty($selectedCategory) && $filter->category->slug == $selectedCategory->slug) : ?>

            <?php $search = $model->getFilterInfo($filter); ?>

            <?php if ($filter->type == Filter::TYPE_STRING) : ?>
                <?= $form->field($search->model, $search->field)->textInput(['maxlength' => true])->label($search->label) ?>
            <?php elseif ($filter->type == Filter::TYPE_TYPEAHEAD) : ?>
                <?php $getDefaultFilterList['field'] = $search->field ?>
                <?= $form->field($search->model, $search->field)->widget(Typeahead::classname(), [
                    'model' => $search->model,
                    'attribute' => $search->field,
                    'options' => ['placeholder' => ''],
                    'scrollable' => true,
                    'pluginOptions' => ['highlight' => true],
                    'dataset' => [
                        [
                            'display' => 'value',
                            'remote' => [
                                'url' => Url::to(['value-list']) . '?query=%QUERY&' . http_build_query($getDefaultFilterList),
                                'wildcard' => '%QUERY'
                            ]
                        ]
                    ]
                ])->label($search->label) ?>
            <?php elseif ($filter->type == Filter::TYPE_RANGE) : ?>
                <?= $form->field($search->model, $search->field . 'Range', ['options' => ['class' => 'form-group range-wrapper']])->widget(Slider::classname(), [
                    'sliderColor' => Slider::TYPE_GREY,
                    //'handleColor' => Slider::TYPE_PRIMARY,
                    'pluginOptions' => [
                        'handle' => 'round',
                        'tooltip_split' => true,
                        'tooltip' => 'always',
                        'min' => $search->model->filterValues[$search->field . 'RangeMin'],
                        'max' => $search->model->filterValues[$search->field . 'RangeMax'],
                        'step' => 1,
                        'range' => true
                    ],
                ])->label('Price Range') ?>
            <?php elseif ($filter->type == Filter::TYPE_SELECT) : ?>
                <?= $form->field($search->model, $search->field)->dropdownList($search->model->getValueListSelect($search->field), ['prompt' => ''])->label($search->label) ?>
            <?php elseif ($filter->type == Filter::TYPE_SELECT2 || $filter->type == Filter::TYPE_MULTIPLE) : ?>
                <?= $form->field($search->model, $search->field)->widget(Select2::className(), [
                    'data' => $search->model->getValueListSelect($search->field),
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => false,
                        'multiple' => $filter->type == Filter::TYPE_MULTIPLE,
                    ],
                ])->label($search->label) ?>
            <?php endif; ?>

        <?php endif; ?>

    <?php endforeach; ?>

    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn ' . $submitButtonClass]) ?>

<?php ActiveForm::end(); ?>