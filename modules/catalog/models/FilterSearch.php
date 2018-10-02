<?php

namespace modules\catalog\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FilterSearch represents the model behind the search form about `modules\catalog\models\Filter`.
 */
class FilterSearch extends Filter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'category_id', 'sorting', 'visible'], 'integer'],
            [['field'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Filter::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sorting' => SORT_ASC,
                ]
            ]
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
            'field' => $this->field,
            'type' => $this->type,
            'category_id' => $this->category_id,
            'sorting' => $this->sorting,
            'visible' => $this->visible,
        ]);

        return $dataProvider;
    }
}
