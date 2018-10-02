<?php

namespace modules\slider\models\frontend;

use modules\slider\models\Slider as BaseSlider;
use yii\db\ActiveRecord;

class Slider extends BaseSlider
{
    private $_i18nAttributes = [
        'name',
        'description',
        'button_caption',
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
    public function getVisibleItems($theme_id)
    {
        return self::find()->where(['visible' => BaseSlider::VISIBLE_YES, 'theme_id' => $theme_id])->orderBy('sorting')->all();
    }
}
