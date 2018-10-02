<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use modules\menu\models\Menu;
use common\helpers\Toolbar;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menus');
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'resizeStorageKey' => 'menuGrid',
        'panel' => [
            'footer' => Toolbar::createButton(Yii::t('app', 'Add Menu'))
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Menu')),
            Toolbar::deleteButton(),
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $widget) {
                    if ($model->type == Menu::TYPE_SYSTEM) {
                        return ['class' => 'hidden'];
                    }
                    return null;
                },
            ],
            'id',
            'typeName',
            'name',
            [
                'attribute' => 'code',
                'value' => function ($data) {
                    return '{{ ' . $data->code . ' }}';
                },
            ],
            [
                'label' => Yii::t('app', 'Item Count'),
                'value' => function ($data) {
                    return $data->menuItems ? count($data->menuItems) : null;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        if ($model->type == Menu::TYPE_SYSTEM) {
                            return null;
                        }
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ],
                'template' => $this->render('@backend/views/layouts/_options', [
                    'options' => [
                        'update' => 'update',
                        'delete' => 'delete'
                    ],
                ]),
            ],
        ],
    ]); ?>

</div>
