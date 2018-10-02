<?php

namespace modules\faq\models\frontend;

use Yii;
use yii\data\ActiveDataProvider;
use modules\faq\models\Category as BaseCategory;

class Category extends BaseCategory
{
    private $_i18nAttributes = [
        'name'
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
     * Creates data provider with visible items
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function getVisibleItems($parentSlug = null, $params = [], $pageSize = 2)
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'sorting' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        $query->andFilterWhere(['visible' => Category::VISIBLE_YES]);

        return $dataProvider;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return Item::find()->where(['parent_id' => $this->id])->all();
    }
}
