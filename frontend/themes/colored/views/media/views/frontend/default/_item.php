<?php

use yii\helpers\Html;

$index = 0;
?>
<div class="item filter-1 <?= !empty($model->parent) ? $model->parent->slug : '' ?>" >
    <div class="inner">
        <?= Html::img($model->imageUrl, ['class' => 'img-responsive', 'alt' => $model->name]) ?>
        <div class="caption">
            <div class="caption-inner">
                <h4 class="name"><?= !empty($model->name) ? $model->name : Yii::t('app', 'Noname') ?></h4>
                <?php if (!empty($model->parent)) : ?>
                    <div class="category"><?= $model->parent->name ?></div>
                <?php endif ?>
                <a href="<?= $model->imageUrl ?>" class="icon-link gallery-link" title="<?= $model->name ?>"><i class="fa fa-search"></i></a>
            </div>
            <div class="helper"></div>
        </div>
    </div>
</div>
<?php $index++; ?>
<?php if ($index % 4 == 0) : ?>
    <div class="clearfix"></div>
<?php endif; ?>