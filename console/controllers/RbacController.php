<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;
use yii\helpers\ArrayHelper;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $editor = $auth->createRole('editor');
        $auth->add($editor);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $index = $auth->createPermission('index');
        $index->description = 'Index';
        $auth->add($index);

        $create = $auth->createPermission('create');
        $create->description = 'Create';
        $auth->add($create);

        $update = $auth->createPermission('update');
        $update->description = 'Update';
        $auth->add($update);

        $delete = $auth->createPermission('delete');
        $delete->description = 'Delete';
        $auth->add($delete);

        $access = $auth->createPermission('access');
        $access->description = 'Access';
        $auth->add($access);

        $roleAccess = $auth->createPermission('role.access');
        $roleAccess->description = 'Role Access';
        $auth->add($roleAccess);

        $roleIndex = $auth->createPermission('role.index');
        $roleIndex->description = 'Role Index';
        $auth->add($roleIndex);

        $roleUpdate = $auth->createPermission('role.update');
        $roleUpdate->description = 'Role Update';
        $auth->add($roleUpdate);

        $roleCreate = $auth->createPermission('role.create');
        $roleCreate->description = 'Role Create';
        $auth->add($roleCreate);

        $roleDelete = $auth->createPermission('role.delete');
        $roleDelete->description = 'Role Delete';
        $auth->add($roleDelete);

        $auth->addChild($access, $roleAccess);
        $auth->addChild($roleAccess, $roleIndex);
        $auth->addChild($roleAccess, $roleUpdate);
        $auth->addChild($roleAccess, $roleCreate);
        $auth->addChild($roleAccess, $roleDelete);

        $userAccess = $auth->createPermission('user.access');
        $userAccess->description = 'User Access';
        $auth->add($userAccess);

        $userIndex = $auth->createPermission('user.index');
        $userIndex->description = 'User Index';
        $auth->add($userIndex);

        $userUpdate = $auth->createPermission('user.update');
        $userUpdate->description = 'User Update';
        $auth->add($userUpdate);

        $userCreate = $auth->createPermission('user.create');
        $userCreate->description = 'User Create';
        $auth->add($userCreate);

        $userDelete = $auth->createPermission('user.delete');
        $userDelete->description = 'User Delete';
        $auth->add($userDelete);

        $auth->addChild($access, $userAccess);
        $auth->addChild($userAccess, $userIndex);
        $auth->addChild($userAccess, $userUpdate);
        $auth->addChild($userAccess, $userCreate);
        $auth->addChild($userAccess, $userDelete);

//        $auth->addChild($user, $index);

        $auth->addChild($admin, $index);
        $auth->addChild($admin, $create);
        $auth->addChild($admin, $update);
        $auth->addChild($admin, $delete);
        $auth->addChild($admin, $access);

        $auth->assign($admin, User::DEFAULT_ADMIN_ID);

        /**
         * Assign role by users. Default role=editor
         */
        $role_user = $auth->getRole('editor');

        $users = User::find()
            ->select('id')
            ->where('id != ' . User::DEFAULT_ADMIN_ID)
            ->asArray()
            ->all();
        $ids = ArrayHelper::getColumn($users, 'id');
        foreach ($ids as $id) {
            $auth->assign($role_user, $id);
        }
    }
}