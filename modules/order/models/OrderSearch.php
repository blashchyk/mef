<?php

namespace modules\order\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form about `modules\order\models\Order`.
 */
class OrderSearch extends Order
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
            [['id', 'user_id', 'country_id', 'vat_tax', 'status', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'zip', 'city', 'address', 'phone', 'description', 'transaction_id', 'fullName'], 'safe'],
            [['price'], 'number'],
            [['date_from', 'date_to'], 'date' ,'format'=>'php:U'],
            [['date_upd_from', 'date_upd_to'], 'date' ,'format'=>'php:U'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['fullName']);
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        if (!empty($params['pageSize'])) {
            $dataProvider->pagination->pageSize = $params['pageSize'];
        }

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
            'country_id' => $this->country_id,
            'price' => $this->price,
            'vat_tax' => $this->vat_tax,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'fullName' => $this->first_name . ' ' . $this->last_name,
        ])->joinWith(['user', 'country']);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'zip', $this->zip])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['or', ['like', 'first_name', $this->fullName], ['like', 'last_name', $this->fullName]]);

        $dataProvider->sort->attributes['fullName'] = [
            'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
            'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['location'] = [
            'asc' => ['country.name' => SORT_ASC, 'city' => SORT_ASC, 'zip' => SORT_ASC],
            'desc' => ['country.name' => SORT_DESC, 'city' => SORT_DESC, 'zip' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
