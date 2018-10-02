<?php

namespace modules\module;

use Yii;
use yii\base\Module as BaseModule;
use common\library\permission\ModulePermission;

/**
 * module module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\module\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::configure($this, require(__DIR__ . '/config/params.php'));
    }

    /**
     * Permission structure
     * @return array
     */
    public static function getPermissionStructure()
    {
        return [
            [
                'type' => ModulePermission::NODE_TYPE_MODULE,
                'name' => 'module',
                'children' => [
                    [
                        'type' => ModulePermission::NODE_TYPE_ACTION,
                        'name' => 'access',
                    ],
                ],
            ],
        ];
    }

}
