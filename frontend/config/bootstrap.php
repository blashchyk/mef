<?php
\Yii::$container->set('yii\widgets\ListView', [
    'layout' => "{items}<div class='clean'></div>\n{pager}", // "{summary}\n{items}\n{pager}"
]);
\Yii::$container->set('yii\widgets\LinkPager', [
    'options' => ['class' => 'pagination pull-right']
]);
\Yii::$container->set('kartik\file\FileInput', [
    'options' => [
        'accept' => 'image/*',
    ],
    'pluginEvents' => [
        'fileclear' => 'function() { ImageHelper.clearInputName(); }',
    ],
]);
