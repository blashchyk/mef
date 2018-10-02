<?php

namespace modules\order;

use Yii;
use yii\base\Module as BaseModule;
use common\library\permission\ModulePermission;

/**
 * order module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\order\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        Yii::configure($this, require(__DIR__ . '/config/params.php'));
    }

    public static function getPermissionStructure()
    {
        return [
            [
                'type' => ModulePermission::NODE_TYPE_MODULE,
                'name' => 'order',
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
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

}
