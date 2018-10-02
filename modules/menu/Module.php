<?php

namespace modules\menu;

use Yii;
use yii\base\Module as BaseModule;
use common\library\permission\ModulePermission;

/**
 * menu module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\menu\controllers';

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
                'name' => 'menu',
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
