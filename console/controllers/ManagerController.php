<?php
namespace console\controllers;

use common\library\config\ModuleManagerInterface;
use common\library\permission\ModulePermission;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class ManagerController extends Controller
{
    const STRUCTURE_METHOD_NAME = 'getPermissionStructure';

    /** @var ModuleManagerInterface  */
    public $configManager;

    /**
     * PermissionController constructor.
     * @param string $id
     * @param \yii\base\Module $module
     * @param ModuleManagerInterface $configManager
     * @param array $config
     */
    public function __construct($id, $module, ModuleManagerInterface $configManager, $config = [])
    {
        $this->configManager = $configManager;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $moduleName
     */
    public function actionRegister($moduleName)
    {
        try {
            $modules = $this->configManager->availableModules($moduleName, ModuleManagerInterface::STATUS_DISABLED);
            if (count($modules) === 0) {
                $this->stdout("All specified modules already enabled\n", Console::FG_YELLOW);
                return;
            }
            foreach ($modules as $module) {
                $this->configManager->enableModule($module);
                $this->stdout("Module '$module' enabled.\n", Console::BOLD);
                $permissionStructure = $this->getPermissionStructure($module);
                if ($permissionStructure === null) {
                    continue;
                }
                $auth = Yii::$app->authManager;
                $permission = new ModulePermission($permissionStructure, $auth);
                $permission->register();
                $this->stdout("Permissions successfully added.\n", Console::BOLD);
            }
        } catch (\Exception $ex) {
            $this->stdout(Console::renderColoredString('%RError: %n%_' . $ex->getMessage() . "\n"));
        }
    }

    /**
     * @param $moduleName
     */
    public function actionUnRegister($moduleName)
    {
        try {
            $modules = $this->configManager->availableModules($moduleName, ModuleManagerInterface::STATUS_ENABLED);
            if (count($modules) === 0) {
                $this->stdout("All specified modules already disabled\n", Console::FG_YELLOW);
                return;
            }
            foreach ($modules as $module) {
                $this->configManager->disableModule($module);
                $this->stdout("Module '$module' disabled.\n", Console::BOLD);
                $permissionStructure = $this->getPermissionStructure($module);
                if ($permissionStructure === null) {
                    continue;
                }
                $auth = Yii::$app->authManager;
                $permission = new ModulePermission($permissionStructure, $auth);
                $permission->unRegister();
                $this->stdout("Permissions successfully removed.\n", Console::BOLD);
            }
        } catch (\Exception $ex) {
            $this->stdout(Console::renderColoredString('%RError: %n%_' . $ex->getMessage() . "\n"));
        }
    }

    /**
     * @param string $moduleName
     */
    public function actionStatus($moduleName = null)
    {
        try {
            if ($moduleName == 'all') {
                $moduleName = null;
            }
            $modules = $this->configManager->moduleStatus($moduleName);
            if (count($modules) === 0) {
                $this->stdout("There is no available modules\n", Console::FG_YELLOW);
                return;
            }
            foreach ($modules as $module => $status) {
                $name = Console::ansiFormat("'{$module}'", [Console::FG_CYAN]);
                $this->stdout("Module {$name}: " . Console::ansiFormat($status, [Console::FG_YELLOW]) . "\n");
            }
        } catch (\Exception $ex) {
            $this->stdout(Console::renderColoredString('%RError: %n%_' . $ex->getMessage() . "\n"));
        }
    }

    /**
     * @param string $moduleName
     * @return string
     */
    private function getClassName($moduleName)
    {
        return 'modules\\' . $moduleName . '\\Module';
    }

    /**
     * @param $moduleName
     * @return null|array
     */
    private function getPermissionStructure($moduleName)
    {
        $className = $this->getClassName($moduleName);
        $classExist = class_exists($className);
        if (!$classExist) {
            $this->stdout('Class ' . $className . " does not exist.\n", Console::BOLD);
            return null;
        }

        $structureExists = method_exists($className, self::STRUCTURE_METHOD_NAME);
        if (!$structureExists) {
            $this->stdout("The permission structure is not specified in the module.\n", Console::BOLD);
            return null;
        }

        return call_user_func([$className, self::STRUCTURE_METHOD_NAME]);
    }

}
