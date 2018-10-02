<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use modules\hierarchicalStructure\assets\backend\UploadFormAsset;
UploadFormAsset::register($this);
$this->title = Yii::t('app', 'Import Fond');
/**
 * @var $uploadForm modules\hierarchicalStructure\models\UploadForm
 * @var $node modules\hierarchicalStructure\models\KartikTreeNode
 */

$fieldOptions = [
    'template' => '{label}<div class="col-md-6 col-sm-8">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-2 col-md-2 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<div class="clearfix"></div><br />
<?= $form->field($uploadForm, 'importFile', $fieldOptions)->fileInput() ?>
<div class="col-md-6 col-md-8"><i style="color: #cc661c"><?= Yii::t('app', '* supported formats to import is .xml, .csv, .xlsx'); ?></i></div>
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
            <li><b><?= Yii::t('app', 'code');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'CODE');?></b></li>
            <li><b><?= Yii::t('app', 'title');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'TITLE');?></b></li>
            <li><b><?= Yii::t('app', 'date');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'DATE');?></b></li>
            <li><b><?= Yii::t('app', 'final_date');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'FINAL_DATE');?></b></li>
            <li><b><?= Yii::t('app', 'level_description');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'LEVEL_DESCRIPTION');?></b></li>
            <li><b><?= Yii::t('app', 'extent_description');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'EXTENT_DESCRIPTION');?></b></li>
            <li><b><?= Yii::t('app', 'creator');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'CREATOR');?></b></li>
            <li><b><?= Yii::t('app', 'administrative_history');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'ADMINISTRATIVE_HISTORY');?></b></li>
            <li><b><?= Yii::t('app', 'archival_history');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'ARCHIVAL_HISTORY');?></b></li>
            <li><b><?= Yii::t('app', 'trans');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'TRANS');?></b></li>
            <li><b><?= Yii::t('app', 'content');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'CONTENT');?></b></li>
            <li><b><?= Yii::t('app', 'information');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'INFORMATION');?></b></li>
            <li><b><?= Yii::t('app', 'accruals');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'ACCRUALS');?></b></li>
            <li><b><?= Yii::t('app', 'arrangement');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'ARRANGEMENT');?></b></li>
            <li><b><?= Yii::t('app', 'access');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'ACCESS');?></b></li>
            <li><b><?= Yii::t('app', 'reproduction');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'REPRODUCTION');?></b></li>
            <li><b><?= Yii::t('app', 'language');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'LANGUAGE');?></b></li>
            <li><b><?= Yii::t('app', 'aids');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'AIDS');?></b></li>
            <li><b><?= Yii::t('app', 'location_originals');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'LOCATION_ORIGINALS');?></b></li>
            <li><b><?= Yii::t('app', 'location_copies');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'LOCATION_COPIES');?></b></li>
            <li><b><?= Yii::t('app', 'related_units');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'RELATED_UNITS');?></b></li>
            <li><b><?= Yii::t('app', 'publication_note');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'PUBLICATION_NOTE');?></b></li>
            <li><b><?= Yii::t('app', 'note');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'NOTE');?></b></li>
            <li><b><?= Yii::t('app', 'archivist_note');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'ARCHIVIST_NOTE');?></b></li>
            <li><b><?= Yii::t('app', 'rules');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'RULES');?></b></li>
            <li><b><?= Yii::t('app', 'date_descriptions');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'DATE_DESCRIPTIONS');?></b></li>
            <li><b><?= Yii::t('app', 'keyHs');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'KEYHS');?></b></li>
            <li><b><?= Yii::t('app', 'records');?></b> <?=Yii::t('app', 'or');?><b> <?= Yii::t('app', 'RECORDS');?></b></li>

        </ul>

        <?= Yii::t('app', 'Fields in the document that are different from the above mentioned will be ignored. Fields can be specified in any order.'); ?>

        <?= Yii::t('app', 'The structure of the xml document should be as follows:'); ?>
        <pre>
            &lt;?xml version="1.0"?&gt;
            &lt;root&gt;
                &lt;row&gt;
                    &lt;field name="<b>code</b>"&gt;...&lt;/row&gt;
                    &lt;field name="<b>title</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>date</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>final_date</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>level_description</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>extent_description</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>creator</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>administrative_history</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>archival_history</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>trans</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>content</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>information</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>accruals</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>arrangement</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>access</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>language</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>characteristics</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>location_originals</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>location_copies</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>related_units</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>publication_note</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>note</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>archivist_note</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>rules</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>date_descriptions</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>keyHs</b>"&gt;...&lt;/field&gt;
                    &lt;field name="<b>records</b>"&gt;
                        &lt;row&gt;
                            &lt;field name="<b>code</b>"&gt;...&lt;/row&gt;
                            &lt;field name="<b>title</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>date</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>final_date</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>level_description</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>extent_description</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>creator</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>administrative_history</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>archival_history</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>trans</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>content</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>information</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>accruals</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>arrangement</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>access</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>language</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>characteristics</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>location_originals</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>location_copies</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>related_units</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>publication_note</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>note</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>archivist_note</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>rules</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>date_descriptions</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>fond_code</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>node_code</b>"&gt;...&lt;/field&gt;
                            &lt;field name="<b>files</b>"&gt;
                                &lt;row&gt;
                                     &lt;field name="<b>file_base64</b>"&gt;...&lt;/field&gt;
                                &lt;/row&gt;
                            &lt;/field&gt;
                        &lt;/row&gt;
                    &lt;/field&gt;
                &lt;/row&gt;
            &lt;/root&gt;
        </pre>
    </div>
</div>
<div class="clearfix"></div><br />