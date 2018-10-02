<?php

namespace common\components\Column;

use \kartik\grid\DataColumn;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class SetColumn extends DataColumn
{
    /**
     * @var callable
     */
    public $name = null;

    /**
     * @var array
     */
    public $filter = null;

    /**
     * Array of classes for different values
     *
     * ```
     * [
     *     User::STATUS_ACTIVE => 'success',
     *     User::STATUS_WAIT => 'warning',
     *     User::STATUS_BLOCKED => 'default',
     * ]
     * ```
     * @var array
     */
    public $cssClasses = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        //$this->hAlign = GridView::ALIGN_CENTER;
        //$this->vAlign = GridView::ALIGN_TOP;

        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
        $name = $this->getLabelName($model, $key, $index, $value);
        $class = ArrayHelper::getValue($this->cssClasses, $value, 'default');
        $html = Html::tag('span', Html::encode($name), ['class' => 'label label-' . $class]);
        return $value === null ? $this->grid->emptyCell : $html;
    }

    /**
     * @param mixed $model
     * @param mixed $key
     * @param integer $index
     * @param mixed $value
     * @return string
     */
    private function getLabelName($model, $key, $index, $value)
    {
        if (!empty($this->name)) {
            if (is_string($this->name)) {
                $name = ArrayHelper::getValue($model, $this->name);
            } else {
                $name = call_user_func($this->name, $model, $key, $index, $this);
            }
        } elseif (!empty($this->filter) && !empty($this->filter[$value])) {
            $name = $this->filter[$value];
        } else {
            $name = null;
        }
        return $name === null ? $value : $name;
    }
}
