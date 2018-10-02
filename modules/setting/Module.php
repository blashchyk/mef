<?php

namespace modules\setting;

use Yii;
use yii\base\Module as BaseModule;
use common\library\permission\ModulePermission;

/**
 * setting module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\setting\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $properties = array_merge_recursive(
            require(__DIR__ . '/config/params.php'),
            require(__DIR__ . '/../module/config/params.php'),
            require(__DIR__ . '/../country/config/params.php')
        );
        Yii::configure($this, $properties);
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
                'name' => 'setting',
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
