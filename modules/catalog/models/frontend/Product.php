<?php

namespace modules\catalog\models\frontend;

use yii\data\ActiveDataProvider;
use common\behaviors\I18nBehavior;
use common\behaviors\ImageBehavior;
use common\behaviors\TimestampBehavior;
use common\behaviors\FilterBehavior;
use modules\catalog\models\ProductI18n;
use modules\catalog\models\ProductField;
use modules\catalog\models\Product as BaseProduct;

/**
 * Class Product
 * @property float $maxPriceFilter
 * @property float $minPriceFilter
 * @property float $maxPriceLimit
 * @property float $minPriceLimit
 *
 * @package modules\catalog\models\frontend
 */
class Product extends BaseProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [array_merge(['id', 'parent_id', 'user_id', 'sorting', 'created_at', 'updated_at'], FilterBehavior::getIntegerFilters()), 'integer'],
            [['visible'], 'boolean'],
            //[array_merge(['name', 'slug', 'image', 'description'], FilterBehavior::getRangeFilters()), 'string'],
            [array_merge(['name', 'slug', 'image', 'description'], FilterBehavior::getStringFilters()), 'string'],
            [['price'], 'number'],
        ];
    }

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
            ImageBehavior::className(),
            TimestampBehavior::className(),
            [
                'class'=> I18nBehavior::className(),
                'i18nModelClass' => ProductI18n::className(),
            ],
            [
                'class'=> FilterBehavior::className(),
                'additionFieldClass'=> ProductField::className(),
                'defaultFilters' => ['p.slug' => 'slug'],
                'joinWith' => ['parent p', 'user u'],
                'linkList' => ['parent_id' => 'p.name', 'user_id' => 'u.email']
            ],
        ];
    }

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
     * Creates data provider with visible items
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function getVisibleItems($params = [], $pageSize = 15)
    {
        $query = Product::find()->alias('t');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        $query->andFilterWhere([
            't.parent_id' => $this->parent_id,
            't.user_id' => $this->user_id,
        ]);

        $query->joinWith(['parent p'])
            ->andFilterWhere(['t.id' => $this->id])
            ->andFilterWhere(['t.visible' => Product::VISIBLE_YES])
            ->andFilterWhere(['not', ['t.parent_id' => null]])
            ->andFilterWhere(['like', 't.name', $this->name])
            ->andFilterWhere(['p.visible' => Category::VISIBLE_YES])
            ->andFilterWhere(['like', 'p.slug', $this->slug])
            ->andFilterWhere(['like', 't.description', $this->description]);

        return $dataProvider;
    }

    /**
     * Get ton n records
     *
     * @param int $amount
     *
     * @return ActiveDataProvider
     */
    public function getTopItems($amount = 4)
    {
        return $this->getVisibleItems([], $amount)->getModels();
    }
}
