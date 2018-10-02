<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">

    <div class="col-lg-10 col-lg-offset-1 panel panel-default"><br />

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

            <div class="form-group pull-left">
                <?= Html::a(Yii::t('app', 'Change Password'), ['reset-password'], ['class' => 'btn btn-red']) ?>
                <?= Html::a(Yii::t('app', 'Edit Profile'), ['edit-profile'], ['class' => 'btn btn-red']) ?>
            </div>

        </div>

    </div>

</div>