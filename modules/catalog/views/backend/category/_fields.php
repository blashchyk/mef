<?php
use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use modules\catalog\models\Field;
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper',
    'widgetBody' => '.container-items',
    'widgetItem' => '.item',
    'min' => 0,
    'insertButton' => '.add-item',
    'deleteButton' => '.remove-item',
    'model' => $model->additionalFields[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'name',
        'type',
    ],
]); ?>

<div class="pull-left">
    <h3><?= Yii::t('app', 'Additional Fields') ?></h3>
</div>
<div class="pull-right">
    <button type="button" class="add-item btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> <?= Yii::t('app', 'Add Field') ?></button>
</div>
<div class="clearfix"></div>
<br />

<?php
$emptyListClass = 'empty-list-message';
if (count($model->fields) > 0) {
    $emptyListClass .= ' hidden';
}
?>
<p class="<?= $emptyListClass?>"><?= Yii::t('app', 'The list does not contain any items.') ?></p>

<?php $template = '<div class="row"> <div class="col-xs-5 col-sm-5 col-md-4">{label}</div> <div class="col-xs-7 col-sm-7 col-md-8">{input}{error}{hint}</div></div>'; ?>

<div class="container-items">
    <?php foreach ($model->additionalFields as $key => $field) : ?>
        <div class="item row">
            <?php if (!$field->isNewRecord) : ?>
                <?= Html::activeHiddenInput($field, "[{$key}]id") ?>
            <?php endif; ?>
            <div class="col-xs-9 col-sm-5 col-md-5">
                <?= $form->field($field, "[{$key}]name", ['template' => $template])->textInput(['maxlength' => true, 'class' => 'form-control'])->label(Yii::t('app', 'Name'), ['class' => 'control-label pull-right']) ?>
            </div>
            <div class="col-xs-9 col-sm-5 col-md-5">
                <?= $form->field($field, "[{$key}]type", ['template' => $template])->dropdownList(Field::getValueTypes(), ['maxlength' => true, 'class' => 'form-control'])->label(Yii::t('app', 'Type'), ['class' => 'control-label pull-right']) ?>
            </div>
            <div class="col-xs-3 col-sm-2 col-md-2">
                <button type="button" class="remove-item btn btn-danger btn-sm" data-message="<?= Yii::t('app', 'Are you sure you want to delete this item?') ?>"><i class="glyphicon glyphicon-remove "></i></button>
            </div>
        </div>
    <?php endforeach;  ?>
</div>
<?php DynamicFormWidget::end(); ?>