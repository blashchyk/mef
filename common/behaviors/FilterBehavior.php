<?php

namespace common\behaviors;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\base\Behavior;
use modules\catalog\models\Filter;
use modules\catalog\models\Field;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

class FilterBehavior extends Behavior
{
    public $defaultFilters = [];
    public $joinWith = [];
    public $linkList = [];

    public $additionFieldClass = null;

    public static $filters = null;
    public $filterFields = [];
    public $filterValues = [];

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_INIT => 'init',
        ];
    }

    /**
     * @return null
     */
    public function init()
    {
        parent::init();
        if (empty(self::$filters)) {
            self::$filters = Filter::find()->where(['visible' => Filter::VISIBLE_YES])->orderBy('sorting')->all();
            $this->setPriceLimits();
        }
    }

    /**
     * @return null
     */
    public function getFilters()
    {
        return self::$filters;
    }

    /**
     * @return null
     */
    public function getFilterInfo($filter)
    {
        $searchModel = $this->owner;
        $searchField = $filter->field;
        $searchLabel = $filter->field;
        if (!empty($this->additionFieldClass) && !$searchModel->hasAttribute($filter->field)) {
            $fieldModel = Field::findOne((int) $filter->field);
            $searchModel = new $this->additionFieldClass;
            $searchField = '[' . $filter->field . ']value';
            $searchLabel = $fieldModel->name;
            $additionEntityClass = StringHelper::basename($this->additionFieldClass);
            $params = Yii::$app->request->queryParams;
            if (!empty($params[$additionEntityClass]) && !empty($params[$additionEntityClass][$filter->field])) {
                $searchModel->value = $params[$additionEntityClass][$filter->field]['value'];
            }
        } else {
            $searchLabel = $searchModel->attributeLabels()[$filter->field];
        }

        return (object) [
            'model' => $searchModel,
            'field' => $searchField,
            'label' => $searchLabel,
        ];
    }

    /**
     * @return null
     */
    public function getDefaultFilters()
    {
        return $this->defaultFilters;
    }

    /**
     * @return array
     */
    public static function getStringFilters()
    {
        $rangeFilters = [];
        foreach (FilterBehavior::$filters as $filter) {
            if ($filter->type == Filter::TYPE_RANGE) {
                $rangeFilters[] = $filter->field . 'Range';
            } elseif ($filter->type != Filter::TYPE_MULTIPLE) {
                $rangeFilters[] = $filter->field;
            }
        }
        return $rangeFilters;
    }

    /**
     * @return array
     */
    public static function getIntegerFilters()
    {
        $rangeFilters = [];
        foreach (FilterBehavior::$filters as $filter) {
            if ($filter->type == Filter::TYPE_MULTIPLE) {
                $rangeFilters[] = $filter->field;
            }
        }
        return $rangeFilters;
    }

    /**
     * Creates data provider with visible items
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function getVisibleItemList($params = [], $pageSize = 15)
    {
        $dataProvider = $this->owner->getVisibleItems($params, $pageSize);
        $this->setPriceLimits(true);

        if (!empty($this->additionFieldClass)) {
            $additionEntityClass = StringHelper::basename($this->additionFieldClass);
            if (!empty($params[$additionEntityClass]) && count($params[$additionEntityClass]) > 0) {
                foreach ($params[$additionEntityClass] as $key => $fields) {
                    $joinAlias = 'at' . $key;
                    if (!empty($fields['value'])) {
                        $dataProvider->query->joinWith([lcfirst($additionEntityClass) . 's ' . $joinAlias]);
                        $dataProvider->query->andFilterWhere([$joinAlias . '.field_id' => $key]);
                        if (count($fields['value']) == 1) {
                            $dataProvider->query->andFilterWhere(['like', $joinAlias . '.value', $fields['value']]);
                        } else {
                            $dataProvider->query->andFilterWhere([$joinAlias . '.value' => $fields['value']]);
                        }
                    }
                }
            }
        }

        foreach (self::$filters as $filter) {
            if ($filter->type == Filter::TYPE_RANGE) {
                $dataProvider->query->andFilterWhere(['>=', 't.' . $filter->field, $this->getRangeValue($filter->field, 0)]);
                $dataProvider->query->andFilterWhere(['<=', 't.' . $filter->field, $this->getRangeValue($filter->field, 1)]);
            } else {
                if (empty($this->linkList[$filter->field])) {
                    $dataProvider->query->andFilterWhere(['t.' . $filter->field => $this->owner->getAttributeValue($filter->field)]);
                }
            }
        }

        return $dataProvider;
    }

    /**
     * @param ActiveQuery $query
     * @return void
     */
    private function setPriceLimits($getRanges = false)
    {
        $this->filterFields = [];
        foreach (self::$filters as $filter) {
            if ($filter->type == Filter::TYPE_RANGE) {
                $fieldRange = $filter->field . 'Range';
                $this->filterFields[] = $fieldRange;
                $this->filterFields[] = $filter->field . 'RangeMin';
                $this->filterFields[] = $filter->field . 'RangeMax';
                if (!isset($this->filterValues[$fieldRange])) {
                    $this->filterValues[$fieldRange] = null;
                }
                $this->filterValues[$filter->field . 'RangeMin'] = $getRanges ? $this->getRangeMin($filter->field) : null;
                $this->filterValues[$filter->field . 'RangeMax'] = $getRanges ? $this->getRangeMax($filter->field) : null;
            }
        }
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getValueListSelect($field)
    {
        $captionField = !empty($this->linkList[$field]) ? $this->linkList[$field] : 't.' . $field;

        $query = $this->owner->find()->alias('t')->select([$captionField, 't.' . $field]);
        $query = $this->addDefaultFilters($query);

        return $query->indexBy($field)->column();
    }

    /**
     * @param $field
     * @param $query
     * @return array
     */
    public function getValueListHelper($field, $queryString)
    {
        $query = $this->owner->find()->alias('t');

        if ($this->owner->hasAttribute($field)) {
            $indexBy = $field;
            $field = 't.' . $field;
            $query->select([$field, $field])
                ->where(['like', $field, $queryString])
                ->orderBy($field);
        } else {
            $additionEntityClass = StringHelper::basename($this->additionFieldClass);
            $fieldId = preg_replace('/[^0-9]/', '', $field);
            $indexBy = 'value';
            $field = 'at.value';
            $query->select([$field, $field])
                ->joinWith([lcfirst($additionEntityClass) . 's at'])
                ->where(['at.field_id' => $fieldId])
                ->andWhere(['like', $field, $queryString]);
        }

        $query = $this->addDefaultFilters($query);

        $fields = $query->indexBy($indexBy)
            ->column();

        $values = [];
        foreach ($fields as $field) {
            $values[] = ['value' => $field];
        }
        return $values;
    }

    /**
     * @param $field
     * @return float
     */
    public function getRangeMin($field)
    {
        $query = $this->owner->find();
        $query = $this->addDefaultFilters($query);

        /*if (!$this->owner->hasAttribute($field)) {
            $field = 'at.value';
            $additionEntityClass = StringHelper::basename($this->additionFieldClass);
            $fieldId = preg_replace("/[^0-9]/", '', $field);
            $query->joinWith([lcfirst($additionEntityClass) . 's at'])
                ->where(['at.field_id' => $fieldId]);
        }*/

        return (float) $query->min($field);
    }

    /**
     * @param $field
     * @return float
     */
    public function getRangeMax($field)
    {
        $query = $this->owner->find();
        $query = $this->addDefaultFilters($query);

        /*if (!$this->owner->hasAttribute($field)) {
            $field = 'at.value';
            $additionEntityClass = StringHelper::basename($this->additionFieldClass);
            $fieldId = preg_replace("/[^0-9]/", '', $field);
            $query->joinWith([lcfirst($additionEntityClass) . 's at'])
                ->where(['at.field_id' => $fieldId]);
        }*/

        return (float) $query->max($field);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function addDefaultFilters($query)
    {
        foreach ($this->defaultFilters as $key => $filter) {
            $query->andFilterWhere([$key => $this->owner->getAttribute($filter)]);
        }
        $query->joinWith($this->joinWith);
        return $query;
    }

    /**
     * @param $field
     * @param $index
     * @return float|null
     */
    public function getRangeValue($field, $index)
    {
        $range = $this->filterValues[$field . 'Range'];

        if (!empty($range)) {
            if (strpos($range, ',')) {
                $filters =  explode(',', $range);
                if (!empty($filters[$index])) {
                    return (float) $filters[$index];
                }
            }
        }
        return null;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws \yii\base\UnknownPropertyException
     */
    public function __get($key)
    {
        if (in_array($key, $this->filterFields)) {
            return $this->filterValues[$key];
        }
        return $this->owner->__get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @throws \yii\base\UnknownPropertyException
     */
    public function __set($key, $value)
    {
        if (in_array($key, $this->filterFields)) {
            $this->filterValues[$key] = $value;
            return;
        }
        return $this->owner->__set($key, $value);
    }

    /**
     * @return bool
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return true;
    }

    /**
     * @return bool
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return true;
    }
}
