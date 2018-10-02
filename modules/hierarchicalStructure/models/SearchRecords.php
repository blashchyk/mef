<?php

namespace modules\hierarchicalStructure\models;

use yii\data\ActiveDataProvider;
use Yii;
use yii\data\ArrayDataProvider;

/**
 * Class SearchRecords
 * @package modules\hierarchicalStructure\models
 */
class SearchRecords extends Records
{
    public $fullSearch;
    public $fund_id;
    private $margins = [
        'id',
        'code',
        'title',
        'level_description',
        'extent_description',
        'creator',
        'administrative_history',
        'archival_history',
        'trans',
        'content',
        'information',
        'accruals',
        'arrangement',
        'access',
        'reproduction',
        'language',
        'characteristics',
        'aids',
        'location_originals',
        'location_copies',
        'related_units',
        'publication_note',
        'note',
        'archivist_note',
        'rules',
        'date_descriptions',
        'date',
        'final_date'
    ];

    public function rules()
    {
        return [
            ['fullSearch', 'string', 'min' => 3],
            ['fund_id', 'integer']
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['fullSearch']);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels, [
            'fullSearch' => \Yii::t('app', 'Full Search'),
            'fund_id' => \Yii::t('app', 'Fond')
        ]);
    }

    /**
     * @return string
     */
    public function formName()
    {
        return 's';
    }

    /**
     * @param $params
     * @return BaseDataProvider
     */
    public function search($params)
    {
        $postData = $params[$this->formName()];

        if ($postData === null) {
            return new ArrayDataProvider([]);
        }

        $records = Records::find()->select(array_merge($this->margins, [
            'node_id',
            'fond_id',
            'full_code',
            'public',
        ]));

        return $this->searchAllFunds($records, $params);

    }

    /**
     * @param $records
     * @return ModifiedActiveDataProvider
     *Search all records and funds
     */
    protected function searchAllFunds($records, $params)
    {
        $postData = $params[$this->formName()];
        //if the fund is not selected. Search all records and all funds
        if ($postData['fund_id'] == '') {
            $funds = Funds::find()->select(array_merge($this->margins, [
                "hs_id AS node_id",
                "id AS fond_id",
                "code AS full_code",
                "public_fund AS public"
            ]));
            //Combining search queries on records and on funds
            $query = $records->union($funds);
            //Search by records of a specific fund
        } else {
            $query = $records;
        }
        $dataProvider = new ModifiedActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'full_code' => SORT_ASC,
                ]
            ],
        ]);
        if (!empty($params['pageSize'])) {
            $dataProvider->pagination->pageSize = $params['pageSize'];
        }
        if (!empty($postData)) {
            $this->fullSearch = $postData['fullSearch'];
            $array_keys = array_keys($postData, '1');
        }
        $fondQuery = $postData['fund_id'] ? ['fond_id' => $postData['fund_id']] : [];
        $permissionQuery = Yii::$app->user->can('admin') ? ['1=1'] : [];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $recordQuery = array_merge(
            ['or'],
            array_map(
                function ($c) {
                    return ['like', $c, $this->fullSearch];
                },
                !empty($array_keys) ? $array_keys : $this->margins
            )
        );
        //Search only for public records
        $records->orFilterWhere([
            'and',
            $fondQuery,
            $recordQuery,
            array_merge(
                ['or'],
                ['[[public]]=1'],
                $permissionQuery
            )

        ]);
        if ($postData['fund_id'] == '') {
            //Search only for public funds
            $funds->orFilterWhere([
                'and',
                $fondQuery,
                $recordQuery,
                array_merge(
                    ['or'],
                    ['[[public_fund]]=1'],
                    $permissionQuery
                )
            ]);
        }
        return $dataProvider;
    }
}
