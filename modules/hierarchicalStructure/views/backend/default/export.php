<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\assets\backend\UploadFormAsset;
use modules\hierarchicalStructure\models\KartikTreeNode;
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
$this->title = Yii::t('app', 'Export HS');
?>

<?php $form = ActiveForm::begin(['class' => 'form-horizontal']) ?>

<?= $form->field($node, 'hs_tree_id', $fieldOptions)->dropDownList( ArrayHelper::map(HsTree::find()->where(['type' => 1])->all(), 'id', 'name'), [
    'prompt' => Yii::t('app', 'Choose HS'),
]); ?>
<div class="clearfix"></div><br />
<?= $form->field($node, 'format', $fieldOptions)->dropDownList(KartikTreeNode::$formats); ?>
<div class="clearfix"></div><br />
<div class="col-md-8 col-sm-12">
    <div class="pull-right">
        <?= Html::submitButton(Yii::t('app', 'Export'), ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>
<div class="clearfix"></div><br /><br />

