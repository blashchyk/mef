<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\helpers\Toolbar;
use modules\i18n\models\Language;

/* @var $this yii\web\View */
/* @var $searchModel modules\i18n\models\TranslationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Translations');
?>
<div class="translation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Yii::$container->set('yii\widgets\ActiveField', ['template' => "{label}\n{input}\n{hint}\n{error}"]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizeStorageKey' => 'translationGrid',
        'panel' => [
            'footer' => Html::tag('div', Toolbar::createButton(Yii::t('app', 'Add Translation')), ['class' => 'pull-left'])
                . Toolbar::paginationSelect($dataProvider),
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Translation')),
            Toolbar::deleteButton(),
            Toolbar::exportButton(),
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions' => ['class'=>'skip-export'],
                'contentOptions' => ['class'=>'skip-export'],
            ],
            [
                'class' => 'yii\grid\SerialColumn',
            ],
            [
                'attribute' => 'language',
                'format' => 'html',
                'filter' => Language::getList(false),
                'value' => function ($data) {
                    return Html::tag('div', '', ['class' => 'flag flag-' . $data->language]);
                },
            ],
            'sourceMessage:ntext',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'translation',
                'pageSummary' => true,
                'format' => 'ntext',
                'editableOptions' => function ($model, $key, $index) {
                    return [
                        'size' => 'lg',
                        'formOptions' => ['action' => ['update-translation']],
                    ];
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => $this->render('@backend/views/layouts/_options', [
                    'options' => [
                        'update' => 'update',
                        'delete' => 'delete'
                    ],
                ]),
                'headerOptions' => ['class'=>'skip-export'],
                'contentOptions' => ['class'=>'skip-export'],
            ],
        ],
    ]); ?>

</div>
