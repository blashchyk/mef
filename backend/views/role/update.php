<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var common\models\RoleForm $model */
/* @var yii\rbac\Permission[] $permissions */
/* @var bool $isNewRecord  If create new record */
/* @var yii\rbac\Permission[] $rolePermissions Permissions for current role */

$this->title = Yii::t('app', 'Edit Role') . ': ' . $model->name;
?>
<div class="role-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'permissions' => $permissions,
        'isNewRecord' => false,
        'rolePermissions' => $rolePermissions,
    ]) ?>

</div>
