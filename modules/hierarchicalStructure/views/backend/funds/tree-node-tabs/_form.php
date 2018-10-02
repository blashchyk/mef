<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\Records;
use common\services\FundService;

$fundId = Yii::$app->request->getQueryParam('fundId');
$fund = Funds::findOne($fundId);
$records = Records::find()->where(['fond_id' => $fund->id])->orderBy(['node_id' => SORT_ASC])->all();
$files  = FundService::getAllFiles($records);

?>
<?php


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

?>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Reference code')?>  </p>
    <p class="node-data-item"><?= $fund->code; ?></p>
</p>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Title')?>  </p>
    <p class="node-data-item"><?= $fund->title; ?></p>
</p>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Initial date')?>  </p>
    <p class="node-data-item"><?= Funds::viewDate($fund->date); ?></p>
</p>
<?php if (StringHelper::byteLength($fund->final_date)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Final date')?>  </p>
        <p class="node-data-item"><?= Funds::viewDate($fund->final_date); ?></p>
    </p>
<?php endif; ?>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Level of description')?>  </p>
    <p class="node-data-item"><?= $fund->level_description; ?></p>
</p>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Extent and medium of the unit of description (quantity, bulk, or size)')?>  </p>
    <p class="node-data-item"><?= StringHelper::truncate($fund->extent_description, $stringLength, $readMore); ?></p>
</p>
<p>
    <p class="node-data-label"><?= Yii::t('app', 'Name of creator')?>  </p>
    <p class="node-data-item"><?= $fund->creator; ?></p>
</p>
<?php if (StringHelper::byteLength($fund->administrative_history)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Administrative / Biographical history')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($fund->administrative_history, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->archival_history)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Archival history')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($fund->archival_history, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->trans)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Immediate source of acquisition or trans')?>  </p>
        <p class="node-data-item"><?= $fund->trans; ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($fund->content)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Scope and content')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($fund->content, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->information)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Appraisal, destruction and scheduling information')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($fund->information, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($fund->accruals)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Accruals')?>  </p>
        <p class="node-data-item"><?= $fund->accruals; ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($fund->arrangement)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'System of arrangement')?>  </p>
        <p class="node-data-item"><?= $fund->arrangement; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->access)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Conditions governing access')?>  </p>
        <p class="node-data-item"><?= $fund->access; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->reproduction)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Conditions governing reproduction')?>  </p>
        <p class="node-data-item"><?= $fund->reproduction; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->language)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Language / scripts of material')?>  </p>
        <p class="node-data-item"><?= $fund->language; ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($fund->characteristics)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Physical characteristics and technical requirements')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($fund->characteristics, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->aids)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Finding aids')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($fund->aids, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>
<?php if (StringHelper::byteLength($fund->location_originals)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Existence and location of originals')?>  </p>
        <p class="node-data-item"><?= $fund->location_originals; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->location_copies)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Existence and location of copies')?>  </p>
        <p class="node-data-item"><?= $fund->location_copies; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->related_units)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Related units of description')?>  </p>
        <p class="node-data-item"><?= $fund->related_units; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->publication_note)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Publication note')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($fund->publication_note, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->note)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Note')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($record->note, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->archivist_note)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Archivist\'s Note')?>  </p>
        <p class="node-data-item"><?= StringHelper::truncate($fund->archivist_note, $stringLength, $readMore); ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->rules)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Rules or Conventions')?>  </p>
        <p class="node-data-item"><?= $fund->rules; ?></p>
    </p>
<?php endif; ?>

<?php if (StringHelper::byteLength($fund->date_descriptions)) : ?>
    <p>
        <p class="node-data-label"><?= Yii::t('app', 'Date of descriptions')?>  </p>
        <p class="node-data-item"><?= $fund->date_descriptions; ?></p>
    </p>
<?php endif; ?>
    <?php foreach ($files as $file) : ?>
        <?php if (isset($file)) : ?>
            <?= Html::a(
                substr($file->path, strripos($file->path, '/') + 1, 10),
                ['funds/download-file', 'id' => $file->id],
                ['class' => 'btn btn-warning view', 'data-title' => substr($file->path, strripos($file->path, '/') + 1)]);?>
        <?php endif; ?>
    <?php endforeach; ?>

