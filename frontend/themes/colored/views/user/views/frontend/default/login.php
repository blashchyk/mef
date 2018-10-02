<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\login\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;

$userOptions = [
    'inputOptions' => ['class' => 'form-control'],
    'template' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>{input}</div>',
];
$passwordOptions = [
    'inputOptions' => ['class' => 'form-control'],
    'template' => '<div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>{input}</div>',
]
?>

<div class="site-login">

    <div class="section bg-white">

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <div class="container login">
                <div class="col-sm-12">
                    <h2 class="block-title"><?= Yii::t('app', 'Sign In to Your Account') ?></h2>
                </div>

                <div class="panel-body col-lg-8 col-lg-offset-2">

                    <div class="alert alert-danger">
                        <?= Yii::t('app', 'Demo user credentials for examination') ?>:<br />
                        <?= Yii::t('app', 'Username/password') ?>: <b>demo/demo</b>
                    </div>

                    <p>
                        <?= Yii::t('app', 'Please fill out the following fields to login:') ?>
                    </p>

                    <?= $form->field($model, 'username', $userOptions) ?>

                    <br/>

                    <?= $form->field($model, 'password', $passwordOptions)->passwordInput() ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary-magnet', 'name' => 'login-button']) ?>
                    </div>

                    <br/>

                    <h3 class="title-block second-child"><?= Yii::t('app', 'Sign In With') ?>...</h3>

                    <?= AuthChoice::widget([
                        'baseAuthUrl' => ['/user/auth'],
                        'popupMode' => false,
                    ]) ?>

                    <div class="note">
                        <?= Yii::t('app', 'If you forgot your password you can') ?> <?= Html::a(Yii::t('app', 'reset it'), ['request-password-reset']) ?>.
                    </div>
                    <br/>

                </div>

            </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>