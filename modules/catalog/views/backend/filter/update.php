<?php

use yii\helpers\Html;
use modules\catalog\models\Product;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\Filter */

$this->title = Yii::t('app', 'Edit Filter') . ': ' . (!empty(Product::getFields()[$model->field]) ? Product::getFields()[$model->field] : $model->field);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Filters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="filter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
