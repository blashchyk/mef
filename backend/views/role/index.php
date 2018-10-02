<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\helpers\Toolbar;
use \yii\helpers\Url;

/* @var yii\web\View $this */
/* @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Roles');
?>
<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'resizeStorageKey' => 'roleGrid',
        'panel' => [
            'footer' => Toolbar::createButton(Yii::t('app', 'Add Role'))
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Role')),
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'description',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update', 'name' => $model->name]), [
                            'title' => Yii::t('app', 'Update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'data-method' => 'post',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::toRoute(['delete', 'name' => $model->name]), $options);
                    },
                ],
                'template' => $this->render('@backend/views//layouts/_options', [
                    'options' => [
                        'update' => 'update',
                        'delete' => 'delete'
                    ],
                ]),
            ],
        ],
    ]); ?>

</div>
