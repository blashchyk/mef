<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\country\models\Country */

$this->title = Yii::t('app', 'Add Country');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
