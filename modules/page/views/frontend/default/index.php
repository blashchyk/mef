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
        <ul class="categories margin-bottom-30 list-unstyled">
            <li><a href="<?= Url::to(['/blog/index']) ?>"><?= Yii::t('app', 'All Categories') ?></a></li>
            <?php foreach ($categories as $category) : ?>
                <li><a href="<?= Url::to(['/blog/index', 'slug' => $category->slug]) ?>"><?= $category->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <!-- Top authors -->
        <h1 class="title-block second-child"><?= Yii::t('app', 'Top Stories') ?></h1>
        <ol class="top-stories list-unstyled">
            <?php foreach ($topPosts as $post) : ?>
                <li class="item">
                    <div class="text">
                       <a href="<?= Url::to(['/blog/post', 'slug' => $post->slug]) ?>"><?= $post->link_name ?>111</a>
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
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

</div>
