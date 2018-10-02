<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\media\models\Media */

$this->title = Yii::t('app', 'Edit File') . ': ' . (!empty($model->name) ? $model->name : Yii::t('app', 'Noname'));
?>
<div class="media-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
