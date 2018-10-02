<?php

/* @var $manager common\library\config\ModuleManagerInterface */
$manager = Yii::$container->get('configManager');

$modules = [];
foreach ($manager->allActive() as $module) {
    $modules[$module] = [
        'class' => 'modules\\' . $module . '\Module',
        'controllerNamespace' => 'modules\\' . $module . '\controllers\backend',
        'viewPath' => '@modules/' . $module . '/views/backend',
    ];
}

return $modules;
