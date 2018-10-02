<?php
use kartik\tree\Module;
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\widgets\HsView;
use yii\helpers\Url;

/* @var boolean $isAdmin */
/* @var $hsTree HsTree */
/* @var array $disabledButtons */
?>
<?= HsView::widget([
    'query' => $hsTree->getKartikTreeNodes()->where(['type' => 1])->orderBy('root, lft'),
    'nodeView' => '@modules/hierarchicalStructure/views/common/tree-node-tabs/_form',
    'nodeFormOptions' => [
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data',
    ],
    'nodeActions' => $isAdmin ? [
        Module::NODE_MANAGE => Url::to(['/hierarchicalStructure/default/preview-node', 'hsTreeId' => $hsTree->id]),
        Module::NODE_REMOVE => Url::to(['/hierarchicalStructure/default/delete-node']),
        Module::NODE_MOVE => Url::to(['/hierarchicalStructure/default/move-node']),
    ] : [
        Module::NODE_MANAGE => Url::to(['/hierarchicalStructure/default/node-view', 'hsTreeId' => $hsTree->id]),
    ],
    'isAdmin' => $isAdmin,
    'headingOptions' => ['label' => Yii::t('app', 'Nodes')],
    'emptyNodeMsg' => Yii::t('app', 'Select a tree node to display.'),
    'treeOptions' => ['style' => 'height: 650px'],
    'buttonOptions' => ['class' => 'btn btn-success'],
    'rootOptions' => ['class' => 'text-primary', 'label' => $hsTree->name],
    'toolbar' => $disabledButtons,
    'mainTemplate' => '<div class="row central_section">
            <div class="col-sm-4 col-md-4 col-lg-4 left-block">
                {wrapper}
            </div>
            <div class="col-sm-8 right-width">
            <div class="right-block"></div>
                {detail}
            </div>
        </div>',
    'wrapperTemplate' => $isAdmin ? '{footer}{tree}{header}' : '{tree}{header}',
    'nodeLabel' => function($node) {
        /** @var KartikTreeNode $node */
        return $node->hsTreeNode->code . ' - ' . $node->name;
    },
    'hsTreeId' => $hsTree->id
]);
?>