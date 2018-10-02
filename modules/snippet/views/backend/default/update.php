<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\snippet\models\Snippet */

$this->title = Yii::t('app', 'Edit Snippet') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Snippets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="snippet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages
    ]) ?>

</div>
