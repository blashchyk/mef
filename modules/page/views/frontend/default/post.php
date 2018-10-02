<?php
use yii\helpers\Url;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9">
            <div class="blog post">
                <div class="blog-desc">
                    <h3 class="blog-title">
                        <a href="<?= Url::to(['/blog/post', 'slug' => $model->slug]) ?>"><?= $model->link_name ?></a>
                    </h3>
                    <hr>
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
                    <p><?= $model->content ?></p>
                </div>
            </div>
        </div>

        <div class="col-sm-3 pull-right">
            <!-- Categories -->
            <h1 class="title-block second-child"><?= Yii::t('app', 'Categories') ?></h1>
            <ul class="categories margin-bottom-30 list-unstyled">
                <li><a href="<?= Url::to(['/blog/index']) ?>"><?= Yii::t('app', 'All Categories') ?></a></li>
                <?php foreach ($categories as $category) : ?>
                    <li><a href="<?= Url::to(['/blog/index', 'slug' => $category->slug]) ?>"><?= $category->name; ?></a></li>
                <?php endforeach; ?>
            </ul>

            <!-- Top authors -->
            <h1 class="title-block second-child"><?= Yii::t('app', 'Top Stories') ?></h1>
            <div class="top-stories">
                <?php foreach ($topPosts as $post) : ?>
                <div class="item">
                    <div class="text">
                        <a href="<?= Url::to(['/blog/post', 'slug' => $post->slug]) ?>"><?= $post->link_name ?></a>
                        <?php if (!empty($post->user)) : ?>
                            <?= Yii::t('app', 'by') ?>
                            <a href="<?= Url::to(['/blog/index', 'PageSearch' => ['user_id' => $post->user_id]]) ?>">
                                <?php if (!empty($post->user->fullName)) : ?>
                                    <?= $post->user->fullName ?>
                                <?php else : ?>
                                    <?= $post->user->username ?>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>