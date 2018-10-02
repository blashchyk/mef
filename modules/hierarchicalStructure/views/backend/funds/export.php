<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use modules\hierarchicalStructure\assets\backend\UploadFormAsset;
use modules\hierarchicalStructure\models\Funds;

UploadFormAsset::register($this);

/**
 * @var $uploadForm modules\hierarchicalStructure\models\UploadForm
 * @var $node modules\hierarchicalStructure\models\KartikTreeNode
 */

$fieldOptions = [
    'template' => '{label}<div class="col-md-6 col-sm-8">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-2 col-md-2 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];
$this->title = Yii::t('app', 'Export Funds');
?>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal']) ?>

<?= $form->field($funds, 'name', $fieldOptions)->dropDownList(Funds::getCode(), [
    'prompt' => Yii::t('app', 'Choose HS'),
]); ?>
<div class="clearfix"></div><br />

<?= $form->field($funds, 'format', $fieldOptions)->dropDownList(Funds::$formats); ?>
<div class="clearfix"></div><br />
<div class="col-md-8 col-sm-12">
    <div class="pull-right">
        <?= Html::submitButton(Yii::t('app', 'Export'), ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>
<div class="clearfix"></div><br /><br />

