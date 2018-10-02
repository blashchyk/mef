<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;

/**
 * @var $params array
 * @var $noNodesMessage mixed
 * @var $node modules\hierarchicalStructure\models\KartikTreeNode
 * @var $breadcrumbs array
 * @var $parent \modules\hierarchicalStructure\models\HsTreeNode
 * @var $isAdmin boolean
 */
extract($params);

?>
<?php if (empty(Yii::$app->request->getQueryParams()['fund'])) : ?>
<?= Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'View'),
            'active' => !$node->isNewRecord,
            'visible' => !$node->isNewRecord,
            'options' => ['id' => 'view'],
            'content' => $node->isNewRecord ? '' : $this->render('tree-node-tabs/_view', ['params' => $params])
        ],
        [
            'label' => $node->isNewRecord ? Yii::t('app', 'Add New') : Yii::t('app', 'Edit'),
            'visible' => Yii::$app->user->can('hierarchicalStructure.backend.update'),
            'active' => $node->isNewRecord,
            'options' => ['id' => 'edit'],
            'content' => $this->render('tree-node-tabs/_form', ['params' => $params])
        ],
        [
            'label' => Yii::t('app', 'Permission'),
            'visible' => false,
            'options' => ['id' => 'Permission'],
            'content' => $this->render('tree-node-tabs/_permission', ['params' => $params]),
        ],
    ],
]); ?>
    <?php else : ?>
        <?php $record = \modules\hierarchicalStructure\models\Records::findOne(['node_id' => $node->id]); ?>
        <?php if (empty($record)) : ?>
            <div class="no_record"><p><?= Yii::t('app', 'There are no record to display'); ?></p></div>
            <?php else : ?>
                <?php $activeTab = !empty($activeTab) ? $activeTab : 'view'; ?>
        <?php $files = null; ?>
        <?php if (isset($record->files)) : ?>
            <?php foreach ($record->files as $value) : ?>

                <?php $files .= Html::a(
                    substr($value->path, strripos($value->path, '/') + 1, 10),
                    ['funds/download-file', 'id' => $value->id],
                    ['class' => 'btn btn-warning view', 'data-title' => substr($value->path, strripos($value->path, '/') + 1)]);?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can('admin')) : ?>
        <?php $buttons = Html::a(
            '<span class="glyphicon glyphicon-trash delete" data-title="Delete"></span>',
            ['funds/delete-records', 'recordId' => $record->id],
            ['data-confirm' => Yii::t('yii', 'Are you sure you want to delete this HS with all nodes?')]); ?>
                <?= $buttons . Tabs::widget([
            'items' => [
                [
                    'label' => Yii::t('app', 'View'),
                    'active' => empty($activeTab) || $activeTab == 'view',
                    'options' => ['id' => 'view'],
                    'content' => $this->render('../backend/funds/_view', ['record' => $record, 'files' => $files])
                ],
                [
                    'label' => Yii::t('app', 'Edit'),
                    'active' => empty($activeTab) || $activeTab == 'edit',
                    'option' => ['id' => 'edit'],
                    'content' => $this->render(
                            '../backend/funds/_records-form', [
                                'record' => \modules\hierarchicalStructure\models\Records::findOne($record->id),
                                'fundId' => $record->fond_id, 'files' => $record->files,
                                'file' => $file = new \modules\hierarchicalStructure\models\Files(),
                            ]
                        ) . $files,
                ],
            ],
                ]) ?>
                    <?php else : ?>
            <?= Tabs::widget([
                'items' => [
                    [
                        'label' => Yii::t('app', 'View'),
                        'active' => empty($activeTab) || $activeTab == 'view',
                        'options' => ['id' => 'view'],
                        'content' => $this->render('../backend/funds/_view', ['record' => $record, 'files' => $files])
                    ],
                ],
            ]) ?>
                <?php endif; ?>
        <?php endif; ?>

<?php endif; ?>
