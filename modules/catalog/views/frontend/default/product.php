<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="portfolio-slideshow">
                <!-- Image Carousel -->
                <div class="item">
                  <img class="img-responsive product-image" src="<?= $model->getImageUrl() ?>" alt="<?= $model->name ?>">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <h1 class="title-block second-child"><?= $model->name ?></h1>
            <p><?= $model->description ?></p>
            <br />
            <h1 class="title-block first-child"><?= Yii::t('app', 'Product Info') ?></h1>
            <?php
            $detailFields = [
                [
                    'label' => Yii::t('app', 'Name') . ':',
                    'attribute' => 'name',
                ],
                [
                    'label' => Yii::t('app', 'Owner') . ':',
                    'attribute' => 'user.fullName',
                    'visible' => !empty($model->user->fullName),
                ],
                [
                    'label' => Yii::t('app', 'Price') . ':',
                    'format' => 'currency',
                    'attribute' => 'price',
                ],
            ];
            foreach ($model->additionalFields as $key => $field) {
                if (!empty($field->value)) {
                    $detailFields[] = [
                        'label' => Yii::t('app', $field->field->name) . ':',
                        'value' => $field->value,
                    ];
                }
            }
            $detailFields = array_merge($detailFields, [
                [
                    'label' => Yii::t('app', 'Category') . ':',
                    'attribute' => 'parent.name',
                    'visible' => !empty($model->parent->name),
                ],
                [
                    'label' => Yii::t('app', 'Added') . ':',
                    'attribute' => 'created',
                ],
            ]);
            ?>
            <?= DetailView::widget([
                'model' => $model,
                'options' => [
                    'class' => 'table'
                ],
                'attributes' => $detailFields,
            ]); ?>
            <?= Html::a(Yii::t('app', 'Buy Now'), ['/order/default/add', 'id' => $model->id], ['class' => 'btn btn-primary btn-red']) ?>
        </div>
    </div> <!-- / .row -->
    <div class="row">
        <div class="col-sm-12">
            <h1 class="title-block"><?= Yii::t('app', 'Latest Items') ?></h1>
            <hr class="title-hr" />
        </div>
        <?php foreach ($topImages as $topImage) : ?>
            <div class="col-sm-3">
                <div class="portfolio-item"><a href="<?= Url::to(['/catalog/product', 'slug' => $topImage->slug]) ?>">
                    <div class="img">
                        <img class="img-responsive latest-image" src="<?= $topImage->getImageUrl() ?>" alt="<?= !empty($topImage->user) ? $topImage->user->username : null ?>">
                    </div>
                    <div class="info">
                        <h4><?= $topImage->name ?></h4>
                        <p class="text-muted"><?= Yii::t('app', 'Price') ?>: <?= Yii::$app->formatter->asCurrency($topImage->price) ?></p>
                    </div></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div> <!-- / .row -->
</div> <!-- / .container -->