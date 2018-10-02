<?php
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>
<div class="blog">
    <?php if (!empty($model->user)) : ?>
        <img src="<?= $model->user->imageThumbnailUrl ?>" alt="<?= $model->user->username ?>">
    <?php endif; ?>
    <div class="blog-desc">
        <h3 class="blog-title">
            <a href="<?= Url::to(['/blog/post', 'slug' => $model->slug]) ?>"><?= $model->link_name ?></a>
        </h3>
        <hr>
        <p class="text-muted">
            <?php if (!empty($model->user)) : ?>
                <?= Yii::t('app', 'by') ?>
                <a href="<?= Url::to(['/blog/index', 'Page' => ['user_id' => $model->user_id]]) ?>">
                    <?php if (!empty($model->user->fullName)) : ?>
                        <?= $model->user->fullName ?>
                    <?php else : ?>
                        <?= $model->user->username ?>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            <?php if (!empty($model->created_at)) : ?>
                <?= Yii::t('app', 'on') ?>
                <?= $model->created ?></p>
            <?php endif; ?>
        </p>
        <p>
            <?= StringHelper::truncate(strip_tags($model->content), 360, '...') ?>
        </p>
        <a class="btn btn-lg btn-red" href="<?= Url::to(['/blog/post', 'slug' => $model->slug]) ?>"><?= Yii::t('app', 'Read More') ?>...</a>
    </div>
</div>

<br />