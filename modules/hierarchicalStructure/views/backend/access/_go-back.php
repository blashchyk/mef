<?php
use yii\bootstrap\Html;
?>
<div class="back-hs-list">
    <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>',
        ['/hierarchicalStructure/access/index']) . '<span class="back-text">' . Yii::t('app', 'back to Access Requests list') . '</span>'; ?>
</div>
