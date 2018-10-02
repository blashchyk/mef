<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\quote\models\Quote */

$this->title = Yii::t('app', 'Create Quote');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Quotes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quote-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
