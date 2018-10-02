<?php

namespace modules\page\models\frontend;

use yii\data\ActiveDataProvider;
use common\behaviors\I18nBehavior;
use common\behaviors\TimestampBehavior;
use modules\page\models\CategoryI18n;
use modules\page\models\Category as BaseCategory;

/**
 * CategorySearch represents the model behind the search form about `modules\page\models\Category`.
 */
class Category extends BaseCategory
{
    private $_i18nAttributes = [
        'name'
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
     * @return ActiveDataProvider
     */
    public function getVisibleItems()
    {
        return self::find()->where(['visible' => Category::VISIBLE_YES])->all();
    }
}
