<?php

namespace modules\hierarchicalStructure\models;


use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Class SearchRecordsEol
 * @package modules\hierarchicalStructure\models
 */
class SearchRecordsEol extends Records
{

    const ELIMINATION = 3;
    /**
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query =  Records::find()
            ->innerJoinWith('term')
            ->orwhere(
                [
                    'and',
                    [
                        'final_date' => ''
                    ],
                    [
                        '{{%hs_tree_node}}.[[final_destination_id]]' => self::ELIMINATION
                    ],
                    [
                        '<',
                        'date',
                        new Expression(strtotime(date('Y-m-d')) . ' - conservation_term * 31536000 ')
                    ],
                ]
            )
            ->orWhere(
                [
                    'and',
                    [
                        'not in', 'final_date', ''
                    ],
                    [
                        '{{%hs_tree_node}}.[[final_destination_id]]' => self::ELIMINATION
                    ],
                    [
                        '<',
                        'final_date',
                        new Expression(strtotime(date('Y-m-d')) . ' - conservation_term * 31536000 ')
                    ],
                ]
            );
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'date'  => SORT_ASC,
                ]
            ],
        ]);
    }
}
