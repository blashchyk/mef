<?php
/* @var $this yii\web\View */
use common\widgets\Navigator;
?>
<br />
<hr />
<div class="row">
    <div class="col-lg-3">
        <?= Navigator::widget([
            'menuCode' => 'info',
        ]); ?>
    </div>

    <div class="col-lg-4">
        <h2><?= Yii::t('app', 'About Us') ?></h2>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
            fugiat nulla pariatur.
        </p>
        <p><a class="btn btn-default" href="#"><?= Yii::t('app', 'About Us') ?> &raquo;</a></p>
    </div>

    <div class="col-lg-4">
        <h2><?= Yii::t('app', 'About Us') ?></h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
            fugiat nulla pariatur.</p>
        <p><a class="btn btn-default" href="#"><?= Yii::t('app', 'Blog') ?> &raquo;</a></p>
    </div>
</div>