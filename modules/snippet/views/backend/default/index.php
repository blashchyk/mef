<?php

use common\helpers\Toolbar;
use kartik\grid\GridView;
use modules\snippet\models\Snippet;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\snippet\models\SnippetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Snippets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="snippet-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($data) {
            return ['id' => $data->id];
        },
        'resizeStorageKey' => 'snippetGrid',
        'panel' => [
            'footer' => Html::tag('div', Toolbar::createButton(Yii::t('app', 'Add Snippet')), ['class' => 'pull-left'])
                . Toolbar::paginationSelect($dataProvider),
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Snippet')),
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
            'name',
            'slug',
            [
                'attribute' => 'location',
                'filter' => Snippet::getLocations(),
                'value' => function ($data) {
                    return !empty($data->getLocations()[$data->location])
                        ? $data->getLocations()[$data->location]
                        : null;
                },
            ],
            [
                'class' => 'common\components\Column\SetColumn',
                'attribute' => 'visible',
                'filter' => Snippet::getVisibilityStatuses(),
                'cssClasses' => [
                    Snippet::VISIBLE_YES => 'success',
                    Snippet::VISIBLE_NO => 'danger',
                    Snippet::VISIBLE_ON_SELECTED => 'warning',
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
                        'update' => 'update',
                        'show' => 'index',
                        'delete' => 'delete'
                    ],
                ])
            ],
        ],
    ]); ?>
</div>
