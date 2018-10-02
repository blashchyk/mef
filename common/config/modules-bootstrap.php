<?php

/* @var $manager common\library\config\ModuleManagerInterface */
$manager = Yii::$container->get('configManager');

$modulesBootstrap = ['modules\\i18n\\Bootstrap'];
// catch some none lethal exceptions to prevent default 500 in web
try {
    foreach ($manager->allActive() as $module) {
        $className = 'modules\\' . $module . '\Bootstrap';
        if (!class_exists($className)) {
            continue;
        }

        $modulesBootstrap[$module] = [
            'class' => $className,
        ];
    }
} catch (common\library\exceptions\FileWriteException $ex) {
    // There is an file error. Most likely it will be resolved in request
    // so it's totally ok to ignore this kind of errors
} catch (common\library\exceptions\ParseIniFileException $ex) {
    // This means that file doesn't contain valid ini settings
    // It is appropriate to skip this error at bootstrap, to get shiny message later
}

return $modulesBootstrap;
