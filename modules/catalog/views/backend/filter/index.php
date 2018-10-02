<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\helpers\Toolbar;
use modules\catalog\models\Product;
use modules\catalog\models\Category;
use modules\catalog\models\Filter;

/* @var $this yii\web\View */
/* @var $searchModel modules\catalog\models\FilterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Filters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filter-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => [
            'class' => 'sortable-table',
        ],
        'rowOptions' => function ($data) {
            return ['id' => $data->id];
        },
        'resizeStorageKey' => 'filterGrid',
        'panel' => [
            'footer' => Html::tag('div', Toolbar::createButton(Yii::t('app', 'Add Filter')), ['class' => 'pull-left'])
                . Toolbar::paginationSelect($dataProvider),
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Filter')),
            Toolbar::deleteButton(),
            Toolbar::showSelect(),
            Toolbar::exportButton(),
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions' => ['class'=>'skip-export'],
                'contentOptions' => ['class'=>'skip-export'],
            ],
            'id',
            [
                'attribute' => 'field',
                'filter' => Product::getFields(),
                'value' => function ($data) {
                    return !empty(Product::getFields($data->category_id)[$data->field]) ? Product::getFields($data->category_id)[$data->field] : $data->field;
                },
            ],
            [
                'attribute' => 'type',
                'filter' => Filter::getValueTypes(),
                'value' => function ($data) {
                    return !empty(Filter::getValueTypes()[$data->type]) ? Filter::getValueTypes()[$data->type] : null;
                },
            ],
            [
                'attribute' => 'category_id',
                'filter' => Category::getList(),
                'value' => function ($data) {
                    return !empty($data->category) ? $data->category->name : Yii::t('app', 'All Categories');
                },
            ],
            [
                'class' => 'common\components\Column\SetColumn',
                'attribute' => 'visible',
                'filter' => Category::getVisibilityStatuses(),
                'cssClasses' => [
                    Filter::VISIBLE_YES => 'success',
                    Filter::VISIBLE_NO => 'danger',
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'show' => function ($url, $model) {
                        if ($model->visible) {
                            $options = ['title' => Yii::t('app', 'Disable')];
                            $iconClass = 'glyphicon-unlock';
                        } else {
                            $options = ['title' => Yii::t('app', 'Enable')];
                            $iconClass = 'glyphicon-lock';
                        }
                        return Html::a('<span class="glyphicon ' . $iconClass . '"></span>', $url, $options);
                    },
                ],
                'template' => $this->render('@backend/views/layouts/_options', [
                    'options' => [
                        'update' => 'catalog.backend.category.update',
                        'show' => 'catalog.backend.category.index',
                        'delete' => 'catalog.backend.category.delete'
                    ],
                ]),
            ],

        ],
    ]); ?>
</div>
