<?php
use modules\setting\models\Setting;
use yii\widgets\ListView;
?>

<div class="section bg-white">
    <div class="container">

        <!-- Project Filters -->
        <ul class="nav magnet-iso-filter">
            <li><a href="#" data-filter="*" class="active"><?= Yii::t('app', 'All Work') ?></a></li>
            <?php foreach ($categories as $category) : ?>
                <li><a href="#" data-filter=".<?= $category->slug ?>"><?= $category->name ?></a></li>
            <?php endforeach; ?>
        </ul>
        <!-- /Project Filters -->

        <div class="magnet-iso-content">
            <!-- Project 1 -->
                <?= Listview::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_item'
                ]) ?>
            </div>
        </div>
</div>

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