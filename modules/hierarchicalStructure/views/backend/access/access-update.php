<?php
/** @var \modules\hierarchicalStructure\models\Records $fund */
$this->title = Yii::t('app', 'Update access request');
?>
<div class="hs-update">
    <?= $this->render('_go-back'); ?>
    <h2><?= Yii::t('app', 'Update access request') ?></h2>

    <?= $this->render('_access-form', [
        'request' => $request,
    ]) ?>
</div>