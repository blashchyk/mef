<?php
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);

/* @var $this yii\web\View */
/* @var $hsList array*/
/* @var $isAdmin boolean */
/* @var $hsTree HsTree */
/* @var int $nodesCount */
/* @var array $disabledButtons */
$this->title = $hsTree->name;
?>
<div class=<?= $isAdmin ? 'hierarchical-structure-index' : 'front-hs-index'; ?>>
    <?= !$isAdmin ? $this->render('_front-menu', ['hsList' => $hsList]) : ''; ?>
    <?php
    if ($isAdmin) : ?>
        <?= $this->render('@modules/hierarchicalStructure/views/backend/default/_go-back'); ?>
    <div class="row">
        <div class="col-md-7 col-sm-12">
            <?= $this->render('_view-hs-stat', [
                'nodesCount' => $nodesCount,
                'hsTree' => $hsTree,
            ]); ?>
        </div>

        </div>
    </div>
    <?php endif; ?>
    <div class="tree-widget-area js-tree-widget-area">
        <?= $this->render('_tree', [
            'isAdmin' => $isAdmin,
            'hsTree' => $hsTree,
            'disabledButtons' => $disabledButtons
        ]); ?>
    </div>
</div>