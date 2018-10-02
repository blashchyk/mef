<?php

namespace modules\mail\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MailSearch represents the model behind the search form about `modules\mail\models\Mail`.
 */
class MailSearch extends Mail
{
    public $date_from;
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'opened', 'created_at', 'updated_at'], 'integer'],
            [['sender_email', 'sender_name', 'sender', 'subject', 'body'], 'safe'],
            [['date_from', 'date_to'], 'date' ,'format'=>'php:U'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['sender']);
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
        $query = Mail::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
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
            'opened' => $this->opened,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sender' => $this->sender_name . ' ' . $this->sender_email,
        ]);

        $query->andFilterWhere(['like', 'sender_email', $this->sender_email])
            ->andFilterWhere(['like', 'sender_name', $this->sender_name])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['or', ['like', 'sender_email', $this->sender], ['like', 'sender_name', $this->sender]])
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? $this->date_from : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? $this->date_to : null]);

        $dataProvider->sort->attributes['sender'] = [
            'asc' => ['sender_name' => SORT_ASC, 'sender_email' => SORT_ASC],
            'desc' => ['sender_name' => SORT_DESC, 'sender_email' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['created'] = [
            'asc' => ['created_at' => SORT_ASC],
            'desc' => ['created_at' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
