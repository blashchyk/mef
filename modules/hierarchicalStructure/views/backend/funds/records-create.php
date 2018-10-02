<?php

?>
<div class="records-create">
    <?= $this->render('_go-back'); ?>
    <h2><?= Yii::t('app', 'Add record') ?></h2>

    <?= $this->render('_records_form_create', [
        'record' => $record,
        'fundId' => $fundId,
        'file' => $file,
        'allNodes' => $allNodes,
    ]) ?>
</div>
