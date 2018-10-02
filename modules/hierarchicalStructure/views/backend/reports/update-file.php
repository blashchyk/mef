<?php
use yii\helpers\Html;
use modules\hierarchicalStructure\assets\backend\HsAsset;
use yii\widgets\ActiveForm;
HsAsset::register($this);

/** @var $dataProvider */
?>
<div class="hierarchical-structure-index">
    <div id="response"></div>
    <div class="row list-header">
        <div class="col-md-8"><h2><?= Yii::t('app', 'Update file'); ?></h2></div>
        <?php if (Yii::$app->user->can('hierarchicalStructure.reports.update')) :  ?>
            <div class="col-md-4"></div>
        <?php endif; ?>
    </div>
    <div class="row hs-table-list">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin([
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'class' => 'form-horizontal',
                ]
            ]); ?>
            <?= $form->field($file, 'record_id')->hiddenInput(['value' => $file->record_id])->label(false) ?>
            <?= $form->field($file, 'id')->hiddenInput(['value' => $file->id])->label(false) ?>
            <?= $form->field($file, 'path')->fileInput() ?>
            <div class="pull-right">
                <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>