<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\media\models\Category */

$this->title = Yii::t('app', 'Add Category');
?>
<div class="media-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
