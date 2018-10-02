<?php
/** @var \modules\hierarchicalStructure\models\HsTree $hs */
$this->title = Yii::t('app', 'Update') . " $hs->name";
?>

<div class="hs-update">
    <?= $this->render('_go-back'); ?>
    <h2><?= Yii::t('app', 'Update HS') ?></h2>

    <?= $this->render('_hs-form', [
        'hs' => $hs,
    ]) ?>
</div>