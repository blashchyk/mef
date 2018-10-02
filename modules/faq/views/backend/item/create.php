<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\faq\models\FaqItem */

$this->title = Yii::t('app', 'Add Question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
