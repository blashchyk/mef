<?php
use modules\setting\models\Setting;
?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="block-title"><span><?= Yii::t('app', 'Contact Info') ?></span></h1>
            </div>
        </div>
        <ul class="contact-list-icon list-inline">
            <?php if (Setting::getValue('contact_address')) : ?>
                <li class="col-sm-3">
                    <i class="fa fa-map-marker"></i>
                    <div class="contact-info-content">
                        <div class="title"><?= Yii::t('app', 'Address') ?>:</div>
                        <div class="description"><?= Setting::getValue('contact_address') ?></div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (Setting::getValue('contact_phone')) : ?>
                <li class="col-sm-3">
                    <i class="fa fa-phone"></i>
                    <div class="contact-info-content">
                        <div class="title"><?= Yii::t('app', 'Telephone') ?>:</div>
                        <div class="description"><?= Setting::getValue('contact_phone') ?></div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (Setting::getValue('contact_fax')) : ?>
                <li class="col-sm-3">
                    <i class="fa fa-fax"></i>
                    <div class="contact-info-content">
                        <div class="title"><?= Yii::t('app', 'Fax') ?>:</div>
                        <div class="description"><?= Setting::getValue('contact_fax') ?></div>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (Setting::getValue('contact_twitter')) : ?>
                <li class="col-sm-3">
                    <i class="fa fa-twitter"></i>
                    <div class="contact-info-content">
                        <div class="title">Twitter:</div>
                        <div class="description"><?= Setting::getValue('contact_twitter') ?></div>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<div class="section bg-grey our-team">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="block-title"><?= Yii::t('app', 'Meet Our Team') ?></h1>
            </div>
        </div>
        <p class="text-center">It is convenient to work with us, because we have integrated services. With our help you can order creating a website from scratch, as well as updating and redesigning your current resource. We offer all services, which are connected with site development from planning, designing and making-up to off-site modules and add-ins development.</p>
        <div class="spacer"></div>
        <div class="magnet-iso-content">
            <?php foreach ($users as $user) : ?>
                <div class="col-sm-4 item">
                    <div class="inner">
                        <img src="<?= !empty($user->avatar) ? $user->imageUrl : 'images/default-avatar.png' ?>" alt="<?= $user->fullName ?>" class="img-responsive" />
                        <div class="caption">
                            <div class="caption-inner">
                                <h4 class="name"><?= $user->fullName ?></h4>
                                <div class="category"><?= $user->email ?></div>
                                <a href="<?= $user->getImageUrl() ?>" class="icon-link gallery-link" title="<?= $user->fullName ?>"><i class="fa fa-search"></i></a>
                            </div>
                            <div class="helper"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
