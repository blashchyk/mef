<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use common\widgets\Search;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="section bg-white">
        <div class="container">
            <div class="col-sm-3 sidebar-right pull-right">
                <h3 class="widget-title"><?= Yii::t('app', 'Categories') ?></h3>
                <ul class="categories widget-nav widget-nav-category">
                    <li><a href="<?= Url::to(['/catalog/index']) ?>"><?= Yii::t('app', 'Show All') ?></a></li>
                    <?php foreach ($сategories as $category) : ?>
                        <li><a href="<?= Url::to(['/catalog/index', 'slug' => $category->slug]) ?>"><?= $category->name ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <?php if (count($productModel->getFilters()) > 0) : ?>
                    <?= Search::widget([
                        'model' => $productModel,
                        'selectedCategory' => $selectedCategory,
                        'submitButtonClass' => 'btn-primary-magnet btn-orange-magnet'
                    ]) ?>
                <?php endif; ?>
            </div>
            <div class="col-sm-9">
                <?php if ($selectedCategory == '') : ?>
                    <h2 class="block-title" data-sr="roll -45deg"><?= Yii::t('app', 'Products') ?></h2>
                <?php else : ?>
                    <h2 class="block-title" data-sr="roll -45deg"><?= $selectedCategory->name ?></h2>
                <?php endif; ?>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_item',
                    'options' => [
                        'class' => 'list-view'
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>