<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\user\models\Profile */

$this->title = Yii::t('app', 'Edit Profile') . ': ' . $model->user->username;
?>

<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('@modules/profile/views/_form', [
        'model' => $model,
    ]) ?>

</div>