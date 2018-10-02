<?php

namespace modules\menu\models\frontend;

use Yii;
use modules\menu\models\MenuItem as BaseMenuItem;
use modules\page\models\frontend\Page;

class MenuItem extends BaseMenuItem
{
    private $_i18nAttributes = [
        'link_name',
    ];

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
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return string
     */
    public function getLinkName()
    {
        $linkName = $this->link_name;
        if (!empty($this->page) && (empty($linkName) || $this->inherited)) {
            $linkName =$this->page->link_name;
        }

        return $linkName;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getItems()
    {
        return MenuItem::find()
            ->where(['menu_id' => $this->menu_id, 'parent_id' => $this->id])
            ->orderBy('sorting')
            ->all();
    }
}
