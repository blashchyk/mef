<?php
use yii\helpers\Html;
use modules\hierarchicalStructure\controllers\backend\FundsController;

?>
<h2><?= $fund->code; ?></h2>

<h3><?= $fund->title;?></h3>


<?php if (isset($fund->hsTree)) : ?>
    <ul class="hs">
        <?php foreach ($fund->hsTree as $hs) : ?>
            <?php if ($hs->name !== FundsController::WITHOUT_HS) : ?>
                <li><?= \yii\helpers\Html::a($hs->name, ['../hierarchicalStructure/view', 'hsId' => $hs->id]) ?></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

<?php endif; ?>
