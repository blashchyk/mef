<?php
?>
<div class="record-update">
    <?= $this->render('_go-back'); ?>
    <h2><?= Yii::t('app', 'Update Fund') ?></h2>

    <?= $this->render('_records-form', [
        'record' => $record,
        'file' => $file,
        'files' => $files,
        'active' => $active,
        'allNodes' => $allNodes,
    ]) ?>
</div>