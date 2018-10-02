<?php
use yii\helpers\StringHelper;
use yii\helpers\Html;
use \modules\hierarchicalStructure\models\HsTreeNode;

/**
 * @var $params array
 * @var $node modules\hierarchicalStructure\models\KartikTreeNode
 * @var $breadcrumbs
 * @var $modelClass
 * @var $parent
 * @var $parentKey
 * @var $isAdmin boolean
 */
extract($params);
$hsModel = $node->isNewRecord ? new HsTreeNode() : $node->hsTreeNode;
?>

    <p>
        <span class="node-data-label"><?= $node->isRoot() ? Yii::t('app', 'Code (root)') : Yii::t('app', 'CodePath'); ?> : </span>
        <span class="node-data-item"><?= $node->getCodePath(); ?></span>
    </p>
    <p>
        <span class="node-data-label"><?= Yii::t('app', 'Title') ?> : </span>
        <span class="node-data-item"><?= $node->name; ?></span>
    </p>

    <?php
    $stringLength = 4000;
    $readMore = Html::tag('span', '... ' . Html::a(Yii::t('app', 'Read more') . ' ' . Html::tag('span', null, ['class' => 'glyphicon glyphicon-arrow-right']), ['#'], ['class' => 'btn btn-sm btn-success']), ['id' => 'read-more']);
    $description = $hsModel->description;
    $notesApp = $hsModel->notes_application;
    $notesExcl = $hsModel->notes_exclusion;
    $parentId = $node->getParentNodeId();
    $active = $hsModel->active ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
    $conservationTerm = $hsModel->conservation_term;
    ?>
    <?php if(StringHelper::byteLength($description) !== 0) : ?>
    <p><span class="node-data-label"><?= Yii::t('app', 'Description') ?></span></p>
    <p>
        <?= StringHelper::truncate($description, $stringLength, $readMore) ?>
        <div id="read-text" class="hidden"><?= substr($description, $stringLength) ?></div>
    </p>
    <?php endif; ?>
    <?php if(StringHelper::byteLength($notesApp) !== 0) : ?>
    <p><span class="node-data-label"><?= Yii::t('app', 'Notes for applications') ?></span></p>
    <p>
        <?= StringHelper::truncate($notesApp, $stringLength, $readMore) ?>
        <div id="read-text" class="hidden"><?= substr($notesApp, $stringLength) ?></div>
    </p>
    <?php endif; ?>
    <?php if(StringHelper::byteLength($notesExcl) !== 0) : ?>
    <p><span class="node-data-label"><?= Yii::t('app', 'Notes for exclusion') ?></span></p>
    <p>
        <?= StringHelper::truncate($notesExcl, $stringLength, $readMore) ?>
        <div id="read-text" class="hidden"><?= substr($notesExcl, $stringLength) ?></div>
    </p>
    <?php endif; ?>
    <?php if(!empty($parentId)) : ?>
    <p>
        <span class="node-data-label"><?= Yii::t('app', 'Parent node id') ?> : </span>
        <span class="node-data-item"><?= $parentId; ?></span>
    </p>
    <?php endif; ?>
    <?php if($isAdmin) : ?>
        <p>
            <span class="node-data-label"><?= Yii::t('app', 'Active') ?> : </span>
            <span class="node-data-item"><?= $active; ?></span>
        </p>
    <?php endif; ?>

    <?php if(!empty($conservationTerm)) : ?>
        <p>
            <span class="node-data-label"><?= Yii::t('app', 'Conservation term') ?> : </span>
            <span class="node-data-item"><?= $conservationTerm ?></span>
        </p>
    <?php endif; ?>

    <?php if(!empty($hsModel->final_destination_id)) : ?>
        <p>
            <span class="node-data-label"><?= Yii::t('app', 'Final destination') ?> : </span>
            <span class="node-data-item"><?= $hsModel->finalDestination->description; ?></span>
        </p>
    <?php endif; ?>

