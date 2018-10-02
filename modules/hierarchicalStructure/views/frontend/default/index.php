<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use modules\hierarchicalStructure\assets\backend\HsAsset;
HsAsset::register($this);
use modules\hierarchicalStructure\models\Funds;

$this->title = Yii::t('app', 'Search');
$fieldOptions = [
    'template' => '{label}<div class="col-md-9 col-sm-9">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-md-2 col-sm-3 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];
?>



<div class="search-index">
    <?php $form = ActiveForm::begin(['method' => 'get']); ?>
    <div class="container">
        <div class="row">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn search btn-primary']); ?>
            <?= $form->field($searchModel, 'fullSearch', $fieldOptions)->textInput(); ?>
            <?= $form->field($searchModel, 'fund_id', $fieldOptions)->dropDownList(Funds::getPublicList(), [
                'prompt' => Yii::t('app', 'Choose Fund'),
            ]); ?>
        </div>
    </div>



    <h3><?=Yii::t('app', 'Fields to search for'); ?></h3>
    <div class="container filter">

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($searchModel, 'title')->checkbox(); ?>
                <?= $form->field($searchModel, 'date')->checkbox(); ?>
                <?= $form->field($searchModel, 'final_date')->checkbox(); ?>
                <?= $form->field($searchModel, 'level_description')->checkbox(); ?>
                <?= $form->field($searchModel, 'extent_description')->checkbox(); ?>
                <?= $form->field($searchModel, 'creator')->checkbox(); ?>
                <?= $form->field($searchModel, 'administrative_history')->checkbox(); ?>
                <?= $form->field($searchModel, 'archival_history')->checkbox(); ?>
                <?= $form->field($searchModel, 'trans')->checkbox(); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($searchModel, 'content')->checkbox(); ?>
                <?= $form->field($searchModel, 'information')->checkbox(); ?>
                <?= $form->field($searchModel, 'accruals')->checkbox(); ?>
                <?= $form->field($searchModel, 'arrangement')->checkbox(); ?>
                <?= $form->field($searchModel, 'access')->checkbox(); ?>
                <?= $form->field($searchModel, 'reproduction')->checkbox(); ?>
                <?= $form->field($searchModel, 'language')->checkbox(); ?>
                <?= $form->field($searchModel, 'characteristics')->checkbox(); ?>
                <?= $form->field($searchModel, 'aids')->checkbox(); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($searchModel, 'location_originals')->checkbox(); ?>
                <?= $form->field($searchModel, 'location_copies')->checkbox(); ?>
                <?= $form->field($searchModel, 'related_units')->checkbox(); ?>
                <?= $form->field($searchModel, 'publication_note')->checkbox(); ?>
                <?= $form->field($searchModel, 'note')->checkbox(); ?>
                <?= $form->field($searchModel, 'archivist_note')->checkbox(); ?>
                <?= $form->field($searchModel, 'rules')->checkbox(); ?>
                <?= $form->field($searchModel, 'date_descriptions')->checkbox(); ?>

            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => Yii::t('app', 'All Code'),
            'value' => function($data){
                return Html::a(
                    Html::encode($data->allCode),
                    Url::to(['view', 'fundId' => $data->fond_id, 'id' => $data->node_id, 'fund' => true])
                );
            },
            'format' => 'raw',
        ],
        [
            'attribute' => Yii::t('app', 'Title'),
            'value' => function($data){
                return $data->title;
            },
        ],
        [
            'attribute' => Yii::t('app', 'Level of Description'),
            'value' => function($data){
                return $data->level_description;
            },
        ],
        [
            'attribute' => Yii::t('app', 'Creator'),
            'value' => function($data){
                return $data->creator;
            },
        ],
    ],
]);?>

