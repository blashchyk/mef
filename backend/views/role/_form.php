<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;
use backend\assets\AppAsset;

/* @var yii\web\View $this */
/* @var common\models\RoleForm $model */
/* @var yii\rbac\Permission[] $permissions */
/* @var bool $isNewRecord  If create new record */
/* @var yii\rbac\Permission[] $rolePermissions Permissions for current role */

$this->registerCssFile(Url::to(['/css/role.css']), ['position' => View::POS_HEAD]);
$this->registerJsFile(Url::to(['/js/role.js']), [
    'depends' => AppAsset::className(),
    'position' => View::POS_END
]);

$fieldOptions = [
    'template' => "{label}\n{input}\n{hint}\n{error}", 'labelOptions' => ['class' => '']
];
?>

<div class="role-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(['options' => ['class' => '']]); ?>

    <div class="panel panel-default">

        <div class="panel-heading"><b><?= Yii::t('app', 'User Role') ?></b></div>

        <div class="panel-body">

            <div class="form-group">
                <?= $form->field($model, 'name', $fieldOptions)->textInput(['maxlength' => true]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'description', $fieldOptions)->textInput(['maxlength' => true]) ?>
            </div>

            <label for="permission-table"><?= Yii::t('app', 'Permission') ?></label>

            <?= $this->render('_list', [
                'permissions' => $permissions,
                'rolePermissions' => $rolePermissions,
            ]);
            ?>
        </div>

    </div>

    <div class="form-group pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>
