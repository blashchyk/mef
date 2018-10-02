<?php
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);
$this->title = $fund->title;
?>
<div class=<?= $isAdmin ? 'hierarchical-structure-index' : 'front-hs-index'; ?>>
    <?= !$isAdmin ? $this->render('_front-menu', ['fund' => $fundList]) : ''; ?>
    <?php
    if ($isAdmin) : ?>
        <?= $this->render('_go-back'); ?>
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <?= $this->render('_view-fund-stat', [
                    'fund' => $fund,
                ]); ?>

            </div>
            <?php if (isset($records)) : ?>
            <div class="col-md-8 col-sm-8">
                <?= $this->render('_view-record-stat', [
                        'records' => $records,
                        'fund' => $fund,
                        'allNodes' => $allNodes,
                ]); ?>

            </div>
            <?php endif; ?>

        </div>
        <div class="tree-widget-area js-tree-widget-area fund">
            <?= $this->render('_tree', [
                'isAdmin' => $isAdmin,
                'hsTree' => $fund->hsTree,
                'disabledButtons' => $disabledButtons,
                'id' => $id,
            ]); ?>
        </div>

    <?php endif; ?>
</div>
