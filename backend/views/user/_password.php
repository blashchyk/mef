<?php

/* @var common\models\User $model */
/* @var yii\widgets\ActiveForm $form */

?>

<?= $form->field($model, 'password')->passwordInput(); ?>
<?= $form->field($model, 'confirm_password')->passwordInput();
