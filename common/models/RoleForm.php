<?php

namespace common\models;

use Yii;
use yii\base\Model;

class RoleForm extends Model
{
    const PATTERN = '/^[a-zA-Z0-9_-]+$/';

    const IS_NEW_SCENARIO = 'isNew';

    public $name;
    public $description;
    public $isNew;

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 64],
            ['name', 'match', 'pattern' => self::PATTERN],
            [['description'], 'string'],
            ['name', 'validateRoleExist', 'on' => self::IS_NEW_SCENARIO],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Role Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * Validate exist Role.
     *
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateRoleExist($attribute, $params)
    {
        $hasError = false;
        if (Yii::$app->authManager->getRole($this->{$attribute})) {
            $hasError = true;
        }
        if ($hasError === true) {
            $this->addError($attribute, Yii::t('app', 'A role with this name already exists') . ':' . $this->{$attribute});
        }
    }
}
