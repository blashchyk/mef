<?php
namespace common\library\config;

interface ModuleManagerInterface
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * @param string $moduleName
     */
    public function enableModule($moduleName);

    /**
     * @param string $moduleName
     */
    public function disableModule($moduleName);

    /**
     * Perform check is requested module available
     * @param string $moduleName
     * @return bool
     */
    public function haveModule($moduleName);

    /**
     * Return array of available modules of required status with name filter if required
     * @param string $moduleName
     * @return array
     */
    public function availableModules($moduleName, $status);

    /**
     * Return list of all available modules
     * @return array
     */
    public function allAvailable();

    /**
     * Return list of all active modules
     * @return array
     */
    public function allActive();

    /**
     * Return module status enabled/disabled
     * @param string|null $moduleName
     */
    public function moduleStatus($moduleName = null);

}
