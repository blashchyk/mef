<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use common\widgets\Nested;
use modules\menu\models\MenuItem;

/* @var $this yii\web\View */
/* @var $model modules\menu\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(); ?>

    <?php $details = [
        'template' => '@modules/menu/views/backend/default/_update_link',
        'form' => $form
    ]; ?>

    <?= Tabs::widget([
        'id' => 'menu-tabs',
        'items' => [
            [
                'label' => Yii::t('app', 'Settings'),
                'active' => $model->isNewRecord,
                'options' => ['id' => 'general'],
                'content' => $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'record-name form-control'])
                    . $form->field($model, 'code')->textInput(['maxlength' => true, 'class' => 'record-slug form-control'])
                    . Html::hiddenInput('TreeItems', '', ['id' => 'TreeItems'])
            ],
            [
                'label' => Yii::t('app', 'Items'),
                'active' => !$model->isNewRecord,
                'options' => ['id' => 'items'],
                'content' =>
                    Html::tag('h3', Yii::t('app', 'Item List'), ['class' => 'pull-left'])
                    . $this->render('_options')
                    . $nested = Nested::widget([
                        'items' => $model->rootItems,
                        'details' => $details,
                        'options' => ['class' => 'nested-sortable'],
                        'emptyMessage' => Yii::t('app', 'List does not contain any items.'),
                    ])
            ],
        ],
    ]);?>

    <div class="pull-right">
        <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success', 'id' => 'save-menu']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

    <?= $this->render('_modal', ['model' => $model]) ?>

</div>

<?php
    $nested = new Nested(['details' => $details]);
    $menuItem = new MenuItem();
    $menuItem->loadDefaultValues();
    echo $nested->renderEmpty($menuItem);
?>