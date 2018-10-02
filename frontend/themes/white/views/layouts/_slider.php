<?php
use yii\helpers\Html;
use modules\slider\models\frontend\Slider;

$sliderModel = new Slider();
$slider = $sliderModel ->getVisibleItems($this->params['theme']->id);
?>
<div class="home-slider">
    <div id="home-slider" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php $first = true; ?>
            <?php foreach ($slider as $slide) : ?>
                <div class="item <?= $first ? 'active' : false ?>">
                    <?php $first = false; ?>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="fully-responsive">
                                    <h3 class="fully-responsive__title animated slideInDown g-delay_1"><?= Yii::t('app', $slide->name) ?></h3>
                                    <div class="fully-responsive__text animated slideInDown g-delay_2">
                                    </div>
                                    <p class="animated fadeInUp g-delay_3">
                                        <?= Yii::t('app', $slide->description) ?>
                                    </p>
                                    <div class="fully-responsive__btns">
                                        <?php if ($slide->button_caption) : ?>
                                            <a class="btn btn-lg btn-red fully-responsive-btns__btn animated fadeInUpBig g-delay_4" href="<?= $slide->forward_url ?>"><?= Yii::t('app', $slide->button_caption) ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-img hidden-xs" >
                        <?php if ($slide->type && $slide->video_url) : ?>
                            <video id="bgVideo" autoplay loop class="full-height">
                                <source src="<?= $slide->video_url ?>">
                            </video>
                        <?php else : ?>
                        <?= Html::img($slide->getImageUrl(), ['alt' => $slide->name]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="carousel-arrow carousel-arrow-prev" href="#home-slider" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="carousel-arrow carousel-arrow-next" href="#home-slider" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>