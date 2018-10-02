<?php

namespace common\rbac;

use common\models\User;
use Yii;
use yii\rbac\DbManager;
use yii\rbac\Item;
use yii\rbac\Permission;

class DbIcoManager extends DbManager implements IcoManagerInterface
{
    /**
     * @inheritdoc
     */
    public function updateRoleByUser($roleName, User $user)
    {
        try {
            $role = $this->getRole($roleName);

            if (!empty($role)) {
                $this->revokeAll($user->id);
                $this->assign($role, $user->id);
            } else {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Yii::error('Error update role by user | ' . __METHOD__ . ' | ' . __LINE__);
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function addPermissions(Item $role, array $arrayAdd)
    {
        $result = true;
        foreach ($arrayAdd as $key => $val) {
            if (!$this->addChild($role, $this->getPermission($key))) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function updatePermissions($oldRole, Item $role, array $toAdd)
    {
        $result = $this->update($oldRole, $role);

        if (!$this->removeChildren($role)) {
            $result = false;
        }

        foreach ($toAdd as $val) {
            if (!$this->addChild($role, $this->getPermission($val))) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function deleteRole($nameRole)
    {
        $role = $this->getRole($nameRole);
        if ($role) {
            if (!$this->removeChildren($role) || !$this->remove($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getListRootPermissions()
    {
        $permissions = $this->getPermissions();

        $rootPermissions = array_filter($permissions, function ($permission) {
            if (strpos($permission->name, '.') === false) {
                return $permission;
            }
        });

        return $rootPermissions;
    }

    /**
     * @inheritdoc
     */
    public function getPermissionsChildrenTree()
    {
        $rootPermissions = $this->getListRootPermissions();

        $permissions = $this->getChildrenPermission($rootPermissions);

        return $permissions;
    }

    /**
     * For Building a Permission Tree
     *
     * @param \yii\rbac\Permission[] $permissions
     * @return array
     */
    private function getChildrenPermission(array $permissions)
    {
        $tree = [];
        foreach ($permissions as $permission) {
            $tree[$permission->name] = $this->createChildTree($permission);
            $childrenTree = $this->getChildren($permission->name);
            if (count($childrenTree) > 0) {
                $tree[$permission->name]['children'] = $this->getChildrenPermission($childrenTree);
            }
        }

        return $tree;
    }

    /**
     * For Building a Permission Tree
     *
     * @param \yii\rbac\Permission $data
     * @return array
     */
    private function createChildTree(Permission $data)
    {
        $tree = [
            'name' => $data->name,
            'description' => $data->description,
            'children' => null
        ];

        return $tree;
    }
}
