<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\helpers\Toolbar;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel modules\user\models\ProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Profiles');
?>

<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($data) {
            return ['id' => $data->id];
        },
        'filterModel' => $searchModel,
        'resizeStorageKey' => 'userGrid',
        'panel' => [
            'footer' => Toolbar::paginationSelect($dataProvider),
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::exportButton(),
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'contentOptions' => ['class'=>'skip-export'],
                'headerOptions' => ['class'=>'skip-export']
            ],
            'user.username',
            'country.name',
            'city',
            'address',
            'phone',
            'birthday:date',
            'genderName',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::toRoute(['update', 'id' => $model->id]), [
                            'title' => Yii::t('app', 'Update'),
                        ]);
                    },
                ],
                'template' => $this->render('@backend/views//layouts/_options', [
                    'options' => [
                        'update' => 'profile.backend.update'
                    ],
                ]),
            ],
        ],
    ]); ?>

</div>