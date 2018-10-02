<?php

namespace modules\hierarchicalStructure\models;

use Yii;
use yii\base\Model;

/**
 * @property integer $type
 * @property string $list
 * @property boolean $permission
 */
class Permission extends Model
{

    const USER = 1;
    const GROUP = 2;

    /**
     * list of type
     *
     * @return array
     */
    public static function getTypes()
    {
        return [
            '0' => 'Select...',
            self::USER => Yii::t('yii', 'User'),
            self::GROUP => Yii::t('yii', 'Group'),
        ];
    }

    public $type;
    public $list;

    public $permission;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'list'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type' => Yii::t('app', 'Type'),
            'list' => Yii::t('app', 'List'),
            'permission' => Yii::t('app', 'Permission'),
        ];
    }
}
