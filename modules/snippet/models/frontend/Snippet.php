<?php

namespace modules\snippet\models\frontend;

use Yii;
use modules\snippet\models\Snippet as BaseSnippet;

class Snippet extends BaseSnippet
{
    private $_i18nAttributes = [
        'content',
    ];

    /**
     * @return null
     */
    public function afterFind()
    {
        foreach ($this->_i18nAttributes as $attribute) {
            $value = $this->getAttributeValue($attribute);
            if (!empty(trim(strip_tags($value)))) {
                $this->setAttribute($attribute, $value);
            }
        }

        parent::afterFind();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getPageSnippets($location, $pageId)
    {
        return self::find()
            ->joinWith('snippetPages')
            ->where(['location' => $location, 'visible' => self::VISIBLE_ON_SELECTED, 'page_id' => $pageId])
            ->orWhere(['location' => $location, 'visible' => self::VISIBLE_YES])
            ->all();
    }

    /**
     * @return array
     */
    public static function getList()
    {
        $list = [];
        $models = self::find()->all();

        foreach ($models as $model) {
            $list[$model->slug] = $model->content;
        }

        return $list;
    }
}
