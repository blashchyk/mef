<?php
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>
<div class="col-sm-4 col-md-4">
    <div class="post-grid" data-sr='scale up 30%'>
        <div class="image">
            <img src="<?= $model->getImageThumbnailUrl() ?>" alt="<?= $model->name ?>" class="img-responsive" />
            <div class="caption">
                <div class="caption-inner">
                    <a href="<?= Url::to(['/catalog/product', 'slug' => $model->slug], ['class' => 'icon-link white']) ?>"><i class="fa fa-link"></i></a>
                </div>
                <div class="helper"></div>
            </div>
        </div>
        <h4 class="title"><a href="<?= Url::to(['/catalog/product', 'slug' => $model->slug]) ?>"><?= $model->name ?></a></h4>
        <div class="body"><?= StringHelper::truncate(strip_tags($model->description), 240, '...') ?></div>
        <div class="meta">
            <label><?= Yii::t('app', 'Added') ?>: <a href="<?= Url::to(['/catalog/product', 'slug' => $model->slug]) ?>"><?= $model->created ?></a></label><br/>
            <?php if (!empty($model->parent)) : ?>
                <label><?= Yii::t('app', 'Category') ?>: <a href="<?= Url::to(['/catalog/index', 'slug' => $model->parent->slug]) ?>"><?= $model->parent->name ?></a></label><br/>
            <?php endif; ?>
            <?php if (!empty($model->price)) : ?>
                <label><?= Yii::t('app', 'Price') ?>: $<?= $model->price ?></label>
            <?php endif; ?>
        </div>
        <div class="meta-btn">
            <a class="btn btn-primary-magnet btn-orange-magnet" href="<?= Url::to(['/catalog/product', 'slug' => $model->slug]) ?>"><?= Yii::t('app', 'Read More') ?></a>
            <a class="btn btn-primary-magnet btn-orange-magnet" href="<?= Url::to(['/order/default/add', 'id' => $model->id]) ?>"><?= Yii::t('app', 'Buy Now') ?></a>
        </div>
    </div>
</div>

<?php if (($index + 1) % 3 == 0) : ?>
    <div class="clearfix"></div>
<?php endif; ?>