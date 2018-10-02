<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use kartik\grid\GridView;
use modules\page\models\Page;
use modules\page\models\Category;
use common\helpers\Toolbar;

/* @var $this yii\web\View */
/* @var $searchModel modules\page\models\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pages');
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'sortable-table',
        ],
        'rowOptions' => function ($data) {
            return ['id' => $data->id];
        },
        'filterModel' => $searchModel,
        'resizeStorageKey' => 'pageGrid',
        'panel' => [
            'footer' => Html::tag('div', Toolbar::createButton(Yii::t('app', 'Add Page')), ['class' => 'pull-left'])
                . Toolbar::paginationSelect($dataProvider),
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Page')),
            Toolbar::deleteButton(),
            Toolbar::showSelect(),
            Toolbar::exportButton(),
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions' => ['class' => 'skip-export'],
                'contentOptions' => ['class' => 'skip-export'],
            ],
            'id',
            'link_name',
            'slug',
            [
                'attribute' => 'parent_id',
                'filter' => Category::getList(),
                'value' => function ($data) {
                    return !empty($data->parent) ? $data->parent->name : null;
                },
            ],
            'title',
            'meta_keywords',
            'meta_description',
            'header',
            [
                'attribute' => 'content',
                'value' => function ($data) {
                    return StringHelper::truncate(strip_tags($data->content), 180, '...');
                },
            ],
            [
                'class' => 'common\components\Column\SetColumn',
                'attribute' => 'visible',
                'filter' => Page::getVisibilityStatuses(),
                'cssClasses' => [
                    Page::VISIBLE_YES => 'success',
                    Page::VISIBLE_NO => 'danger',
                    Page::VISIBLE_LOGGED => 'warning',
                    Page::VISIBLE_NOT_LOGGED => 'warning',
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',

                'buttons' => [
                    'view' => function ($url, $model) {
                        $expandButton = Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-open']);
                        return Html::a($expandButton, Url::to(['../../' . $model->slug]), [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'target' => '_blank'
                        ]);
                    }
                ],
                'template' => $this->render('@backend/views/layouts/_options', [
                    'options' => [
                        'update' => 'page.backend.default.update',
                        'view' => 'page.backend.default.index',
                        'delete' => 'page.backend.default.delete'
                    ],
                ]),
                'headerOptions' => ['class'=>'skip-export'],
                'contentOptions' => ['class'=>'skip-export'],
            ],
        ],
    ]); ?>

</div>
