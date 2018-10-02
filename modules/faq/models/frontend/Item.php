<?php

namespace modules\faq\models\frontend;

use modules\faq\models\Item as BaseItem;
use yii\db\ActiveRecord;

class Item extends BaseItem
{
    private $_i18nAttributes = [
        'name',
        'description',
    ];

    public function afterFind()
    {
        foreach ($this->_i18nAttributes as $attribute) {
            $value = $this->getAttributeValue($attribute);
            $cleanValue = trim(strip_tags($value));
            if (!empty($cleanValue)) {
                $this->setAttribute($attribute, $value);
            }
        }

        parent::afterFind();
    }

    /**
     * Gets data with visible items
     *
     * @return ActiveRecord
     */
    public function getVisibleItems()
    {
        return self::find()->where(['visible' => Item::VISIBLE_YES])->all();
    }
}
