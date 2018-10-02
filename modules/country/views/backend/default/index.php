<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\helpers\Toolbar;

/* @var $this yii\web\View */
/* @var $searchModel modules\country\models\CountrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Countries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizeStorageKey' => 'countryGrid',
        'panel' => [
            'footer' => Html::tag('div', Toolbar::createButton(Yii::t('app', 'Add Country')), ['class' => 'pull-left'])
                . Toolbar::paginationSelect($dataProvider),
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Country')),
            Toolbar::exportButton(),
        ],
        'columns' => [
            'id',
            'name',
            'phone_code',
            [
                'attribute' => 'vat_rate',
                'value' => function ($data) {
                    return !empty($data->vat_rate) ? $data->vat_rate . '%' : null;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => $this->render('@backend/views/layouts/_options', [
                    'options' => [
                        'update' => 'country.backend.default.update',
                        'delete' => 'country.backend.default.delete'
                    ],
                ]),
                'headerOptions' => ['class'=>'skip-export'],
                'contentOptions' => ['class'=>'skip-export'],
            ],
        ],
    ]); ?>
</div>
