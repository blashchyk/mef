<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/*
<ol class="sortable">
    <li id="list_1"><div><span class="disclose"><span></span></span>Item 1</div>
        <ol>
            <li id="list_2"><div><span class="disclose"><span></span></span>Sub Item 1.1</div>
                <ol>
                    <li id="list_3"><div><span class="disclose"><span></span></span>Sub Item 1.2</div>
                </ol>
        </ol>
    <li id="list_4"><div><span class="disclose"><span></span></span>Item 2</div>
    <li id="list_5"><div><span class="disclose"><span></span></span>Item 3</div>
        <ol>
            <li id="list_6" class="mjs-nestedSortable-no-nesting"><div><span class="disclose"><span></span></span>Sub Item 3.1 (no nesting)</div>
            <li id="list_7"><div><span class="disclose"><span></span></span>Sub Item 3.2</div>
                <ol>
                    <li id="list_8"><div><span class="disclose"><span></span></span>Sub Item 3.2.1</div>
                </ol>
        </ol>
    <li id="list_9"><div><span class="disclose"><span></span></span>Item 4</div>
    <li id="list_10"><div><span class="disclose"><span></span></span>Item 5</div>
</ol>
 */
class Nested extends Widget
{
    public $items;

    public $details;

    public $options;

    public $emptyMessage = 'List does not contain any items.';

    public $defaultOptions = [
        'class' => 'nested-sortable',
        'leftClass' => 'pull-left',
        'rightClass' => 'pull-right',
        'containerClass' => 'item-container',
        'nameClass' => 'item-name',
        'typeClass' => 'item-type',
        'detailButtonClass' => 'glyphicon glyphicon-menu-down',
        'deleteButtonClass' => 'glyphicon glyphicon-trash',
        'detailClass' => 'detail-container clear',
        'emptyClass' => 'nested-empty',
        'templateClass' => 'item-template hidden',
    ];

    /**
     * @return null
     */
    public function init()
    {
        parent::init();

        $view = Yii::$app->getView();
        NestedAsset::register($view);

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
        return $this->renderItems($this->items, true);
    }

    /**
     * @param $menuItems
     * @param bool $isRoot
     * @return string
     */
    public function renderItems($menuItems, $isRoot = false)
    {
        $items = [];
        foreach ($menuItems as $item) {
            $items[] = $this->renderItem($item);
        }

        $messageClass = $this->options['emptyClass'] . (count($menuItems) > 0 ? ' hidden' : '');
        $message = Html::tag('div', $this->emptyMessage, ['class' => $messageClass]);

        $options = $isRoot ? ['class' => $this->options['class']] : [];
        $nestedContent = Html::tag('ol', $message . implode("\n", $items), $options);

        return $nestedContent;
    }

    /**
     * @param $item
     * @return string
     */
    public function renderItem($item)
    {
        $containerCaption = Html::tag('span', $item->linkName, ['class' => $this->options['nameClass']]);
        $containerCaption .= $this->getLinkType($item);
        $containerLeft = Html::tag('p', $containerCaption, ['class' => $this->options['leftClass']]);
        $containerRight = Html::tag('p', $this->getControlButtons(), ['class' => $this->options['rightClass']]);
        $containerContent = $this->getDiscloseButton() . $containerLeft . $containerRight . '&nbsp;' . $this->getDetails($item);
        $container = Html::tag('div', $containerContent, ['class' => $this->options['containerClass']]);

        $nestedItems = '';
        if (count($item->items) > 0) {
            $nestedItems = $this->renderItems($item->items);
        }

        return Html::tag('li', $container . $nestedItems, ['id' => 'items_' . (!$item->isNewRecord ? $item->id : 0)]);
    }

    /**
     * @return string
     */
    public function getDiscloseButton()
    {
        return Html::tag('p', '<span></span>', ['class' => 'disclose ' . $this->options['leftClass']]);
    }

    /**
     * @return string
     */
    public function getControlButtons()
    {
        $detailButton = Html::tag('span', '', ['class' => $this->options['detailButtonClass']]);
        $deleteButton = Html::tag('span', '', ['class' => $this->options['deleteButtonClass']]);

        return Html::a($detailButton, '#update', ['class' => 'detail-button'])
            . Html::a($deleteButton, '#delete', ['class' => 'delete-button', 'data-confirm' => 'Are you sure you want to delete the item?']);
    }

    /**
     * @param $model
     * @return null|string
     */
    public function getDetails($model)
    {
        if (empty($this->details)) {
            return null;
        }

        $template = $this->render($this->details['template'], ['model' => $model, 'form' => $this->details['form']]);
        return Html::tag('div', $template, [
            'style' => 'display: none',
            'class' => 'details ' . $this->options['detailClass'],
        ]);
    }

    /**
     * @param $model
     * @return string
     */
    public function getLinkType($model)
    {
        $typeList = [];
        if (isset($model::$types)) {
            foreach ($model::$types as $key => $type) {
                $classOptions = ['type-' . $key];
                if ($model->type != $key || $model->isNewRecord) {
                    $classOptions[] = 'hidden';
                }
                $typeList[] = Html::tag('span', $type, ['class' => $classOptions]);
            }
        }

        $classOptions = [$this->options['typeClass']];
        if (empty($model->linkType)) {
            $classOptions[] = 'hidden';
        }
        return Html::tag('small', '(' . implode('', $typeList) . ')', ['class' => $classOptions]);
    }

    /**
     * @param $item
     * @return null|string
     */
    public function renderEmpty($item)
    {
        if (empty($this->details)) {
            return null;
        }

        $template = $this->renderItem($item);
        return Html::tag('div', $template, ['class' => $this->options['templateClass']]);
    }
}
