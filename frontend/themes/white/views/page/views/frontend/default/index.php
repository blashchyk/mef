<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-blog">

    <div class="col-sm-9">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
        ]); ?>
    </div>

    <div class="col-sm-3 pull-right">
        <!-- Categories -->
        <h1 class="title-block second-child"><?= Yii::t('app', 'Categories') ?></h1>
        <ul class="categories margin-bottom-30">
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
                    <?php if (!empty($post->user)) : ?>
                        <img src="<?= $post->user->imageThumbnailUrl ?>" alt="<?= $post->user->username ?>">
                    <?php endif; ?>
                    <div class="text">
                        <h3><a href="<?= Url::to(['/blog/post', 'slug' => $post->slug]) ?>"><?= $post->link_name ?></a></h3>
                        <?php if (!empty($post->user)) : ?>
                            <?= Yii::t('app', 'by') ?>
                            <a href="<?= Url::to(['/blog/index', 'Page' => ['user_id' => $post->user_id]]) ?>">
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
