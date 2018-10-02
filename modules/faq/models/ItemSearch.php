<?php

namespace modules\faq\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\behaviors\I18nBehavior;

/**
 * ItemSearch represents the model behind the search form about `modules\faq\models\Item`.
 */
class ItemSearch extends Item
{
    public $date_from;
    public $date_to;
    public $date_upd_from;
    public $date_upd_to;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => I18nBehavior::className(),
                'i18nModelClass' => ItemI18n::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'user_id', 'sorting', 'created_at', 'updated_at'], 'integer'],
            [['visible'], 'boolean'],
            [['name', 'slug', 'description'], 'safe'],
            [['date_from', 'date_to'], 'date' ,'format'=>'php:U'],
            [['date_upd_from', 'date_upd_to'], 'date' ,'format'=>'php:U'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Item::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sorting' => SORT_ASC,
                ]
            ],
        ]);

        if (!empty($params['pageSize'])) {
            $dataProvider->pagination->pageSize = $params['pageSize'];
        }

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'user_id' => $this->user_id,
            'visible' => $this->visible,
            'sorting' => $this->sorting,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? $this->date_from : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? $this->date_to : null])
            ->andFilterWhere(['>=', 'updated_at', $this->date_upd_from ? $this->date_upd_from : null])
            ->andFilterWhere(['<=', 'updated_at', $this->date_upd_to ? $this->date_upd_to : null]);

        $dataProvider->sort->attributes['created'] = [
            'asc' => ['created_at' => SORT_ASC],
            'desc' => ['created_at' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['updated'] = [
            'asc' => ['updated_at' => SORT_ASC],
            'desc' => ['updated_at' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
