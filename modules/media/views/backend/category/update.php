<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\media\models\Category */

$this->title = Yii::t('app', 'Edit Category') . ': ' . $model->name;
?>
<div class="media-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
