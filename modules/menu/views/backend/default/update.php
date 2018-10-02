<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\menu\models\Menu */

$this->title = Yii::t('app', 'Edit Menu') . ': ' . $model->name;
?>
<div class="menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
