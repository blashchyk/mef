<?php
/* @var $this yii\web\View */
use common\widgets\Navigator;
?>

<?php if (count($quotes) > 0) : ?>
    <!-- Client Feedback -->
    <div class="feedback-block">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <?php $first = true; ?>
                        <?php foreach ($quotes as $quote) : ?>
                            <div class="feedback-quote <?= $first ? 'show' : 'hidden' ?>" id="quote-<?= $quote->id ?>">
                                <?php $first = false; ?>
                                <?= Yii::t('app', $quote->description) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <?php $first = true; ?>
                        <?php foreach ($quotes as $quote) : ?>
                            <div class="col-sm-4">
                                <div class="feedback-author <?= $first ? 'active' : false ?>" data-quote="#quote-<?= $quote->id ?>">
                                    <?php $first = false; ?>
                                    <img src="<?= $quote->user->imageThumbnailUrl ?>">
                                    <div class="info">
                                        <h4><?= Yii::t('app', $quote->name) ?></h4>
                                        <p><?= Yii::t('app', $quote->user->getFullName()) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<br />
<hr />

<div class="row">
    <div class="col-lg-3">
        <?= Navigator::widget(['menuCode' => 'info']); ?>
    </div>

    <div class="col-lg-4">
        <h2><?= Yii::t('app', 'About Us') ?></h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
            fugiat nulla pariatur.</p>

        <p><a class="btn btn-default" href="/about"><?= Yii::t('app', 'About Us') ?> &raquo;</a></p>
    </div>

    <div class="col-lg-4">
        <h2><?= Yii::t('app', 'About Us') ?></h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
            fugiat nulla pariatur.</p>

        <p><a class="btn btn-default" href="/blog/index"><?= Yii::t('app', 'Blog') ?> &raquo;</a></p>
    </div>
</div>