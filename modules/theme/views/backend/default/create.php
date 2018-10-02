<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\theme\models\Theme */

$this->title = Yii::t('app', 'Add Theme');
?>
<div class="theme-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
