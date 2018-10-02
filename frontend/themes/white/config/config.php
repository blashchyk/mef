<?php
\Yii::$container->set('yii\widgets\ActiveForm', ['options' => ['class' => 'form-horizontal']]);
\Yii::$container->set('yii\widgets\ActiveField', [
    'template' => '{label}<div class="col-md-10 col-sm-10">{input}{hint}{error}</div>', // "{label}\n{input}\n{hint}\n{error}"
    'labelOptions' => ['class' => 'control-label col-sm-2 col-md-2 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
]);
