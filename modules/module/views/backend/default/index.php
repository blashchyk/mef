<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use modules\module\models\Module;
use common\helpers\Toolbar;

/* @var $this yii\web\View */
/* @var $searchModel modules\module\models\ModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Modules');
?>
<div class="module-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'sortable-table',
        ],
        'rowOptions' => function ($data) {
            return [ 'id' => $data->id ];
        },
        'filterModel' => $searchModel,
        'resizeStorageKey' => 'moduleGrid',
        'panel' => [
            'footer' => Html::tag('div', Toolbar::createButton(Yii::t('app', 'Add Module')), ['class' => 'pull-left'])
                . Toolbar::paginationSelect($dataProvider),
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Module')),
            Toolbar::showSelect(),
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            'id',
            [
                'attribute' => 'name',
                'value' => function ($data) {
                    return ($data->parent ? $data->parent->name . '.' : '') . $data->name;
                },
            ],
            'slug',
            [
                'class' => 'common\components\Column\SetColumn',
                'attribute' => 'visible',
                'filter' => Module::getVisibilityStatuses(),
                'cssClasses' => [
                    Module::VISIBLE_YES => 'success',
                    Module::VISIBLE_NO => 'danger',
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
                        'show' => 'index'
                    ],
                ]),
            ],
        ],
    ]); ?>

</div>
