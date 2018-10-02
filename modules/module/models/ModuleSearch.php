<?php

namespace modules\module\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ModuleSearch represents the model behind the search form about `modules\module\models\Module`.
 */
class ModuleSearch extends Module
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['visible'], 'boolean'],
            [['slug', 'name', 'parent.name'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['parent.name']);
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
        $query = Module::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sorting' => SORT_ASC,
                ]
            ]
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

        $query->andFilterWhere([
            'id' => $this->id,
            'visible' => $this->visible,
        ])->joinWith([
            'parent' => function ($query) {
                $query->from(['parent' => '{{%module}}']);
            }
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            //->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['or', ['like', '{{%module}}.name', $this->name], ['like', 'parent.name', $this->name]]);

        return $dataProvider;
    }
}
