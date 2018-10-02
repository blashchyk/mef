<?php

use common\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\setting\models\Setting;
use common\helpers\Toolbar;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Settings');

$fieldOptions = [
    'template' => '{label}<div class="col-md-12 col-sm-12">{input}{hint}{error}</div>',
];
?>
<div class="setting-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Alert::widget() ?>

    <div class='panel panel-default panel-custom'>
        <div class="panel-heading">
            <div class="btn-toolbar pull-left">
                <?= Toolbar::refreshButton()
                    . Toolbar::createButton(Yii::t('app', 'Add Setting'))
                ?>
            </div>
            <div class="pull-right">
                <div class="summary">
                    <b>1-<?= count($models) ?></b> <?= Yii::t('app', 'of') ?> <b><?= count($models) ?></b> &nbsp;
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="setting-form col-lg-10 alert alert-info">
        <?php $form = ActiveForm::begin(); ?>
        <?php foreach (Setting::getTypes() as $type => $caption) : ?>
            <div class="panel panel-default">
                <div class="panel-heading"><b><?= Yii::t('app', 'Type') ?>: <?= $caption ?></b></div>
                <div class="panel-body">
                    <div class="col-md-3">
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <b><?= Yii::t('app', 'Key') ?></b>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <b><?= Yii::t('app', 'Value') ?></b>
                    </div>
                    <hr>
                    <?php foreach ($models as $index => $model) : ?>
                        <?php if ($model->type == $type) : ?>
                            <div class="row">
                                <div class="col-sm-4 col-md-3">
                                    <b><?= Yii::t('app', $model->title) ?></b>
                                </div>
                                <div class="clearfix visible-sm"></div>
                                <div class="col-sm-5 col-md-3">
                                    <?= $form->field($model, "[$index]key", $fieldOptions)->label(false)->textInput(['maxlength' => true, 'disabled' => $model->type == Setting::TYPE_SYSTEM, 'class' => 'record-slug form-control']) ?>
                                </div>
                                <div class="col-sm-6 col-md-5">
                                    <?php $field = $form->field($model, "[$index]value", $fieldOptions)->label(false); ?>
                                    <?php if (in_array($model->value_type, [Setting::TYPE_INTEGER, Setting::TYPE_STRING, Setting::TYPE_EMAIL])) : ?>
                                        <?= $field->textInput(['maxlength' => true]) ?>
                                    <?php elseif ($model->value_type == Setting::TYPE_TEXT) : ?>
                                        <?= $field->textarea(['rows' => 4]) ?>
                                    <?php elseif ($model->value_type == Setting::TYPE_BOOLEAN) : ?>
                                        <?= $field->dropDownList(Setting::getBooleanTypes()) ?>
                                    <?php endif; ?>
                                </div>
                                <div class="nowrap col-md-1">
                                    <?php
                                    $options = [
                                        'title' => Yii::t('yii', 'Update'),
                                        'aria-label' => Yii::t('yii', 'Update'),
                                        'data-pjax' => '0',
                                    ];
                                    $action = 'update';
                                    echo Html::a('<span class="glyphicon glyphicon-pencil"></span>', [$action, 'id' => $model->id], $options);
                                    $action = 'delete';
                                    if ($type != Setting::TYPE_SYSTEM) {
                                        $options = [
                                            'title' => Yii::t('yii', 'Delete'),
                                            'aria-label' => Yii::t('yii', 'Delete'),
                                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'data-method' => 'post',
                                            'data-pjax' => '0',
                                        ];
                                        echo Html::a('<span class="glyphicon glyphicon-trash"></span>', [$action, 'id' => $model->id], $options);
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="pull-right">
            <?= Html::resetButton(Yii::t('app', 'Cancel'), ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="clearfix"></div>
    </div>

</div>