<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\assets\backend\UploadFormAsset;
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
$this->title = Yii::t('app', 'Import HS');
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($node, 'hs_tree_id', $fieldOptions)->dropDownList( ArrayHelper::map(HsTree::find()->where(['type' => 1])->all(), 'id', 'name'), [
    'prompt' => Yii::t('app', 'Choose HS'),
]); ?>
<div class="clearfix"></div><br />
<?= $form->field($uploadForm, 'importFile', $fieldOptions)->fileInput() ?>
<div class="col-md-6 col-md-8"><i style="color: #cc661c"><?= Yii::t('app', '* supported formats to import are .xlsx, .xml, .cvs'); ?></i></div>
<div class="col-md-8 col-sm-12">
    <div class="pull-right">
        <?= Html::submitButton(Yii::t('app', 'Upload data'), ['class' => 'btn btn-success js-start-import-analise']) ?>
    </div>
</div>

<?php ActiveForm::end() ?>
<div class="clearfix"></div><br /><br />
<div class="js-load-analise-import load-analise-import">
    <?= Yii::t('app', 'Data analysis is in progress'); ?>
    <?= $this->render('_import-preloader'); ?>
</div><br />
<div class="col-md-8 col-sm-12">
    <div class="collapse-import-info js-collapse-import-info">
        <span class="glyphicon glyphicon-plus-sign js-plus"></span>
        <span class="glyphicon glyphicon-minus-sign js-minus"></span>
        <span class="import-info-label" ><?= Yii::t('app', 'Import INFO'); ?></span>
    </div>
    <div class="import-notice-area js-import-notice-area">
        <?= Yii::t('app', 'As the names for the fields of the imported documents the following values should be used (both uppercase and lowercase letters are allowed):'); ?>
        <ul>
            <li><b><?= Yii::t('app', 'code');?></b> <?= Yii::t('app', 'or');?><b> <?= Yii::t('app', 'CODE');?></b></li>
            <li><b><?= Yii::t('app', 'title');?></b> <?= Yii::t('app', 'or');?><b> <?= Yii::t('app', 'TITLE');?></b></li>
            <li><b><?= Yii::t('app', 'term');?></b> <?= Yii::t('app', 'or');?><b> <?= Yii::t('app', 'TERM');?></b></li>
            <li><b><?= Yii::t('app', 'final_destination');?></b> <?= Yii::t('app', 'or');?><b> <?= Yii::t('app', 'FINAL_DESTINATION');?></b></li>
            <li><b><?= Yii::t('app', 'description');?></b> <?= Yii::t('app', 'or');?><b> <? Yii::t('app', 'DESCRIPTION');?></b></li>
            <li><b><?= Yii::t('app', 'notes_for_use');?></b> <?= Yii::t('app', 'or');?><b> <?= Yii::t('app', 'NOTES_FOR_USE');?></b></li>
            <li><b><?= Yii::t('app', 'notes_for_exclusion');?></b> <?= Yii::t('app', 'or');?> <b><?= Yii::t('app', 'NOTES_FOR_EXCLUSION');?></b></li>
        </ul>

        <?= Yii::t('app', 'Fields in the document that are different from the above mentioned will be ignored. Fields can be specified in any order.'); ?>

        <?= Yii::t('app', 'The structure of the xml document should be as follows:'); ?>
        <pre>
            &lt;?xml version="1.0"?&gt;
            &lt;root&gt;
                &lt;row name="<b>code</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>title</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>term</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>final_destination</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>description</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>notes_for_use</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>notes_for_exclusion</b>"&gt;...&lt;/row&gt;
            &lt;/root&gt;
                ...
            &lt;root&gt;
                &lt;row name="<b>code</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>title</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>term</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>final_destination</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>description</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>notes_for_use</b>"&gt;...&lt;/row&gt;
                &lt;row name="<b>notes_for_exclusion</b>"&gt;...&lt;/row&gt;
            &lt;/root&gt;
        </pre>
    </div>
</div>
<div class="clearfix"></div><br />