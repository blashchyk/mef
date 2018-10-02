<?php
use modules\slider\models\Slider;
use yii\helpers\Url;

$sliderModel = new Slider();
$slider = $sliderModel ->getVisibleItems($this->params['theme']->id);
?>
<div class="section section_slideshow">
    <div id="bootstrap-carousel-animated" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php $first = true; ?>
            <?php foreach ($slider as $slide) : ?>
                <div class="item <?= $first ? 'active' : false ?>" style="background:url(<?= $slide->getImageUrl() ?>)">
                    <?php $first = false; ?>
                    <?php if ($slide->type && $slide->video_url) : ?>
                        <video id="bgVideo" autoplay loop poster="image.png" class="full-width">
                            <source src="<?= $slide->video_url ?>">
                        </video>
                    <?php endif; ?>
                    <div class="carousel-caption <?= $slide->getPositionName('lower') ?> white">
                        <div class="container">
                            <div class="inner">
                                <h1 data-animation="animated bounceInLeft"><?= Yii::t('app', $slide->name) ?></h1>
                                <p data-animation="animated bounceInRight"><?= Yii::t('app', $slide->description) ?></p>
                                <?php if ($slide->button_caption) : ?>
                                    <p data-animation="animated bounceInUp"><a class="btn btn-primary-magnet" href="<?= Url::base(true) . $slide->forward_url?>" role="button"><?= Yii::t('app', $slide->button_caption) ?></a></p>
                                <?php endif; ?>
                            </div>
                            <div class="helper"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a class="left carousel-control" href="#bootstrap-carousel-animated" data-slide="prev"><span class="ic ic-angle-left-white" style="background-image:url(<?= $this->theme->getUrl('ico_arrow_lr_white.png') ?>)"></span></a>
        <a class="right carousel-control" href="#bootstrap-carousel-animated" data-slide="next"><span class="ic ic-angle-right-white" style="background-image:url(<?= $this->theme->getUrl('ico_arrow_lr_white.png') ?>)"></span></a>
    </div>
</div>