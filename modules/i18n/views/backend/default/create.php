<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Translation */

$this->title = Yii::t('app', 'Add Translation');
?>
<div class="translation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
