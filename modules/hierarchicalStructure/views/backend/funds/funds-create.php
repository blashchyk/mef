<?php
?>
<div class="hs-create">
    <?= $this->render('_go-back'); ?>
    <h2><?= Yii::t('app', 'Create new Fund') ?></h2>

    <?= $this->render('_funds-form', [
        'fund' => $fund,
    ]) ?>
</div>
