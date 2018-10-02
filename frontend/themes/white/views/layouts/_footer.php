<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use common\widgets\Navigator;
use modules\setting\models\Setting;
?>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h1 class="first-child"><?= Yii::t('app', 'Quick Links') ?></h1>
                <?= Navigator::widget([
                    'options' => ['class' => 'links '],
                    'menuCode' => 'quick-links',
                ]); ?>
            </div>
            <div class="col-sm-3">
                <h1><?= Yii::t('app', 'Contact Us') ?></h1>
                <p>
                    <?= Yii::t('app', 'Do not hesitate to {contact_link} if you have any questions or feature requests', [
                        'contact_link' => Html::a(Yii::t('app', 'contact us'), ['/contact']),
                    ]) ?>
                </p>
                <p>
                    <?php if (Setting::getValue('contact_address')) : ?>
                        <?= Setting::getValue('contact_address') ?><br />
                    <?php endif; ?>
                    <?php if (Setting::getValue('contact_phone')) : ?>
                        <?= Yii::t('app', 'Phone') ?>: <?= Setting::getValue('contact_phone') ?><br>
                    <?php endif; ?>
                    <?php if (Setting::getValue('contact_fax')) : ?>
                        <?= Yii::t('app', 'Fax') ?>: <?= Setting::getValue('contact_fax') ?><br>
                    <?php endif; ?>
                    <?php if (Setting::getValue('contact_mail')) : ?>
                        <?= Yii::t('app', 'E-mail') ?>: <a href="mailto::<?= Setting::getValue('contact_mail') ?>"><?= Setting::getValue('contact_mail') ?></a>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-sm-3">
                <?= Html::img($this->theme->getUrl('logo.png'), ['class' => 'footer-brand', 'alt' => 'Logo']) ?>
                <p>
                    <?= Yii::t('app', 'Copyright') ?> <?= date('Y') ?><br />
                    <?php if (Setting::getValue('contact_address')) : ?>
                        <?= Yii::t('app', 'Created by') ?> <a href="<?= Setting::getValue('contact_site') ?>" rel="external" target="_blank">IT-Master</a>
                    <?php endif; ?>
                </p>
                <p><?= Yii::t('app', 'All Rights Reserved') ?>.</p>
                <ul class="social-links">
                    <li class="twitter"><a href="<?= Setting::getValue('contact_twitter') ?>"><i class="fa fa-twitter"></i></a></li>
                    <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
            <div class="col-sm-3">
                <h1><?= Yii::t('app', 'Content Rubrics') ?></h1>
                <?= Navigator::widget([
                    'options' => ['class' => 'links '],
                    'menuCode' => 'content-links',
                ]); ?>
            </div>

        </div> <!-- / .row -->
    </div> <!-- / .container -->
</footer>