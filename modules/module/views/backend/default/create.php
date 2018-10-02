<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\module\models\Module */

$this->title = Yii::t('app', 'Add Module');
?>
<div class="module-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
