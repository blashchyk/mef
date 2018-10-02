<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section bg-white">

    <div class="container">

        <div class="col-sm-12">
            <h2 class="block-title"><?= Yii::t('app', 'Profile Details') ?></h2>
        </div>

        <div class="panel-body">

            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped'],
                'attributes' => [
                    [
                        'attribute' => 'imageThumbnailUrl',
                        'format' => ['image', ['class' => 'img-thumbnail avatar']],
                    ],
                    'username',
                    'email:email',
                    'first_name',
                    'last_name',
                    'country.name',
                    'zip',
                    'city',
                    'address',
                    'phone',
                    'birthday:date',
                    'genderName',
                ],
            ]) ?>

            <div class="form-group">
                <?= Html::a(Yii::t('app', 'Change Password'), ['reset-password'], ['class' => 'btn btn-primary-magnet btn-block']) ?>
                <?= Html::a(Yii::t('app', 'Edit Profile'), ['edit-profile'], ['class' => 'btn btn-primary-magnet btn-block']) ?>
            </div>

        </div>

    </div>

</div>