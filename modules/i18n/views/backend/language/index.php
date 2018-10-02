<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use common\helpers\Toolbar;
use modules\i18n\models\Language;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Languages');
?>
<div class="language-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'resizeStorageKey' => 'languageGrid',
        'panel' => [
            'footer' => Toolbar::createButton(Yii::t('app', 'Add Language'))
        ],
        'toolbar' => [
            Toolbar::toggleButton($dataProvider),
            Toolbar::refreshButton(),
            Toolbar::createButton(Yii::t('app', 'Add Language')),
            Toolbar::deleteButton(),
            Toolbar::showSelect(),
        ],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
            ],
            'id',
            [
                'attribute' => 'language',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::tag('div', '', ['class' => 'flag flag-' . $data->language]);
                },
            ],
            'name:ntext',
            [
                'class' => 'common\components\Column\SetColumn',
                'attribute' => 'visible',
                'filter' => Language::getVisibilityStatuses(),
                'cssClasses' => [
                    Language::VISIBLE_YES => 'success',
                    Language::VISIBLE_NO => 'danger',
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'translations' => function ($url, $model) {
                        if ($model->language == Language::DEFAULT_LANGUAGE) {
                            return null;
                        }
                        $expandButton = Html::tag('span', '', ['class' => 'glyphicon glyphicon-list']);
                        return Html::a($expandButton, Url::to(['/i18n', 'TranslationSearch' => ['language' => $model->language]]), [
                            'title' => Yii::t('app', 'Translations'),
                            'aria-label' => Yii::t('app', 'Translations'),
                        ]);
                    },
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
                        'translations' => 'index',
                        'delete' => 'delete'
                    ],
                ]),
            ],
        ],
    ]); ?>

</div>
