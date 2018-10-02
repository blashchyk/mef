<?php

/* @var $this yii\web\View */
/* @var $user modules\user\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/confirm-signup', 'token' => $user->access_token]);
?>
<?= Yii::t('app', 'Hello') ?> <?= $user->username ?>,

<?= Yii::t('app', 'Thank you for signup') ?>.

<?= Yii::t('app', 'Follow the link below to confirm your email') ?>:

<?= $confirmLink ?>


<?= Yii::t('app', 'Your personal data') ?>:

<?= $user->getAttributeLabel('username') ?>: <?= !empty($user->username) ? $user->username : '-' ?>

<?= $user->getAttributeLabel('email') ?>: <?= !empty($user->email) ? $user->email : '-' ?>

<?= $user->getAttributeLabel('password') ?>: <?= !empty($user->password) ? $user->password : '-' ?>

<?= $user->getAttributeLabel('first_name') ?>: <?= !empty($user->first_name) ? $user->first_name : '-' ?>

<?= $user->getAttributeLabel('last_name') ?>: <?= !empty($user->last_name) ? $user->last_name : '-' ?>
