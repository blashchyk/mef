<?php
/* @var common\models\User $model */
/* @var yii\widgets\ActiveForm $form */
?>

<?= $form->field($model, 'access_token')->textInput(['readonly' => true]); ?>