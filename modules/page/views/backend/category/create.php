<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\page\models\Category */

$this->title = Yii::t('app', 'Add Category');
?>
<div class="page-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
