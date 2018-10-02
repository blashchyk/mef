<?php
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>
<div id="sidebar-right">

    <div class="widget">
        <h4 class="widget-title"><?= Yii::t('app', 'Blog categories') ?></h4>
        <div class="widget-body">
            <ul class="widget-nav widget-nav-category">
                <li><a href="<?= Url::to(['/blog/index']) ?>"><?= Yii::t('app', 'All Categories') ?></a></li>
                <?php foreach ($categories as $category) : ?>
                    <li><a href="<?= Url::to(['/blog/index', 'slug' => $category->slug]) ?>"><?= $category->name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="widget">
        <h4 class="widget-title"><?= Yii::t('app', 'latest posts') ?></h4>
        <div class="widget-body">
            <div class="widget-popular-post">
                <?php foreach ($topPosts as $post) : ?>
                    <h5 class="title"><a href="<?= Url::to(['/blog/post', 'slug' => $post->slug]) ?>"><?= $post->link_name ?></a></h5>
                    <div class="body"><?= StringHelper::truncate(strip_tags($post->content), 240, '...') ?></div>
                    <div class="meta-btn">
                        <a href="<?= Url::to(['/blog/post', 'slug' => $post->slug]) ?>"><?= Yii::t('app', 'Read More') ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="widget">
        <h4 class="widget-title no-line"><?= Yii::t('app', 'photo stream') ?></h4>
        <div class="widget-body">
            <ul class="widget-photo-stream">
                <?php foreach ($images as $image) : ?>
                    <li>
                        <a href="<?= Url::to(['/gallery/index']) ?>">
                            <?= Html::img($image->imageUrl, ['alt' => $image->name])?><br/>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>