<?php

namespace common\models;

use yii\rbac\Role;

class RoleModel extends AbstractModel
{
    /**
     * @var int the type of the item. This should be either [[TYPE_ROLE]] or [[TYPE_PERMISSION]].
     */
    public $type = Role::TYPE_ROLE;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_item}}';
    }
}