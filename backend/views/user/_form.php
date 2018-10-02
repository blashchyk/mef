<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var yii\web\View $this */
/* @var common\models\User $model */
/* @var yii\widgets\ActiveForm $form */


?>

<div class="user-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => 'form-horizontal',
        ]
    ]); ?>

        <?php $activeTab = !empty($activeTab) ? $activeTab : 'general'; ?>

        <?= Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'General'),
                    'active' => empty($activeTab) || $activeTab == 'general',
                    'options' => ['id' => 'general'],
                    'content' => $this->render('_general', ['form' => $form, 'model' => $model]),
                ],
                [
                    'label' => Yii::t('app', 'Settings'),
                    'active' => $activeTab == 'settings',
                    'options' => ['id' => 'settings'],
                    'content' => $this->render('_settings', ['form' => $form, 'model' => $model]),
                    'visible' => Yii::$app->user->can('user.delete'),
                ],
                [
                    'label' => Yii::t('app', 'Password'),
                    'active' => $activeTab == 'password',
                    'options' => ['id' => 'password'],
                    'content' => $this->render('_password', ['form' => $form, 'model' => $model]),
                ],
                [
                    'label' => Yii::t('app', 'Role'),
                    'active' => $activeTab == 'role',
                    'options' => ['id' => 'role'],
                    'content' => $this->render('_role', ['form' => $form, 'model' => $model]),
                    'visible' => Yii::$app->user->can('role.update'),
                ],
                [
                    'label' => Yii::t('app', 'Token'),
                    'active' => $activeTab == 'token',
                    'options' => ['id' => 'token'],
                    'content' => $this->render('_token', ['form' => $form, 'model' => $model]),
                ],
            ],
        ]);?>

        <div class="pull-right">
            <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
