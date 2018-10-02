<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $model modules\i18n\models\Translation */

$this->title = Yii::t('app', 'Edit Translation') . ': ' . StringHelper::truncate(strip_tags($model->message->message), 50, '...');
?>
<div class="translation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
