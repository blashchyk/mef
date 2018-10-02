<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\snippet\models\Snippet */

$this->title = Yii::t('app', 'Add Snippet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Snippets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'languages' => $languages
    ]) ?>

</div>
