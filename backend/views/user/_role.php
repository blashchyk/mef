<?php

use yii\helpers\ArrayHelper;
use common\models\User;

/* @var common\models\User $model */
/* @var yii\widgets\ActiveForm $form */

?>

<?= $form->field($model, 'roleName')
    ->dropdownList(
        ArrayHelper::map(User::getListRoles(), 'name', 'name'),
        $model->isNewRecord ? ['options' => [User::DEFAULT_ROLE => ['Selected' => 'selected']]] : []
    );
