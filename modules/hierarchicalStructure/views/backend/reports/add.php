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
        <div class="col-md-8"><h2><?= Yii::t('app', 'Upload file'); ?></h2></div>
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
            <?= $form->field($report, 'id')->hiddenInput(['value' => $report->id])->label(false) ?>
            <?= $form->field($report, 'file')->fileInput() ?>
            <div class="pull-right">
                <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>