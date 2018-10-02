<?php

use yii\helpers\Html;

$index = 0; ?>
<div class="col-sm-4 col-md-3 isotope-item <?= !empty($model->parent) ? $model->parent->slug : '' ?>">
    <div class="portfolio-item">
        <div class="img">
            <a href="<?=$model->imageUrl;?>" class="gallery-link">
                <?= Html::img($model->imageUrl, ['class' => 'img-responsive img-thumbnail img-gallery', 'alt' => $model->name, 'style' => 'max-height: 400px']) ?><br />
            </a>
        </div>
        <div class="info">
            <h4>
                <?= !empty($model->name) ? $model->name : Yii::t('app', 'Noname') ?>
            </h4>
            <?php if (!empty($model->parent)) : ?>
                <p class="text-muted"><?= $model->parent->name ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $index++; ?>
<?php if ($index % 4 == 0) : ?>
    <div class="clearfix"></div>
<?php endif; ?>
