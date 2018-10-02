<?php
use yii\helpers\Html;
use modules\hierarchicalStructure\helpers\AlertHelper;
use modules\hierarchicalStructure\assets\backend\TokenAsset;
TokenAsset::register($this);

/* @var common\models\User $user */
$this->title = Yii::t('app', 'API Token');
?>
<div class="row">
    <div class="col-md-6">

        <?= AlertHelper::showAlertMessage(['js-token-alert-success', 'alert-success']); ?>

        <?= AlertHelper::showAlertMessage(['js-token-alert-error', 'alert-danger']); ?>

        <?= AlertHelper::showAlertMessage(['js-token-alert-unknown-error', 'alert-danger'], 'Unknown error. Token wasn`t changed!'); ?>

    </div>
</div>
<div class="token-index-wrap">
    <div class="row">
        <div class="col-md-4">
            <b>
                <?= Yii::t('app', 'You can use this token to access the API'); ?>
            </b> : </div>
        <div class="col-md-5">
            <span class="api-access-token js-api-access-token">
                <?= $user->access_token; ?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 reset-api-button-wrap">
        <?= Html::a(Yii::t('app', 'Reset API Token'), [ '/'],
            ['class' => 'btn btn-primary reset-token-button js-reset-token-button']); ?>
        </div>
    </div>
</div>