<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\StringHelper;
use common\helpers\Toolbar;
use modules\mail\models\Mail;

/* @var $this yii\web\View */
/* @var $searchModel modules\mail\models\MailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Emails');
?>
<div class="mail-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizeStorageKey' => 'mailGrid',
        'panel' => [
            'footer' => Html::tag('div', Toolbar::createButton(Yii::t('app', 'Add Email')), ['class' => 'pull-left'])
                . Toolbar::paginationSelect($dataProvider),
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Email')),
            Toolbar::deleteButton(),
            Toolbar::openSelect(),
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
                'attribute' => 'sender',
                'format' => 'html',
                'value' => function ($data) {
                    $value = $data->sender;
                    if (!$data->opened) {
                        $value = Html::tag('b', $value);
                    }
                    return $value;
                },
            ],
            [
                'attribute' => 'subject',
                'format' => 'html',
                'value' => function ($data) {
                    $value = $data->subject;
                    if (!$data->opened) {
                        $value = Html::tag('b', $value);
                    }
                    return $value;
                },
            ],
            [
                'attribute' => 'body',
                'format' => 'html',
                'value' => function ($data) {
                    $value = StringHelper::truncate(strip_tags($data->body), 180, '...');
                    if (!$data->opened) {
                        $value = Html::tag('b', $value);
                    }
                    return $value;
                },
            ],
            [
                'attribute' => 'created',
                'format' => 'html',
                'options' => ['style'=>'width: 240px'],
                'filter' => Html::tag(
                    'div',
                    DateControl::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_from',
                        'type' => DateControl::FORMAT_DATE,
                        'autoWidget' => [
                            'pickerButton' => false,
                        ],
                        'widgetOptions' => [
                            'layout' => '{remove}{input}',
                            'options' => ['placeholder' => Yii::t('app', 'From date')],
                        ],
                    ])
                    . DateControl::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_to',
                        'type' => DateControl::FORMAT_DATE,
                        'autoWidget' => [
                            'pickerButton' => false,
                        ],
                        'widgetOptions' => [
                            'layout' => '{input}{remove}',
                            'options' => ['placeholder' => Yii::t('app', 'To date')],
                        ],
                    ]),
                    ['class' => 'date-range']
                ),
                'value' => function ($data) {
                    $value = $data->created;
                    if (!$data->opened) {
                        $value = Html::tag('b', $value);
                    }
                    return $value;
                },
            ],
            [
                'class' => 'common\components\Column\SetColumn',
                'attribute' => 'opened',
                'filter' => Mail::getOpenStatuses(),
                'cssClasses' => [
                    Mail::OPENED_YES => 'success',
                    Mail::OPENED_NO => 'warning',
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'open' => function ($url, $model) {
                        if ($model->opened) {
                            $options = ['title' => Yii::t('app', 'Mark as Not Read')];
                            $iconClass = 'glyphicon-folder-open';
                        } else {
                            $options = ['title' => Yii::t('app', 'Mark as Read')];
                            $iconClass = 'glyphicon-folder-close';
                        }
                        return Html::a('<span class="glyphicon ' . $iconClass . '"></span>', $url, $options);
                    },
                ],
                'template' => $this->render('@backend/views/layouts/_options', [
                    'options' => [
                        'view' => 'index',
                        'open' => 'update',
                        'delete' => 'delete'
                    ],
                ]),
                'headerOptions' => ['class'=>'skip-export'],
                'contentOptions' => ['class'=>'skip-export'],
            ],
        ],
    ]); ?>

</div>
