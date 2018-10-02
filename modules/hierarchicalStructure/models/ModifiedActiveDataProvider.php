<?php

namespace modules\hierarchicalStructure\models;


use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\QueryInterface;

/**
 * Class ModifiedActiveDataProvider
 * @package modules\hierarchicalStructure\models
 */
class ModifiedActiveDataProvider extends ActiveDataProvider
{
    /**
     * @return array|\yii\db\ActiveRecord[]
     * @throws InvalidConfigException
     */
    protected function prepareModels()
    {
        if (!$this->query instanceof QueryInterface) {
            throw new InvalidConfigException(
                'The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.'
            );
        }
        $query = $this->wrapQuery($this->query);
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->totalCount = $this->getTotalCount();
            if ($pagination->totalCount === 0) {
                return [];
            }
            $query->limit($pagination->getLimit())->offset($pagination->getOffset());
        }
        if (($sort = $this->getSort()) !== false) {
            $query->addOrderBy($sort->getOrders());
        }

        return $query->all($this->db);
    }

    /**
     * @param $query
     * @return ActiveQuery
     */
    public function wrapQuery($query)
    {
        $newQuery = new ActiveQuery(Records::class);
        $newQuery->from(['originalQuery' => $query]);

        return $newQuery;
    }
}
