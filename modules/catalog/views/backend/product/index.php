<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use kartik\sortable\Sortable;
use kartik\sortinput\SortableInput;
use common\widgets\Gallery;
use common\helpers\Toolbar;

/* @var $this yii\web\View */
/* @var $searchModel modules\catalog\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
?>

<?= Gallery::widget() ?>

<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $models = $dataProvider->getModels();
    $items = [];

    foreach ($models as $key => $model) {
        $items[$model->id] = [
            'content' => $this->render('_item', ['model' => $model]),
        ];
    }

    $currentPage = $dataProvider->pagination->page;
    $pageSize = $dataProvider->pagination->pageSize;
    $totalNumber = $dataProvider->totalCount;
    $beginNumber = $currentPage * $pageSize + 1;
    $endNumber = $beginNumber + count($items) - 1;
    $summary = "<b>$beginNumber-$endNumber</b> of <b>$totalNumber</b>";
    ?>

    <div class="panel panel-default panel-custom">
        <div class="panel-heading">
            <div class="btn-toolbar pull-left">
                <?= Toolbar::refreshButton()
                     . Toolbar::createButton(Yii::t('app', 'Add Product'))
                     . Toolbar::deleteButton()
                ?>
            </div>
            <div class="kv-panel-pager pull-right">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->getPagination()
                ]); ?>
            </div>
            <div class="pull-right">
                <div class="summary">
                    <?= $summary ?> &nbsp;
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= SortableInput::widget([
        'items' => $items,
        'name' => 'sorted-list',
        'id' => 'sorted-list',
        'hideInput' => true,
        'sortableOptions' => [
            'type' => Sortable::TYPE_GRID,
            'pluginEvents' => [
                'sortupdate' => 'function() { ListSortHelper.sortingUpdate(); }',
            ],
        ],
        'options' => [
            'data-url' => Url::to(['sort']),
        ]
    ]); ?>

    <div class="panel panel-default panel-custom">
        <div class="panel-heading">
            <div class="btn-toolbar pull-left">
                <?= Toolbar::createButton(Yii::t('app', 'Add Product')) ?>
            </div>
            <?= Toolbar::paginationSelect($dataProvider) ?>
            <div class="kv-panel-pager pull-right">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->getPagination()
                ]); ?>
            </div>
            <div class="pull-right">
                <div class="summary">
                    <?= $summary ?> &nbsp;
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

</div>