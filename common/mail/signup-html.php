<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user modules\user\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/confirm-signup', 'token' => $user->access_token]);
?>
<div class="password-reset">
    <p><?= Yii::t('app', 'Hello') ?> <?= Html::encode($user->username) ?>,</p>

    <p><?= Yii::t('app', 'Thank you for signup') ?>.</p>

    <p><?= Yii::t('app', 'Follow the link below to confirm your email') ?>:</p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>

    <p>
        <b><?= Yii::t('app', 'Your personal data') ?>:</b><br />

        <?= $user->getAttributeLabel('username') ?>: <?= !empty($user->username) ? $user->username : '-' ?><br />

        <?= $user->getAttributeLabel('email') ?>: <?= !empty($user->email) ? $user->email : '-' ?><br />

        <?= $user->getAttributeLabel('password') ?>: <?= !empty($user->password) ? $user->password : '-' ?><br />

        <?= $user->getAttributeLabel('first_name') ?>: <?= !empty($user->first_name) ? $user->first_name : '-' ?><br />

        <?= $user->getAttributeLabel('last_name') ?>: <?= !empty($user->last_name) ? $user->last_name : '-' ?><br />

    </p>
</div>
