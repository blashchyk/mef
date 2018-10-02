<?php
/* @var $hsId */
/* @var $hsName */
/* @var $nodesCount */
?>
<h2><?= $hsTree->name; ?></h2>
<div class="child-node-stat">
    <?= Yii::t('app', 'Numbers of nodes:') . ' ' . $nodesCount; ?>
    <?php if (isset($hsTree->funds)) : ?>
        <ul class="funds">
            <?php foreach ($hsTree->funds as $fund) : ?>
                <li><?= \yii\helpers\Html::a($fund->code, ['../hierarchicalStructure/funds/view', 'fundId' => $fund->id]) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>