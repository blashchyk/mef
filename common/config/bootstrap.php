<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('modules', dirname(dirname(__DIR__)) . '/modules');
Yii::setAlias('generators', dirname(dirname(__DIR__)) . '/generators');
Yii::setAlias('widgets', '@common/widgets');
Yii::setAlias('themes', '@frontend/themes');
Yii::setAlias('image.storage', '@frontend/web/storage/images');
Yii::setAlias('image.default', '/images/default.png');
Yii::setAlias('image.url', '/storage/images');
Yii::setAlias('image.theme', '/themes/images');

// Register to return the same instance rather than creating new one on every get
Yii::$container->set('configManager', new \common\library\config\IniManager(
    new common\library\config\ModuleIterator(Yii::getAlias('@modules')),
    Yii::getAlias(common\library\config\ModuleIteratorInterface::MODULE_CONFIG_PATH),
    common\library\config\ManagerInterface::ALLOW_CREATE | common\library\config\ManagerInterface::ALLOW_EMPTY
));

Yii::$container->set('common\library\config\ModuleManagerInterface', 'configManager');
Yii::$container->set('common\library\config\ManagerInterface', 'configManager');
