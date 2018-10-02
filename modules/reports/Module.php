<?php

namespace modules\reports;

use Yii;
use yii\base\Module as BaseModule;
use common\library\permission\ModulePermission;

/**
 * module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\reports\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
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
                'name' => 'reports',
                'children' => [
                    [
                        'type' => ModulePermission::NODE_TYPE_ACTION,
                        'name' => 'access',
                    ],
                    [
                        'type' => ModulePermission::NODE_TYPE_SIDE,
                        'name' => 'backend',
                        'children' => [
                            [
                                'type' => ModulePermission::NODE_TYPE_ACTION,
                                'name' => 'index',
                            ],
                            [
                                'type' => ModulePermission::NODE_TYPE_ACTION,
                                'name' => 'create',
                            ],
                            [
                                'type' => ModulePermission::NODE_TYPE_ACTION,
                                'name' => 'update',
                            ],
                            [
                                'type' => ModulePermission::NODE_TYPE_ACTION,
                                'name' => 'delete',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
