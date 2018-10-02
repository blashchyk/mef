<?php

namespace modules\media\models\frontend;

use Yii;
use yii\data\ActiveDataProvider;
use common\behaviors\ImageBehavior;
use common\behaviors\TimestampBehavior;
use modules\media\models\Media as BaseMedia;

class Media extends BaseMedia
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => ImageBehavior::className(),
                'fieldName' => 'file',
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }*/

    /**
     * @return string
     */
    public function getImageUrl($isThumbnail = false)
    {
        return Yii::$app->storage->getImageUrl($this, 'file', $isThumbnail);
    }

    /**
     * Creates data provider with visible items
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function getVisibleItems($parentSlug, $params = [], $pageSize = 15)
    {
        $query = Media::find();

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
            self::tableName() . '.parent_id' => $this->parent_id,
            self::tableName() . '.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere([self::tableName() . '.visible' => Media::VISIBLE_YES])
            ->andFilterWhere(['not', [self::tableName() . '.parent_id' => null]])
            ->joinWith(['parent p'])
            ->andFilterWhere(['p.visible' => Category::VISIBLE_YES])
            ->andFilterWhere(['like', 'p.slug', $parentSlug]);

        return $dataProvider;
    }

    /**
     * Get ton n files
     *
     * @param int @amount
     *
     * @return ActiveDataProvider
     */
    public function getTopItems($amount = 5)
    {
        return $this->getVisibleItems(null, [], $amount)->getModels();
    }
}
