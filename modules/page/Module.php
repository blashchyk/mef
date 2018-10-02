<?php

namespace modules\page;

use common\library\permission\ModulePermission;
use Yii;
use yii\base\Module as BaseModule;

/**
 * page module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\page\controllers';

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
     *
     * Accessible formats of permission tree:
     *
     * module.action
     * module.side.action
     * module.side.controller.action
     *
     * Parental permission must be specified first.
     *
     * @return array
     */
    public static function getPermissionStructure()
    {
        return [
            [
                'type' => ModulePermission::NODE_TYPE_MODULE,
                'name' => 'page',
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
                                'type' => ModulePermission::NODE_TYPE_CONTROLLER,
                                'name' => 'default',
                                'children' => [
                                    [
                                        'type' => ModulePermission::NODE_TYPE_ACTION,
                                        'name' => 'index',
                                    ],
                                    [
                                        'type' => ModulePermission::NODE_TYPE_ACTION,
                                        'name' => 'update',
                                    ],
                                    [
                                        'type' => ModulePermission::NODE_TYPE_ACTION,
                                        'name' => 'create',
                                    ],
                                    [
                                        'type' => ModulePermission::NODE_TYPE_ACTION,
                                        'name' => 'delete',
                                    ],
                                ]
                            ],
                            [
                                'type' => ModulePermission::NODE_TYPE_CONTROLLER,
                                'name' => 'category',
                                'children' => [
                                    [
                                        'type' => ModulePermission::NODE_TYPE_ACTION,
                                        'name' => 'index',
                                    ],
                                    [
                                        'type' => ModulePermission::NODE_TYPE_ACTION,
                                        'name' => 'update',
                                    ],
                                    [
                                        'type' => ModulePermission::NODE_TYPE_ACTION,
                                        'name' => 'create',
                                    ],
                                    [
                                        'type' => ModulePermission::NODE_TYPE_ACTION,
                                        'name' => 'delete',
                                    ],
                                ]
                            ]
                        ],
                    ],
                    [
                        'type' => ModulePermission::NODE_TYPE_SIDE,
                        'name' => 'frontend',
                        'children' => [
                            [
                                'type' => ModulePermission::NODE_TYPE_ACTION,
                                'name' => 'index',
                                'roles' => ['user'],
                                'description' => 'View Pages'
                            ],
                            [
                                'type' => ModulePermission::NODE_TYPE_ACTION,
                                'name' => 'update',
                            ],
                            [
                                'type' => ModulePermission::NODE_TYPE_ACTION,
                                'name' => 'create',
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
