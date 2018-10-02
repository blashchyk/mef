<?php
use yii\widgets\DetailView;
use yii\helpers\Html;
use modules\hierarchicalStructure\models\Records;
use yii\bootstrap\Tabs;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\controllers\backend\FundsController;

?>
<div class="record-container">
    <div class="row">
        <div class="col-md-12">
            <?= Html::a(
                Yii::t('app', 'Add record'),
                ['create-records', 'fundId' => $fund->id],
                ['class' => 'btn btn-success pull-right']
            );?>
        </div>
    </div>

</div>