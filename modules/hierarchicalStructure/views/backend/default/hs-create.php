<?php
/** @var \modules\hierarchicalStructure\models\HsTree $hs */
?>

<div class="hs-create">
    <?= $this->render('_go-back'); ?>
    <h2><?= Yii::t('app', 'Create new HS') ?></h2>

    <?= $this->render('_hs-form', [
        'hs' => $hs,
    ]) ?>
</div>
