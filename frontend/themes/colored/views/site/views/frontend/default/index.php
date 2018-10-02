<?php
/* @var $this yii\web\View */
use modules\setting\models\Setting;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

?>
<div class="section bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="content-contact">
                    <div class="icon"><i class="ic ic-phone" style="background-image:url(<?= $this->theme->getUrl('ico_phone.png') ?>)"></i></div>
                    <div class="key"><?= Yii::t('app', 'Have a question? Call us now') ?></div>
                    <div class="val"><?= Setting::getValue('contact_phone') ?></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="content-contact">
                    <div class="icon"><i class="ic ic-clock" style="background-image:url(<?= $this->theme->getUrl('ico_clock.png') ?>)"></i></div>
                    <div class="key"><?= Yii::t('app', 'We are open Mon - Fri') ?></div>
                    <div class="val">09:00 am to 6:00 pm</div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="content-contact">
                    <div class="icon"><i class="ic ic-envelope" style="background-image:url(<?= $this->theme->getUrl('ico_envelope.png') ?>)"></i></div>
                    <div class="key"><?= Yii::t('app', 'Need Help? Drop us an email') ?></div>
                    <div class="val"><a href="<?= Setting::getValue('contact_mail') ?>"><?= Setting::getValue('contact_mail') ?></a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="line-envelope shadow"></div>

<?php if (count($blog) > 0) : ?>
    <div class="section bg-white">
        <div class="container">
            <h2 class="block-title"  data-sr="roll -45deg"><?= Yii::t('app', 'Latest Posts') ?></h2>
            <?php foreach ($blog as $post) : ?>
                <div class="col-sm-6 col-md-3" data-sr="scale up 30%">
                    <?php if (!empty($post->user)) : ?>
                        <div class="content-icon">
                            <div class="icon">
                                <img src="<?= $post->user->getImageThumbnailUrl() ?>" alt="<?= $post->user->username ?>"/>
                            </div>
                            <h4 class="title"><?= $post->link_name ?></h4>
                            <div class="body">
                                <p>
                                    <?= StringHelper::truncate(strip_tags($post->content), 240, '...') ?>
                                </p>
                            </div>
                            <div class="foot">
                                <a class="btn btn-inverse" href="<?= Url::to(['/blog/post', 'slug' => $post->slug]) ?>"><?= Yii::t('app', 'Read More') ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php if (count($gallery) > 0) : ?>
    <div class="section bg-primary">
        <div class="container">
            <h2 class="block-title" data-sr="roll -45deg"><?= Yii::t('app', 'Latest Projects') ?></h2>
            <ul class="nav magnet-iso-filter" data-sr="wait 0.1s">
                <li><a href="#" data-filter="*" class="active"><?= Yii::t('app', 'All Work') ?></a></li>
                <?php foreach ($galleryCategory as $imageCategory) : ?>
                    <li><a href="#" data-filter=".<?= $imageCategory->slug ?>"><?= $imageCategory->name ?></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="magnet-iso-content">
                <?php foreach ($gallery as $image) : ?>
                    <div class="item <?= $image->parent->slug ?>">
                        <div class="inner" data-sr="scale up 30%">
                            <?= Html::img($image->imageUrl, ['class' => 'img-responsive']) ?><br/>
                            <div class="caption">
                                <div class="caption-inner">
                                    <h4 class="name"><?= $image->name ?></h4>
                                    <div class="category"><?= $image->parent->name ?></div>
                                    <a href="<?= $image->imageUrl ?>" class="icon-link gallery-link" title="<?= $image->name ?>"><i class="fa fa-search"></i></a>
                                </div>
                                <div class="helper"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (count($quotes) > 0) : ?>
    <div class="section bg-dark">
        <div class="container">
            <h2 class="block-title " data-sr='spin 180deg over 1s'>What our clients say about us</h2>
            <div class="row">
                <div class="col-md-12">
                    <!-- Testimonials Carousel -->
                    <div id="testimonial-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $first = true; ?>
                            <?php foreach ($quotes as $quote) : ?>
                                <div class="item <?= $first ? 'active' : false ?>">
                                    <?php $first = false; ?>
                                    <div class="magnet-testimonial">
                                        <?php if (!empty($quote->user)) : ?>
                                            <div class="image"><img class="quote-avatar" src="<?= $quote->user->getImageUrl(true) ?>"/></div>
                                        <?php endif; ?>
                                        <div class="details">
                                            <?php if (!empty($quote->user)) : ?>
                                                <h5 class="company"><?= Yii::t('app', $quote->user->getFullName()) ?></h5>
                                            <?php endif; ?>
                                            <h3 class="name"><?= Yii::t('app', $quote->name) ?></h3>
                                            <div class="text"><?= Yii::t('app', $quote->description) ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="magnet-control-block">
                            <a class="magnet-control-left" href="#testimonial-carousel" data-slide="prev"><span class="ic ic-angle-left"></span></a>
                            <a class="magnet-control-right" href="#testimonial-carousel" data-slide="next"><span class="ic ic-angle-right"></span></a>
                        </div>
                    </div>
                    <!-- /Testimonials Carousel -->
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (count($products) > 0) : ?>
    <div class="section bg-white">
        <div class="container">
            <h2 class="block-title" data-sr="roll -45deg"><?= Yii::t('app', 'Popular Products') ?></h2>
            <?php foreach ($products as $product) : ?>
                <div class="col-sm-4">
                    <div class="post-grid" data-sr="scale up 30%">
                        <div class="image">
                            <img src="<?= $product->imageUrl ?>" alt="<?= $product->name ?>" class="img-responsive" />
                            <div class="caption">
                                <div class="caption-inner">
                                    <a href="<?= Url::to(['/catalog/product', 'slug' => $product->slug], ['class' => 'icon-link white']) ?>"><i class="fa fa-link"></i></a>
                                </div>
                                <div class="helper"></div>
                            </div>
                        </div>
                        <h4 class="title"><a href="<?= Url::to(['/catalog/product', 'slug' => $product->slug]) ?>"><?= $product->name ?></a></h4>
                        <div class="body"><?= StringHelper::truncate(strip_tags($product->description), 360, '...') ?></div>
                        <div class="meta">
                            <label><?= Yii::t('app', 'Posted') ?>:</label> <a href="<?= Url::to(['/catalog/product', 'slug' => $product->slug]) ?>"><?= $product->created ?></a>
                            <span class="sep">/</span>
                            <a href="<?= Url::to(['/catalog/index', 'slug' => $product->parent->slug]) ?>"><?= $product->parent->name ?></a>
                        </div>
                        <div class="meta-btn">
                            <a class="btn btn-primary-magnet" href="<?= Url::to(['/catalog/product', 'slug' => $product->slug]) ?>"><?= Yii::t('app', 'Read More') ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>