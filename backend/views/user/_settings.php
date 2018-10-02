<?php

use common\models\User;

/* @var common\models\User $model */
/* @var yii\widgets\ActiveForm $form */

?>

<?= $form->field($model, 'verified')->dropdownList(User::getVerifyStatuses()); ?>
<?= $form->field($model, 'active')->dropdownList(User::getActiveStatuses()); ?>
<?= (!$model->isNewRecord ?
    $form->field($model, 'created')->textInput(['disabled' => true]) .
    $form->field($model, 'updated')->textInput(['disabled' => true]) .
    $form->field($model, 'lastLogin')->textInput(['disabled' => true])
    : '');
