<?php
namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class Menu extends Widget
{
    public $items;

    public $options;

    public $defaultOptions = [
        'class' => 'list-group',
        'itemClass' => 'list-group-item',
        'activeClass' => 'active',
        'notActiveClass' => 'list-group-item-info',
        'badgeClass' => 'badge',
    ];

    /**
     * @return null
     */
    public function init()
    {
        parent::init();

        foreach ($this->defaultOptions as $key => $value) {
            if (empty($this->options[$key])) {
                $this->options[$key] = $value;
            }
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->renderItems();
    }

    /**
     * @return string
     */
    public function renderItems()
    {
        $items = [];
        foreach ($this->items as $item) {
            if ($item['visible'] === false) {
                continue;
            }
            $items[] = Html::a($item['label'] . $this->getItemBadge($item), Url::to($item['url']), ['class' => $this->getItemClass($item)]);
        }
        return Html::tag('div', implode("\n", $items), ['class' => $this->options['class']]);
    }

    /**
     * @param $item
     * @return mixed
     */
    public function getItemClass($item)
    {
        $classes = [$this->options['itemClass']];
        if (!empty($item['active'])) {
            $classes[] = $this->options['activeClass'];
        } else {
            $classes[] = $this->options['notActiveClass'];
        }
        return implode(' ', $classes);
    }

    /**
     * @param $item
     * @return string
     */
    public function getItemBadge($item)
    {
        $badge = '';
        if (!empty($item['badge'])) {
            $badge = Html::tag('span', $item['badge'], ['class' => $this->options['badgeClass']]);
        }
        return $badge;
    }
}
