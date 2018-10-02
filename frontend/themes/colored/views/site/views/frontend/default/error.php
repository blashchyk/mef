<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error error-page">

    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-1">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="info-board info-board-red">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p class="lead">
            <?= Yii::t('app', 'The above error occurred while the Web server was processing your request.') ?>
        </p>
        <p>
            <?= Yii::t('app', 'Please contact us if you think this is a server error. Thank you.') ?>
        </p>

        <p class="links">
            <?= Html::a(Yii::t('app', 'Homepage'), ['index'], ['class' => 'btn-glass']) ?>
            <?= Html::a(Yii::t('app', 'About Us'), ['about'], ['class' => 'btn-glass']) ?>
            <?= Html::a(Yii::t('app', 'Contact Us'), ['contact'], ['class' => 'btn-glass']) ?>
        </p>
    </div>

</div>