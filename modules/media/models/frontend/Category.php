<?php

namespace modules\media\models\frontend;

use yii\db\ActiveRecord;
use modules\media\models\Category as BaseCategory;

class Category extends BaseCategory
{
    /**
     * Gets data with visible items
     *
     * @return ActiveRecord
     */
    public function getVisibleItems()
    {
        return self::find()->where(['visible' => Category::VISIBLE_YES])->all();
    }
}
