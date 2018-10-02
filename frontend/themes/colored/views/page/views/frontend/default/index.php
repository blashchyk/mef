<?php
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="section bg-white">

    <div class="container">

        <div id="page-with-right-sidebar">
            <div class="inner">
                <div class="post-1-col">
                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_item',
                    ]); ?>
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