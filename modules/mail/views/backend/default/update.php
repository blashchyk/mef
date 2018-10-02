<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\mail\models\Mail */

$this->title = Yii::t('app', 'Edit Email') . ': ' . $model->subject;
?>
<div class="mail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
