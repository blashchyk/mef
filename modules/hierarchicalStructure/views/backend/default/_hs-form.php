<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);

/** @var $form yii\widgets\ActiveForm */
/** @var \modules\hierarchicalStructure\models\HsTree $hs */

$fieldOptions = [
    'template' => '{label}<div class="col-md-7 col-sm-10">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-md-1 col-sm-2 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];
?>

<div class="hs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($hs, 'name', $fieldOptions)->textInput() ?>
    <?php echo $form->field($hs, 'description', $fieldOptions)->textarea() ?>
    <?php echo $form->field($hs, 'key', $fieldOptions)->textInput() ?>

    <div class="form-group">
        <div class="col-md-8">
            <?= Html::submitButton($hs->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $hs->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

