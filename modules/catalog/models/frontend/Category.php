<?php

namespace modules\catalog\models\frontend;

use common\behaviors\I18nBehavior;
use common\behaviors\TimestampBehavior;
use modules\catalog\models\Category as BaseCategory;
use modules\catalog\models\CategoryI18n;
use yii\db\ActiveRecord;

class Category extends BaseCategory
{
    private $_i18nAttributes = [
        'name',
        'description',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class'=> I18nBehavior::className(),
                'i18nModelClass' => CategoryI18n::className(),
            ],
        ];
    }

    /**
     * @return null
     */
    public function afterFind()
    {
        foreach ($this->_i18nAttributes as $attribute) {
            $value = $this->getAttributeValue($attribute);
            if (!empty(trim(strip_tags($value)))) {
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
        return self::find()->where(['visible' => BaseCategory::VISIBLE_YES])->all();
    }
}
