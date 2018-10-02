<?php

namespace modules\quote\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * QuoteSearch represents the model behind the search form about `modules\quote\models\Quote`.
 */
class QuoteSearch extends Quote
{
    public $date_from;
    public $date_to;
    public $date_upd_from;
    public $date_upd_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'visible', 'sorting', 'created_at', 'updated_at'], 'integer'],
            [['name', 'image', 'description'], 'safe'],
            [['date_from', 'date_to'], 'date' ,'format'=>'php:U'],
            [['date_upd_from', 'date_upd_to'], 'date' ,'format'=>'php:U'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
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
        $query = Quote::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sorting' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'visible' => $this->visible,
            'sorting' => $this->sorting,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'image', $this->image])
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
