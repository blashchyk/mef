<?php

namespace common\library\permission;

use Exception;
use yii\rbac\BaseManager;
use yii\rbac\ManagerInterface;
use yii\rbac\Permission as RbacPermission;

class ModulePermission
{
    const NODE_TYPE_MODULE = 'module';
    const NODE_TYPE_SIDE = 'side';
    const NODE_TYPE_CONTROLLER = 'controller';
    const NODE_TYPE_ACTION = 'action';

    const LEVEL_1 = 1;
    const LEVEL_2 = 2;
    const LEVEL_3 = 3;
    const LEVEL_4 = 4;

    const SEPARATOR = '.';

    protected static $namingRules = [
            self::LEVEL_1 => [
                self::NODE_TYPE_ACTION
            ],
            self::LEVEL_2 => [
                self::NODE_TYPE_MODULE,
                self::NODE_TYPE_ACTION
            ],
            self::LEVEL_3 => [
                self::NODE_TYPE_MODULE,
                self::NODE_TYPE_SIDE,
                self::NODE_TYPE_ACTION
            ],
            self::LEVEL_4 => [
                self::NODE_TYPE_MODULE,
                self::NODE_TYPE_SIDE,
                self::NODE_TYPE_CONTROLLER,
                self::NODE_TYPE_ACTION
            ],
        ];

    /** @var array */
    protected $treeData;
    /** @var BaseManager */
    protected $authManager;

    /**
     * Permission constructor.
     * @param array $treeData
     * @param ManagerInterface $authManager
     */
    public function __construct(array $treeData, ManagerInterface $authManager)
    {
        $this->treeData = $treeData;
        $this->authManager = $authManager;
    }

    public function register()
    {
        foreach ($this->treeData as $root) {
            $this->registerNode($root);
        }
    }

    public function unRegister()
    {
        foreach ($this->treeData as $root) {
            $this->unRegisterNode($root);
        }
    }

    /**
     * @param array $nodesChain
     * @return string
     */
    protected function getPermissionName(array $nodesChain)
    {
        $permissionLevel = count($nodesChain);
        $permissionName = '';
        $elements = $this->getElementsByLevel($permissionLevel);
        $count = 0;
        foreach ($elements as $elementType) {
            $permissionName .= $nodesChain[$elementType];
            $count++;
            if ($count < $permissionLevel) {
                $permissionName .= self::SEPARATOR;
            }
        }
        return $permissionName;
    }

    /**
     * @param array $node
     * @param array $nodesChain
     */
    protected function unRegisterNode(array $node, array $nodesChain = [])
    {
        $nodeHasType = array_key_exists('type', $node);
        if (!$nodeHasType) {
            return;
        }
        $nodesChain[$node['type']] = $node['name'];

        $nodeIsActionType = $node['type'] === self::NODE_TYPE_ACTION;
        if ($nodeIsActionType) {
            $this->removePermission($nodesChain);
        }

        $children = array_key_exists('children', $node) ? (array) $node['children'] : [];
        foreach ($children as $node) {
            $this->unRegisterNode($node, $nodesChain);
        }
    }

    /**
     * @param array $node
     * @param array $nodesChain
     */
    protected function registerNode(array $node, array $nodesChain = [])
    {
        $nodeHasType = array_key_exists('type', $node);
        if (!$nodeHasType) {
            return;
        }
        $nodesChain[$node['type']] = $node['name'];

        $nodeIsActionType = $node['type'] === self::NODE_TYPE_ACTION;
        if ($nodeIsActionType) {
            $this->createPermission($node, $nodesChain);
        }

        $children = array_key_exists('children', $node) ? (array) $node['children'] : [];
        foreach ($children as $node) {
            $this->registerNode($node, $nodesChain);
        }
    }

    /**
     * @param array $node
     * @param array $nodesChain
     */
    protected function createPermission(array $node, array $nodesChain)
    {
        $permissionName = $this->getPermissionName($nodesChain);
        $permission = $this->authManager->getPermission($permissionName);
        if ($permission === null) {
            $permission = $this->authManager->createPermission($permissionName);
            $permission->description = !empty($node['description']) ? $node['description'] : null;
        }
        $this->authManager->add($permission);

        $parentPermission = $this->getParentPermission($nodesChain);
        if ($parentPermission !== null) {
            $this->authManager->addChild($parentPermission, $permission);
        }

        $permissionHasAttachedRoles = array_key_exists('roles', $node) && is_array($node['roles']);
        if ($permissionHasAttachedRoles) {
            $this->addPermissionForRoles($permission, $node['roles']);
        }
    }

    /**
     * @param array $nodesChain
     */
    protected function removePermission(array $nodesChain)
    {
        $permissionName = $this->getPermissionName($nodesChain);
        $permission = $this->authManager->getPermission($permissionName);
        if ($permission !== null) {
            $this->authManager->remove($permission);
        }
    }

    /**
     * @param RbacPermission $permission
     * @param array $roles
     */
    protected function addPermissionForRoles(RbacPermission $permission, array $roles)
    {
        foreach ($roles as $role) {
            $role = $this->authManager->getRole($role);
            if ($role !== null) {
                $this->authManager->addChild($role, $permission);
            }
        }
    }

    /**
     * @param array $nodesChain
     * @return bool
     */
    protected function canHaveParent(array $nodesChain)
    {
        return count($nodesChain) > self::LEVEL_1;
    }

    /**
     * @param array $nodesChain
     * @return null|RbacPermission
     */
    protected function getParentPermission(array $nodesChain)
    {
        if (!$this->canHaveParent($nodesChain)) {
            return null;
        }
        $parentNodesChain = $this->getLevelUpChain($nodesChain);
        $permissionName = $this->getPermissionName($parentNodesChain);
        $permission = $this->authManager->getPermission($permissionName);
        if ($permission === null) {
            return $this->getParentPermission($parentNodesChain);
        }
        return $permission;
    }

    /**
     * @param int $level
     * @return array
     * @throws Exception
     */
    protected function getElementsByLevel($level)
    {
        $namingRules = self::$namingRules;
        $levelExists = array_key_exists($level, $namingRules);
        if ($levelExists) {
            return $namingRules[$level];
        }
        throw new Exception('Incorrect permission level.');
    }

    /**
     * @param array $nodesChain
     * @return array
     */
    protected function getLevelUpChain(array $nodesChain)
    {
        $currentLevel = count($nodesChain);
        $upLevel = $currentLevel - 1;
        return array_intersect_key($nodesChain, array_flip($this->getElementsByLevel($upLevel)));
    }
}