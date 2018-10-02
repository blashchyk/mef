<?php

namespace common\behaviors;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class SortingBehavior extends Behavior
{
    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
        ];
    }

    /**
     * @param $event
     */
    public function beforeInsert($event)
    {
        $max = (new Query())
            ->from($this->owner->tableName())
            ->max('sorting');
        $this->owner->sorting = $max + 1;
    }

    /**
     * @param string $sortedIds
     * @return boolean
     */
    public function updateSorting($sortedIds, $reverse = false)
    {
        $sortedIds = preg_replace('![^\d,]*!', '', $sortedIds);

        $idList = explode(',', $sortedIds);

        if ($reverse) {
            $idList = array_reverse($idList);
        }
        
        $models = $this->owner->find()->where('id IN (' . $sortedIds . ')')->all();
        $models = ArrayHelper::index($models, 'id');
        $sortingList = ArrayHelper::getColumn($models, 'sorting');
        sort($sortingList);

        for ($i = 0; $i < count($idList); $i++) {
            $models[$idList[$i]]->sorting = $sortingList[$i];
            $models[$idList[$i]]->save();
        }

        return true;
    }
}
