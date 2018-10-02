<?php

/* @var $manager common\library\config\ModuleManagerInterface */
$manager = Yii::$container->get('configManager');

$modules = [];
// Console app is ok to ignore module exceptions at bootstrap
try {
    foreach ($manager->allActive() as $module) {
        $modules[$module] = [
            'class' => 'modules\\' . $module . '\Module',
            'controllerNamespace' => 'modules\\' . $module . '\controllers\console',
        ];
    }
} catch (common\library\exceptions\FileWriteException $ex) {
    // There is an file error. Most likely it will be resolved in request
    // so it's totally ok to ignore this kind of errors
} catch (common\library\exceptions\ParseIniFileException $ex) {
    // This means that file doesn't contain valid ini settings
    // It is appropriate to skip this error at bootstrap, to get shiny message later
}

return $modules;
