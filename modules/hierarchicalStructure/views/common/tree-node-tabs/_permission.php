<?php
use modules\hierarchicalStructure\models\Permission;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\library\permission\AccessManager;
use common\models\User;

$fieldOptions = [
    'template' => '{label}<div class="col-md-10 col-sm-10">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-2 col-md-2 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];

$checkOptions = [
    'template' => '{label}{input}{hint}{error}',
    'labelOptions' => ['class' => ''],
    'errorOptions' => ['class' => 'text-danger'],
    'options' => ['class' => 'form-group field-permission-permission required col-md-3'],
];

$node = $params['node'];
$permissions = $params['listPermission'];
$permission = $params['permission'];
$modelPermission = $params['modelPermission'];

?>
<div class="row">
    <div class="col-sm-12 menu-permission">

        <?php $form = ActiveForm::begin([
            'action' => Url::to(['/hierarchicalStructure/node-permission']),
            'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'form-horizontal permission',
            ],
        ]); ?>

        <div>
            <?= Html::input('hidden', 'treeNodeModify', '1') ?>
            <?= Html::input('hidden', 'parentKey', $params['parentKey']) ?>
            <?= Html::input('hidden', 'currUrl', $params['currUrl']) ?>
            <?= Html::input('hidden', 'nodeSelected', $params['nodeSelected']) ?>

            <?= Html::input('text', 'id', $node->id, ['class' => 'hidden']); ?>

            <?= $form->field($modelPermission, 'list', $fieldOptions)->dropDownList(User::getList(), ['class' => 'form-control', 'id' => 'list', 'name' => 'list']); ?>

            <div class="form-group permission">
                <label class="control-label col-sm-2 col-md-2 col-xs-12"><?= Yii::t('app', 'Permisssion') ?></label>
                <div class="col-md-10 permission-fields-wrap">
                    <?php /*echo $form->field($modelPermission, 'permission', $checkOptions)->checkbox([
                        'name' => 'permission[]',
                        'label' => 'assign',
                        'value' => '16',
                        'class' => 'assign',
                        'uncheck' => false
                    ])*/ ?>
                    <?= $form->field($modelPermission, 'permission', $checkOptions)->checkbox([
                        'name' => 'permission[]',
                        'label' => 'view',
                        'value' => '1',
//                        'uncheck' => false
                    ]) ?>
                    <?= $form->field($modelPermission, 'permission', $checkOptions)->checkbox([
                        'name' => 'permission[]',
                        'label' => 'create',
                        'value' => '4',
//                        'uncheck' => false
                    ]) ?>
                    <?= $form->field($modelPermission, 'permission', $checkOptions)->checkbox([
                        'name' => 'permission[]',
                        'label' => 'update',
                        'value' => '2',
//                        'uncheck' => false
                    ]) ?>
                    <?= $form->field($modelPermission, 'permission', $checkOptions)->checkbox([
                        'name' => 'permission[]',
                        'label' => 'delete',
                        'value' => '8',
//                        'uncheck' => false
                    ]) ?>
                </div>
            </div>


        </div>
        <div class="pull-right">
            <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-primary']) ?>
            <?= Html::submitButton($node->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                ['class' => 'btn btn-success permission-validation']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <p>
        <div class="col-sm-12">
            <?php if (!empty($permissions)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?= Yii::t('app', 'Access type') ?></th>
                            <th><?= Yii::t('app', 'Access id') ?></th>
                            <th><?= Yii::t('app', 'Permission') ?></th>
                            <th><?= Yii::t('app', 'Action') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($permissions as $key => $item): ?>
                            <tr>
                                <th scope="row"><?= $key + 1 ?></th>
                                <td><?= Permission::getTypes()[$item['access_type']] ?></td>
                                <td>
                                    <?php if (intval($item['access_type']) === AccessManager::USER) : ?>
                                        <?= User::getList()[$item['access_id']]; ?>
                                    <?php else : ?>
                                        <?= $item['access_id'] ?>
                                    <?php endif; ?>
                                </td>
                                <td><?= AccessManager::VIEW & $item['permission'] ? Yii::t('app', 'view') : '' ?>
                                    <?= AccessManager::UPDATE & $item['permission'] ? Yii::t('app', 'update') : '' ?>
                                    <?= AccessManager::CREATE & $item['permission'] ? Yii::t('app', 'create') : '' ?>
                                    <?= AccessManager::DELETE & $item['permission'] ? Yii::t('app', 'delete') : '' ?>
                                    <?= AccessManager::ASSIGN & $item['permission'] ? Yii::t('app',
                                        'assign') : '' ?></td>
                                <td><?= Yii::$app->user->getId() !== intval($item['access_id']) ? Html::a(
                                        Yii::t('app', 'Remove'),
                                        [
                                            Url::to('permission-remove'),
                                            'id' => $node->id,
                                            'access_type' => $item['access_type'],
                                            'access_id' => $item['access_id'],
                                        ],
                                        [
                                            'class' => 'btn btn-danger',
                                        ]) : '<h5>' . Yii::t('app', 'Owner') . '<h5>';
                                    ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
    <p class="bg-primary"><?= !empty($permission) ? Yii::t('app',
            'Permission inherited from the parent') : Yii::t('app', 'Owner of the folder'); ?></p>
    <?php endif; ?>

</div>
</div>
