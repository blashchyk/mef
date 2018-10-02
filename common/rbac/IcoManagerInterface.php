<?php

namespace common\rbac;

use common\models\User;
use yii\rbac\Item;
use yii\rbac\ManagerInterface;

interface IcoManagerInterface extends ManagerInterface
{
    /**
     * @param string $roleName
     * @param User $user
     * @return bool
     */
    public function updateRoleByUser($roleName, User $user);

    /**
     * @param \yii\rbac\Item $role
     * @param \yii\rbac\Item[] $arrayAdd Add Array of permissions for add to $role
     * @return bool
     */
    public function addPermissions(Item $role, array $arrayAdd);

    /**
     * @param string $oldRole
     * @param \yii\rbac\Item $role
     * @param \yii\rbac\Item[] $toAdd
     * @return bool
     */
    public function updatePermissions($oldRole, Item $role, array $toAdd);

    /**
     * @param string $nameRole
     * @return bool
     */
    public function deleteRole($nameRole);

    /**
     * Get list main Permissions
     * @return \yii\rbac\Item[]
     */
    public function getListRootPermissions();

    /**
     * Building a Permission Tree
     * @return array
     */
    public function getPermissionsChildrenTree();
}
