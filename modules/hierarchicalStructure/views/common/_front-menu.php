<?php
use yii\helpers\Html;

/* @var $hsList array*/
?>
<div class="hs-menu-wrap">
    <ul>
    <?php foreach ($hsList as $id => $name) : ?>
        <li class="hs-item">
            <?= Html::a(Html::encode($name),
                [ '/', 'hsId' => $id ], ['class' => 'hs-link']); ?>
        </li>
    <?php endforeach; ?>
    </ul>
</div>