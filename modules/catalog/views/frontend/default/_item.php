<?php
use yii\helpers\Url;
?>

<div class="catalog">
    <div class="col-sm-3">
        <a href="<?= Url::to(['/catalog/product', 'slug' => $model->slug]) ?>">
            <div class="img">
                <img class="img-responsive" src="<?= $model->imageThumbnailUrl ?>" alt="<?= !empty($model->user) ? $model->user->username : '' ?>" />
            </div>
        </a>
        <div class="info">
            <h5><?= Yii::t('app', 'Title')?> : <?= $model->name ?></h5>
            <p class="text-muted"><?= Yii::t('app', 'Price')?>: <?= Yii::$app->formatter->asCurrency($model->price) ?></p>
            <p class="text-muted"><?= Yii::t('app', 'Category') ?>: <?= !empty($model->parent) ? $model->parent->name : '' ?></p>
            <p class="text-muted"><?= Yii::t('app', 'Owner') ?>: <?= !empty($model->user) ? $model->user->username : '' ?></p>
        </div>
    </div>
</div>
<?php if (($index + 1) % 4 == 0) : ?>
    <div class="clearfix"></div>
<?php endif; ?>