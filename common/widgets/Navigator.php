<?php

namespace common\widgets;

use yii\base\Widget;
use yii\bootstrap\Nav as WidgetNav;
use yii\widgets\Menu as WidgetMenu;
use modules\menu\models\frontend\Menu;

class Navigator extends Widget
{
    public $menuCode;

    public $isDropdown = false;

    public $options = [];

    public $items = [];

    /**
     * Initializes the widget.
     */
    public function run()
    {
        //parent::init();

        $menu = Menu::findOne(['code' => $this->menuCode]);

        if (empty($menu)) {
            return null;
        }

        $items = $menu->rootItems;

        $this->items = array_merge($this->items, $this->getItems($items));

        $options = [
            'items' => $this->items,
            'options' => $this->options,
        ];

        if ($this->isDropdown == true) {
            return WidgetNav::widget($options);
        } else {
            return WidgetMenu::widget($options);
        }
    }

    /**
     * @return array
     */
    public function getItems($items)
    {
        $menuItems = [];
        foreach ($items as $item) {
            $menuItems[] = [
                'label' => \Yii::t('app', $item->linkName),
                'url' => $item->linkUrl,
                'items' => !empty($item->items) ? $this->getItems($item->items) : null,
                'visible' => $item->visible,
            ];
        }

        return $menuItems;
    }
}
