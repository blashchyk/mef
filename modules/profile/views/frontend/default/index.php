<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\profile\models\Profile */

$this->title = $model->user->username;

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user.username',
            'country.name',
            'city',
            'address',
            'phone',
            'zip',
            'birthday:date',
            'genderName',
        ],
    ]) ?>

</div>