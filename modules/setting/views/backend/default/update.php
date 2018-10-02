<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\setting\models\Setting */

$this->title = Yii::t('app', 'Edit Setting') . ': ' . $model->title;
?>
<div class="setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
