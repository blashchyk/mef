<?php
use yii\helpers\Html;
?>
<div class="back-hs-list">
    <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>',
        ['/hierarchicalStructure/default/index']) . '<span class="back-text">' . Yii::t('app', 'back to HS list') . '</span>'; ?>
</div>