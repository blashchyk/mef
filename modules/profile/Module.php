<?php

namespace modules\profile;

use Yii;
use yii\base\Module as BaseModule;
use common\library\permission\ModulePermission;

/**
 * page module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\profiles\controllers';

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
                'name' => 'profile',
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
                                'name' => 'update',
                            ],
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
                                'description' => 'View Profile',
                            ],
                            [
                                'type' => ModulePermission::NODE_TYPE_ACTION,
                                'name' => 'update',
                                'roles' => ['user'],
                                'description' => 'Update Profile'
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
