<?php
use common\widgets\SocialChoice;

/* @var common\models\User $model */


?>

<?= SocialChoice::widget([
    'baseAuthUrl' => ['/site/auth'],
    'popupMode' => false,
    'isAccountOwner' => $model->id == Yii::$app->user->id,
    'auths' => $model->auths,
    'addButtonTitle' => Yii::t('app', 'Link a new Social Account'),
]);
