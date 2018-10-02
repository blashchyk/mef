<?php

use  yii\helpers\Html;
use yii\helpers\StringHelper;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\controllers\backend\FundsController;

$stringLength = 100000;
$readMore = Html::tag(
        'span',
        '... ' . Html::a(
                Yii::t(
                        'app',
                        'Read more'
                ) . ' ' . Html::tag(
                        'span',
                        null,
                        ['class' => 'glyphicon glyphicon-arrow-right']
                ),
                ['#'],
                ['class' => 'btn btn-sm btn-success']),
        ['id' => 'read-more']
);
$node_code = KartikTreeNode::getNoteCode($record->node_id);
$parent_record_code = FundsController::getCodeRecordParent($record->node_id);
$fund_code = Funds::findOne($record->fond_id);
?>

<p>
    <p class="node-data-label"><?= Yii::t('app', 'Reference code')?>  </p>
    <p class="node-data-item"><?= $fund_code->code
        . (!empty(str_replace('.', '', $node_code))
            ? (FundsController::DELIMITER_RECORDS . trim($node_code, FundsController::DELIMITER))
            : '')
        . (isset($parent_record_code)
            ? FundsController::DELIMITER_RECORDS . $parent_record_code
            : '')
        . FundsController::DELIMITER_RECORDS
        . $record->code;
    ?></p>
</p>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Title')?>  </p>
    <p class="node-data-item"><?= $record->title; ?></p>
</p>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Initial date')?>  </p>
    <p class="node-data-item"><?= Funds::viewDate(date('Y-m-d', $record->date)); ?></p>
</p>
<?php if (StringHelper::byteLength($record->final_date)) : ?>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Final date')?>  </p>
    <p class="node-data-item"><?= Funds::viewDate(date('Y-m-d', $record->final_date)); ?></p>
</p>
<?php endif; ?>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Level of description')?>  </p>
    <p class="node-data-item"><?= $record->level_description; ?></p>
</p>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Extent and medium of the unit of description (quantity, bulk, or size)')?>  </p>
    <p class="node-data-item"><?= StringHelper::truncate($record->extent_description, $stringLength, $readMore); ?></p>
</p>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Name of creator')?>  </p>
    <p class="node-data-item"><?= $record->creator; ?></p>
</p>
<?php if (StringHelper::byteLength($record->administrative_history)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Administrative / Biographical history')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->administrative_history, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->archival_history)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Archival history')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->archival_history, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->trans)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Immediate source of acquisition or trans')?>  </p>
        <p class="node-data-item"><?= $record->trans; ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($record->content)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Scope and content')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->content, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->information)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Appraisal, destruction and scheduling information')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->information, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($record->accruals)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Accruals')?>  </p>
        <p class="node-data-item"><?= $record->accruals; ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($record->arrangement)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'System of arrangement')?>  </p>
        <p class="node-data-item"><?= $record->arrangement; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->access)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Conditions governing access')?>  </p>
        <p class="node-data-item"><?= $record->access; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->reproduction)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Conditions governing reproduction')?>  </p>
        <p class="node-data-item"><?= $record->reproduction; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->language)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Language / scripts of material')?>  </p>
        <p class="node-data-item"><?= $record->language; ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($record->characteristics)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Physical characteristics and technical requirements')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->characteristics, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->aids)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Finding aids')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->aids, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($record->location_originals)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Existence and location of originals')?>  </p>
        <p class="node-data-item"><?= $record->location_originals; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->location_copies)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Existence and location of copies')?>  </p>
        <p class="node-data-item"><?= $record->location_copies; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->related_units)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Related units of description')?>  </p>
        <p class="node-data-item"><?= $record->related_units; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->publication_note)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Publication note')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->publication_note, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->note)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Note')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->note, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->archivist_note)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Archivist\'s Note')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->archivist_note, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->rules)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Rules or Conventions')?>  </p>
        <p class="node-data-item"><?= $record->rules; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($record->date_descriptions)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Date of descriptions')?>  </p>
        <p class="node-data-item"><?= $record->date_descriptions; ?></p>
    </p>
<?php endif; ?>

<?php if (isset($files)) : ?>
    <?= $files; ?>
<?php endif; ?>



