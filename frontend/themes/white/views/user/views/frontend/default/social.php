<?php
use common\widgets\SocialChoice;
?>

<div class="site-signup">

    <div class="col-lg-10 col-lg-offset-1 panel panel-default">

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