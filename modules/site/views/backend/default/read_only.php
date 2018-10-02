<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

?>
<div class="site-index">

    <h1><?= Yii::t('app', 'Test Mode') ?></h1>

    <p class="alert alert-danger"><?= Yii::t('app', 'Sorry, but you are not allowed to perform this action because you have been granted only read permissions.') ?></p>

    <?= Html::button('<i class="glyphicon glyphicon-arrow-left"></i> ' . Yii::t('app', 'Go Back'), ['class' => 'btn btn-primary go-back', 'onclick' => 'goBack()']) ?>

</div>

<script>
    function goBack() {
        window.history.back();
    }
    setTimeout(goBack, 5000);
</script>
