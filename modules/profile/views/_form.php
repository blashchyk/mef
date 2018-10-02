<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use modules\profile\models\Profile;
use modules\country\models\Country;

/* @var $this yii\web\View */
/* @var $model modules\user\models\Profile */
/* @var $form yii\widgets\ActiveForm */

$userAgeLimit  = 100;
$datePickerRange = (date('Y') - $userAgeLimit) . ':' . date('Y');
?>

<div class="user-form col-lg-8 alert alert-info">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal']]); ?>

        <?= $form->field($model, 'country_id')->dropdownList(Country::getList(), ['prompt'=>'']) ?>

        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'zip')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'birthday', ['options' => ['class' => 'hidden']])->textInput(['value' => !empty($model->birthday) ? date('Y-m-d', $model->birthday) : null]) ?>

        <?= $form->field($model, 'birthday')->widget(DatePicker::classname(), [
                                'clientOptions' => ['changeMonth' => true, 'changeYear' => true, 'yearRange' => $datePickerRange, 'altFormat' => 'yy-mm-dd', 'altField' => '#profile-birthday'],
                                'options' => ['class' => 'form-control', 'readonly' => true, 'id' => 'date-picker', 'name' => 'date-picker']
                            ]) ?>

        <?= $form->field($model, 'gender')->dropdownList(Profile::getGenders()) ?>


        <div class="pull-right">
            <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>

</div>