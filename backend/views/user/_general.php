<?php

/* @var yii\web\View $this */
/* @var common\models\User $model */
/* @var yii\widgets\ActiveForm $form */
?>
<?= $this->render('_avatar', ['form' => $form, 'model' => $model]) ?>

<?= $form->field($model, 'username')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]);
