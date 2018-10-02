<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>
<div class="post-grid">
    <h3 class="title"><a href="<?= Url::to(['/blog/post', 'slug' => $model->slug]) ?>"><?= $model->link_name ?></a></h3>
    <div class="image" id="post_image">
        <?php if (!empty($model->user)) : ?>
            <a href="<?= Url::to(['/blog/post', 'slug' => $model->slug]) ?>">
                <?= Html::img($model->user->getImageThumbnailUrl(), ['alt' => $model->user->username]) ?>
            </a>
        <?php endif; ?>
    </div>
    <div class="body">
        <?= StringHelper::truncate(strip_tags($model->content), 360, '....') ?>
    </div>
    <div class="meta">
        <label><?= Yii::t('app', 'Posted') ?>:</label>
        <a href="<?= Url::to(['/blog/post', 'slug' => $model->slug]) ?>"><?= $model->created ?></a>
        <span class="sep">/</span>
        <a href="<?= Url::to(['/blog/index', 'slug' => $model->parent->slug]) ?>"><?= $model->parent->name ?></a>
    </div>
    <div class="meta-btn">
        <a href="<?= Url::to(['/blog/post', 'slug' => $model->slug]) ?>" class="btn btn-primary-magnet"><?= Yii::t('app', 'read more') ?></a>
    </div>
</div>

<br />