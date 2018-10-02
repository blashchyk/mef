<?php
use yii\helpers\Html;
use yii\grid\GridView;
use modules\hierarchicalStructure\assets\backend\HsAsset;
use yii\widgets\ActiveForm;
HsAsset::register($this);

/** @var $dataProvider */

$this->title = Yii::t('app', 'Updated files');
?>
<div class="hierarchical-structure-index">
    <div id="response"></div>
    <div class="row list-header">
        <div class="col-md-2">
            <h2><?= Yii::t('app', 'Archiving Files'); ?></h2>
            <div class="export_block">
                <?=Html::a(Yii::t('app', 'Export Files'), ['archiving'], ['class' => 'archiving']);?>
            </div>
            <div class="import_block">
                <?php $form = ActiveForm::begin([
                    'action' => '/admin/hierarchicalStructure/files/archive-download',
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal',
                    ]
                ]); ?>
                <?= Html::submitButton(Yii::t('app', 'Import File'), ['class' => 'archiving_import']) ?>
                <?= Html::label('Import File', 'files-archive', ['class' => 'archiving', 'type' => 'submit']);?>
                <?= $form->field($file, 'archive')->fileInput() ?>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
        <div class="col-md-10">
            <?php $form = ActiveForm::begin([
                'action' => '/admin/hierarchicalStructure/files/replace',
            ]); ?>
            <?=Html::submitButton(Yii::t('app', 'Replace files'), ['class' => 'archiving replace']);?>
        </div>
    </div>


    <div class="row hs-table-list">
        <div class="col-md-12">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'reference_code',
                    'old_file',
                    'new_file',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header'=> Yii::t('app', 'Actions'),
                        'headerOptions' => ['width' => '100'],
                        'contentOptions' => ['class' => 'text-center'],
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, $file) {
                                return Yii::$app->user->can('hierarchicalStructure.files.delete') && $file->new_file ? Html::checkbox($file->id, true) : Html::checkbox($file->id, false);
                            },
                        ],
                    ],
                ],
            ]);
            ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
