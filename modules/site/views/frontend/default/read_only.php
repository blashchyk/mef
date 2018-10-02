<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

?>
<div class="site-error error-page">

    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-1">

        <h1><?= Yii::t('app', 'Test Mode') ?></h1>

        <div class="alert alert-danger">
            <?= Yii::t('app', 'Sorry, but you are not allowed to perform this action because you have been granted only read permissions.') ?>
        </div>

        <?= Html::button('<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('app', 'Go Back'), ['class' => 'btn btn-primary go-back', 'onclick' => 'goBack()']) ?>

    </div>

</div>

<script>
    function goBack() {
        window.history.back();
    }
    setTimeout(goBack, 5000);
</script>