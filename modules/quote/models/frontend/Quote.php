<?php

namespace modules\quote\models\frontend;

use modules\quote\models\Quote as BaseQuote;
use yii\db\ActiveRecord;

class Quote extends BaseQuote
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
    public function getVisibleItems($limit = false)
    {
        if ($limit) {
            return self::find()->where(['visible' => BaseQuote::VISIBLE_YES])->orderBy('sorting DESC')->limit($limit)->all();
        }
        return self::find()->where(['visible' => BaseQuote::VISIBLE_YES])->orderBy('sorting')->all();
    }
}
