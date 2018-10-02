<?php

namespace modules\i18n\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TranslationSearch represents the model behind the search form about `common\models\Translation`.
 */
class TranslationSearch extends Translation
{
    public $sourceMessage;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['language', 'translation', 'sourceMessage'], 'safe'],
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
        $query = Translation::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sourceMessage' => SORT_ASC,
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

        $query->andFilterWhere([
            'id' => $this->id,
        ])->joinWith(['message']);

        $query->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'translation', $this->translation])
            ->andFilterWhere(['like', 'message', $this->sourceMessage]);

        $dataProvider->sort->attributes['sourceMessage'] = [
            'asc' => ['message' => SORT_ASC],
            'desc' => ['message' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
