<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model modules\mail\models\Mail */

$this->title = Yii::t('app', 'View Email') . ': ' . $model->subject;
?>
<div class="mail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            /*[
                'attribute' => 'sender_name',
                'label' => 'Sender',
                'format' => 'html',
                'value' => $model->sender_name . (!empty($model->sender_email) ? ' <' . Html::mailto($model->sender_email, $model->sender_email) . '>' : ''),
            ],*/
            'sender:html',
            'subject',
            'created',
            'body:ntext',
            //'opened',
            //'updated_at',
        ],
    ]) ?>

    <div class="pull-right">
        <?= Html::a(Html::tag('span', null, ['class' => 'glyphicon glyphicon-arrow-left']) . ' ' . Yii::t('app', 'Back'), ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

</div>
