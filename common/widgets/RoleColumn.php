<?php

namespace common\widgets;

use common\models\User;
use yii\grid\DataColumn;
use yii\helpers\Html;
use Yii;

class RoleColumn extends DataColumn
{
    public $defaultRole = User::DEFAULT_ROLE;

    /**\
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return string
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
        $label = $value ? $this->getRoleLabel($value) : $value;
        $html = Html::tag('span', Html::encode($label));
        return $value === null ? $this->grid->emptyCell : $html;
    }

    /**
     * @param $roleName
     * @return string
     */
    private function getRoleLabel($roleName)
    {
        if ($role = Yii::$app->authManager->getRole($roleName)) {
            return $role->description ?: $role->name;
        } else {
            return $roleName;
        }
    }
}