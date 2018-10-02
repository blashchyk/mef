<?php
use yii\helpers\Html;
use modules\menu\models\MenuItem;
use modules\page\models\Page;
use modules\i18n\models\Language;

$languages = Language::getList(false);
?>

<?php
$fieldOptions = ['inputOptions' => ['class' => 'form-control input-sm']];
$selectOptions = ['inputOptions' => ['class' => 'inherited-select form-control input-sm']];
?>

<div class="hidden">
    <?= $form->field($model, '[' . ($model->id ? $model->id : 0) . ']type')->textInput() ?>
</div>

<div class="<?= $model->type == MenuItem::TYPE_PAGE ? '' : 'hidden' ?>">
    <?= $form->field($model, '[' . ($model->id ? $model->id : 0) . ']page_id', $fieldOptions)->dropdownList(Page::getList()) ?>

    <?= $form->field($model, '[' . ($model->id ? $model->id : 0) . ']inherited', $selectOptions)->dropdownList(MenuItem::getInheritedStatuses(), $fieldOptions) ?>
</div>

<div class="<?= $model->type == MenuItem::TYPE_LINK ? '' : 'hidden' ?>">
    <?= $form->field($model, '[' . ($model->id ? $model->id : 0) . ']url', $fieldOptions)->textInput(['maxlength' => true]) ?>
</div>

<div class="link-names <?= $model->type != MenuItem::TYPE_PAGE || !$model->inherited ? '' : 'hidden' ?>">

    <?= $form->field($model, '[' . ($model->id ? $model->id : 0) . ']link_name', $fieldOptions)->textInput(['maxlength' => true]) ?>

    <?php if (count($languages) > 0) : ?>

        <!-- Translations -->
        <div class="col-sm-2 col-md-2 col-xs-12"></div>
        <div class="col-md-10 col-sm-10 ui-sortable-handle">
            <b><?= Yii::t('app', 'Link Caption Translations') ?></b>
        </div>

        <?php foreach ($languages as $languageId => $languageName) : ?>
            <?php $translation = $model->translations[$languageId]; ?>
            <?= $form->field($translation, '[' . ($model->id ? $model->id : 0) . '][' . $languageId . ']link_name', $fieldOptions)->textInput(['maxlength' => true])
                ->label(Html::tag('div', '', ['class' => 'pull-right flag flag-' . $languageId])) ?>
        <?php endforeach; ?>
        <!-- /Translations -->

    <?php endif; ?>
</div>
