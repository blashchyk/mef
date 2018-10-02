<?php

use yii\helpers\Html;

/* @var yii\web\View $this  */
/* @var yii\rbac\Permission[] $permissions */
/* @var bool $isNewRecord If create new record */
/* @var common\models\RoleForm $model */
/* @var yii\rbac\Permission[] $rolePermissions Permissions for current role */

$this->title = Yii::t('app', 'Add Role');
?>
<div class="role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'permissions' => $permissions,
        'isNewRecord' => true,
        'rolePermissions' => $rolePermissions,
    ]) ?>

</div>
