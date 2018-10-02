<?php
use yii\helpers\Url;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="section bg-white">
    <div class="container">

        <div id="page-with-right-sidebar">
            <div class="inner">
                <div class="post">
                    <h3 class="title"><?= $model->link_name ?></h3>
                    <div class="meta">
                        <label><?= Yii::t('app', 'Posted') ?>:</label><?= $model->created ?>
                        <span class="sep">/</span>
                        <a href="<?= Url::to(['/blog/index', 'slug' => $model->parent->slug]) ?>"><?= $model->parent->name ?></a>

                        <span class="sep">&nbsp;&nbsp;&nbsp;&nbsp;</span>

                        <label><?= Yii::t('app', 'Author') ?>:</label>
                        <a href="<?= Url::to(['/blog/index', 'Page' =>['user_id' => $model->user_id]]) ?>"><?= $model->user->fullName ?></a>
                    </div>
                    <div class="body">
                        <?= $model->content ?>
                    </div>
                </div>

            </div>
        </div>

        <?= $this->render('_sidebar', [
            'topPosts' => $topPosts,
            'categories' => $categories,
            'images' => $images
        ]); ?>

    </div>

</div>
