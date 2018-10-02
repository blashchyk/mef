<?php

use yii\helpers\Html;

$this->title = $name;
?>

<div class="site-error container">
    <?= Html::tag('h1', Html::encode($this->title)) ?>
    <div class="alert alert-danger">
        <?= HTML::encode($message) ?>
    </div>

    <?= Html::tag('p', 'The above error occurred while the Web server was processing your request.') ?>
    <?= Html::tag('p', 'Please contact us if you think this is a server error. Thank you.') ?>
    <div class="version">
        <?= date('Y-m-d H:i:s', time()) ?>
    </div>
</div>