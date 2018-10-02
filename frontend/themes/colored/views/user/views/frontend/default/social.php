<?php
use common\widgets\SocialChoice;
?>

<div class="section bg-white">

    <div class="container">

        <h2 class="block-title"><?= Yii::t('app', 'Add social links') ?></h2>

        <div class="panel-body">

            <?= SocialChoice::widget([
                'baseAuthUrl' => ['/user/auth'],
                'popupMode' => false,
                'isAccountOwner' => true,
                'auths' => $model->auths,
                'tableOptions' => ['class' => 'table table-striped'],
                'addButtonTitle' => Yii::t('app', 'Link a new Social Account'),
            ]) ?>

        </div>

    </div>

</div>