<!-- Our Team -->
<div class="row">
    <div class="col-sm-12">
        <h1 class="title-lg"><span><?= Yii::t('app', 'Meet Our Team') ?></span></h1>
    </div>
</div> <!-- / .row -->
<div class="row">
    <?php foreach ($users as $user) : ?>
        <div class="col-sm-4">
            <div class="team-member">
                <div class="team-picture shadow-effect">
                    <img class="img-responsive" src="<?= !empty($user->avatar) ? $user->imageUrl : 'images/default-avatar.png' ?>" alt="<?= $user->fullName ?>">
                </div>
                <h5 class="text-center"><?= $user->fullName ?> <span class="text-red">/ <?= $user->email ?></span></h5>
                <p class="text-muted text-center">

                    <?php if (!empty($user->fullAddress)) : ?>
                        <b><?= Yii::t('app', 'Address') ?>:</b>
                        <?= $user->getFullAddress() ?>
                        <br />
                    <?php endif; ?>

                    <?php if (!empty($user->phone)) : ?>
                        <b><?= Yii::t('app', 'Phone') ?>:</b>
                        <?= $user->phone ?>
                        <br />
                    <?php endif; ?>

                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
