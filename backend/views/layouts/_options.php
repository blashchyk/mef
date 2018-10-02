<?php
$controller = Yii::$app->controller->id;
?>

<span class="nowrap">
    <?php foreach ($options as $templateName => $option) {
        if (Yii::$app->user->can($option)) {
            echo '{' . $templateName . '}';
        }
    } ?>
</span>