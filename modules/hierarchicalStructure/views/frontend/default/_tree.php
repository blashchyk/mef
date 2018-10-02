<?php
use kartik\tree\Module;
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\widgets\HsView;
use yii\helpers\Url;
use modules\hierarchicalStructure\models\Records;
use modules\hierarchicalStructure\models\Funds;

/* @var boolean $isAdmin */
/* @var $hsTree HsTree */
/* @var array $disabledButtons */
$fund = Funds::findOne(['id' => Yii::$app->request->getQueryParam('fundId')]);
?>
<?php if (!empty($hsTree)) : ?>
    <?php foreach($hsTree as $k => $item) : ?>

    <?= HsView::widget([
        'query' => KartikTreeNode::find()
            ->from(KartikTreeNode::tableName() . ' AS hs')
            ->where(['hs.hs_tree_id' => $item->id])
            ->innerJoin(KartikTreeNode::tableName() . ' AS p',
                ['and',
                    [
                        'and',
                        'hs.root=p.root',
                        'hs.lft<=p.lft',
                        'hs.rgt>=p.rgt',
                    ],
                    [
                        'p.type' => 2,
                        'p.fund_id' => $fund->id,
                    ]
                ]
            )
            ->orderBy('root, lft'),
        'displayValue' => $id,
        'nodeView' => ($k === 0) ? '@modules/hierarchicalStructure/views/backend/funds/tree-node-tabs/_form' : '@modules/hierarchicalStructure/views/backend/funds/tree-node-tabs/_empty',
        'nodeFormOptions' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data',
        ],
        'nodeActions' => $isAdmin ? [
            Module::NODE_MANAGE => Url::to(['/hierarchicalStructure/default/preview-node', 'hsTreeId' => $item->id, 'fund' => true]),
            Module::NODE_REMOVE => Url::to(['/hierarchicalStructure/default/delete-node']),
            Module::NODE_MOVE => Url::to(['/hierarchicalStructure/default/move-node']),
        ] : [
            Module::NODE_MANAGE => Url::to(['/hierarchicalStructure/default/node-view', 'hsTreeId' => $item->id]),
        ],
        'isAdmin' => $isAdmin,
        'headingOptions' => ['label' => Yii::t('app', 'Nodes')],
        'emptyNodeMsg' => Yii::t('app', 'Select a tree node to display.'),
        'treeOptions' => ['style' => 'height: 650px'],
        'buttonOptions' => ['class' => 'btn btn-success hidden'],
        'rootOptions' => ['class' => 'text-primary', 'label' => $fund->code],
        'mainTemplate' => '<div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4">
                    {wrapper}
                </div>
                <div class="col-sm-8">
                    {detail}
                </div>
            </div>',
        'wrapperTemplate' => $isAdmin ? '{footer}{tree}{header}' : '{tree}{header}',
        'nodeLabel' => function($node) {
            /** @var KartikTreeNode $node */
            return (($node->hsTreeNode->code) ?: Records::findOne(['node_id' => $node->id])->code) . ' - ' . $node->name;
        },
        'hsTreeId' => $item->id,
    ]);
    ?>

    <?php endforeach; ?>
<?php endif; ?>
