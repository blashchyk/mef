<?php

namespace modules\page\models\frontend;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\behaviors\I18nBehavior;
use common\behaviors\TimestampBehavior;
use modules\page\models\PageI18n;
use modules\page\models\Page as BasePage;
use modules\snippet\models\frontend\Snippet;

class Page extends BasePage
{
    private $_i18nAttributes = [
        'link_name',
        'title',
        'meta_keywords',
        'meta_description',
        'header',
        'content',
    ];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class'=> I18nBehavior::className(),
                'i18nModelClass' => PageI18n::className(),
            ],
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
     * @return null
     */
    public function afterFind()
    {
        foreach ($this->_i18nAttributes as $attribute) {
            $value = $this->getAttributeValue($attribute);
            $cleanValue = trim(strip_tags($value));
            if (!empty($cleanValue)) {
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
    public function getVisibleItems($parentSlug, $params = [], $pageSize = 5)
    {
        $query = Page::find();

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
            '{{%page}}.parent_id' => $this->parent_id,
            '{{%page}}.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['{{%page}}.visible' => Page::VISIBLE_YES])
                ->andFilterWhere(['not', ['{{%page}}.parent_id' => null]])
            ->joinWith(['parent p'])
                ->andFilterWhere(['p.visible' => Category::VISIBLE_YES])
                ->andFilterWhere(['like', 'p.slug', $parentSlug]);

        return $dataProvider;
    }

    /**
     * Get ton n records
     *
     * @param int $amount
     *
     * @return ActiveDataProvider
     */
    public function getTopItems($amount = 5)
    {
        return self::find()
            ->where(['not', ['parent_id' => null]])
            ->andWhere(['visible' => Page::VISIBLE_YES])
            ->limit($amount)
            ->all();
    }


    /**
     * @return mixed
     */
    public function getFormattedContent()
    {
        $snippets = Snippet::getList();
        $snippetSlugs = array_map(function($value) { return '{{' . $value . '}}'; }, array_keys($snippets));

        return str_replace($snippetSlugs, $snippets, $this->content);
    }
}
