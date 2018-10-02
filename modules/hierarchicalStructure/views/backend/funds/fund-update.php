<?php
/** @var \modules\hierarchicalStructure\models\Records $fund */
$this->title = Yii::t('app', 'Update') . " $fund->title";
?>
<div class="hs-update">
    <?= $this->render('_go-back'); ?>
    <h2><?= Yii::t('app', 'Update Fund') ?></h2>

    <?= $this->render('_funds-form', [
        'fund' => $fund,
    ]) ?>
</div>