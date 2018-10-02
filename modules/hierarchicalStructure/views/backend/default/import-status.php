<?php
use yii\helpers\Html;
use modules\hierarchicalStructure\assets\backend\ImportAsset;
ImportAsset::register($this);

/**
 * @var \modules\hierarchicalStructure\models\HsTree $hsModel
 * @var int $hsId
 * @var string $newNodesFile
 * @var string $updateNodesFile
 * @var int $newNodesCount
 * @var int $nodesToUpdateCount
 * @var int $memoryUsed
 * @var bool | string $errorMessage
 */

if ($errorMessage === false) :
?>
<div class="js-import-container" data-hsid="<?= $hsModel->id; ?>" data-newNodesFile="<?= $newNodesFile; ?>" data-updateNodesFile="<?= $updateNodesFile; ?>" >
    <?= Yii::t('app', 'File for import was uploaded.'); ?>
    <?= Yii::t('app', 'You make changes to the hierarchical structure') . ' : '. $hsModel->name .' (ID = '. $hsModel->id . ')'; ?>
    <br/>
    <?= '<span class="count_update">' . $nodesToUpdateCount . '</span> '. Yii::t('app', 'similar nodes. The data in them will be updated in accordance with the imported file'); ?>
    <br/>
    <?= '<span class="count_new">' . $newNodesCount .'</span> '. Yii::t('app', 'new nodes will be added'); ?>
    <br/><br/>
    <?= Html::button(Yii::t('app', 'Start Importing...'), ['class'=>'btn btn-primary importing-button js-start-import']); ?>

    <div class="js-import-time"></div>

    <div class="js-load-ajax load-ajax-block">
        <?= Yii::t('app', 'Loading data'); ?>
        <?= $this->render('_import-preloader'); ?>
    </div>
    <div class="js-import-result import-result"></div>
    <br/>
    <div class="js-import-view-hs-btn import-view-hs-btn">
        <?= Html::a('View HS', [ '/hierarchicalStructure/default/view', 'hsId' => $hsId ], ['class' => 'btn btn-primary']); ?>
    </div>
</div>
<?php else : ?>
<div class="import-error-message">
    <span><?= $errorMessage; ?></span>
</div>
<?php endif; ?>