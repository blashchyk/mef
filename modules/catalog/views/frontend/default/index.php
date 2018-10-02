<?php

use yii\helpers\Url;
use yii\widgets\ListView;
use common\widgets\Search;

$this->params['breadcrumbs'][] = $this->title;
/** @var Product $productModel */
?>

<div class="row">
    <div class="col-sm-3 pull-right">
        <h1 class="title-block second-child"><?= Yii::t('app', 'Categories') ?></h1>

        <ul class="categories margin-bottom-30">
            <li><a href="<?= Url::to(['/catalog/index']) ?>"><?= Yii::t('app', 'Show All') ?></a></li>
            <?php foreach ($сategories as $category) : ?>
                <li><a href="<?= Url::to(['/catalog/index', 'slug' => $category->slug]) ?>"><?= $category->name ?></a></li>
            <?php endforeach; ?>
        </ul>

        <?php if (count($productModel->getFilters()) > 0) : ?>
            <?= Search::widget([
                'model' => $productModel,
                'selectedCategory' => $selectedCategory,
                'submitButtonClass' => 'btn-primary btn-red'
            ]) ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($selectedCategory)) : ?>
        <p class="text-center text-red lead"><?= $selectedCategory->description ?></p>
    <?php endif; ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'options' => [
            'class' => 'col-sm-9 list-view'
        ]
    ]); ?>
</div>