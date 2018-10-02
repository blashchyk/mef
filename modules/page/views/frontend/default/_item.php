<?php
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>
<div class="blog">
    <div class="blog-desc">
        <h3 class="blog-title">
            <a href="<?= Url::to(['/blog/post', 'slug' => $model->slug]) ?>"><?= $model->link_name ?></a>
        </h3>
        <hr>
        <p class="text-muted">
            <?php if (!empty($model->created_at)) : ?>
                <?= $model->created ?>
            <?php endif; ?>
            <?php if (!empty($model->user)) : ?>
                <?= Yii::t('app', 'by') ?>
                <a href="<?= Url::to(['/blog/index', 'PageSearch' => ['user_id' => $model->user_id]]) ?>">
                    <?php if (!empty($model->user->fullName)) : ?>
                        <?= $model->user->fullName ?>
                    <?php else : ?>
                        <?= $model->user->username ?>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </p>
        <p>
            <?= StringHelper::truncate(strip_tags($model->content), 1024, '...') ?>
        </p>
        <a class="btn btn-primary" href="<?= Url::to(['/blog/post', 'slug' => $model->slug]) ?>"><?= Yii::t('app', 'Read More') ?>...</a>
    </div>
</div>

<br />