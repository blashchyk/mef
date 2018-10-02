<?php
?>
<div class="hs-create">
    <?= $this->render('_go-back'); ?>
    <h2><?= Yii::t('app', 'Create new Access Requests') ?></h2>

    <?= $this->render('_access-form', [
        'request' => $request,
    ]) ?>
</div>
