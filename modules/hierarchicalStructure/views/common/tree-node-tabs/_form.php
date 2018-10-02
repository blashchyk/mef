<?php
use dosamigos\ckeditor\CKEditor;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;

use kartik\tree\Module;
use modules\hierarchicalStructure\models\HsFinalDestination;
use modules\hierarchicalStructure\models\HsTreeNode;
use modules\hierarchicalStructure\models\KartikTreeNode;
use yii\helpers\Html;

use yii\helpers\Url;
use yii\web\View;
use yii\helpers\ArrayHelper;

/**
 * @var View            $this
 * @var KartikTreeNode  $node
 * @var ActiveForm      $form
 * @var array           $formOptions
 * @var string          $keyAttribute
 * @var string          $nameAttribute
 * @var string          $iconAttribute
 * @var string          $iconTypeAttribute
 * @var string          $iconsList
 * @var string          $action
 * @var array           $breadcrumbs
 * @var array           $nodeAddlViews
 * @var mixed           $currUrl
 * @var boolean         $showIDAttribute
 * @var boolean         $showFormButtons
 * @var boolean         $allowNewRoots
 * @var string          $nodeSelected
 * @var array           $params
 * @var string          $keyField
 * @var string          $nodeView
 * @var string          $noNodesMessage
 * @var boolean         $softDelete
 * @var string          $modelClass
 */

?>

<?php
/**
 * SECTION 1: Initialize node view params & setup helper methods.
 */
?>
<?php
extract($params);

$fieldOptions = [
    'template' => '{label}<div class="col-md-10 col-sm-10">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-2 col-md-2 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
];

$session = Yii::$app->has('session') ? Yii::$app->session : null;

// active form instance

$form = ActiveForm::begin([
    'action' => $root ? Url::to(['/hierarchicalStructure/default/create-root-node']) : ($node->isNewRecord ? Url::to(['/hierarchicalStructure/default/create-node']) : Url::to(['/hierarchicalStructure/default/update-node?id='.$node->id])),
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'form-horizontal',
    ]
]);

// helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) {
    $class = "alert alert-{$type}";
    if ($hide) {
        $class .= ' hide';
    }
    return Html::tag('div', '<div>' . $body . '</div>', ['class' => $class]);
};

// helper function to render additional view content
$renderContent = function ($part) use ($nodeAddlViews, $params, $form) {
    if (empty($nodeAddlViews[$part])) {
        return '';
    }
    $p = $params;
    $p['form'] = $form;
    return $this->render($nodeAddlViews[$part], $p);
};
?>

<?php
/**
 * SECTION 2: Initialize hidden attributes. In case you are extending this and creating your own view, it is mandatory
 * to set all these hidden inputs as defined below.
 */
?>
<?= Html::hiddenInput('treeNodeModify', $node->isNewRecord) ?>
<?= Html::hiddenInput('parentKey', $params['parentKey']) ?>
<?= Html::hiddenInput('currUrl', $currUrl) ?>
<?= Html::hiddenInput('modelClass', $modelClass) ?>
<?= Html::hiddenInput('nodeSelected', $nodeSelected) ?>

<?php
/**
 * SECTION 3: Hash signatures to prevent data tampering. In case you are extending this and creating your own view, it
 * is mandatory to include this section below.
 */
?>
<?php
/**
 * BEGIN VALID NODE DISPLAY
 */
?>
<?php if (!$noNodesMessage): ?>
    <?php
    $isAdmin = ($isAdmin == true || $isAdmin === "true");
    $inputOpts = [];

    /**
     * SECTION 5: Setup alert containers. Mandatory to set this up.
     */
    ?>
    <div class="kv-treeview-alerts">
        <?php
        if ($session && $session->hasFlash('success')) {
            echo $showAlert('success', $session->getFlash('success'), false);
        } else {
            echo $showAlert('success');
        }
        if ($session && $session->hasFlash('error')) {
            echo $showAlert('danger', $session->getFlash('error'), false);
        } else {
            echo $showAlert('danger');
        }
        echo $showAlert('warning');
        echo $showAlert('info');
        ?>
    </div>

    <?php
    $node->hs_tree_id = isset($hsTreeId) ? (int) $hsTreeId : null;
    if ($node->isNewRecord) {
        $hsModel = new HsTreeNode();
        $hsModel->loadDefaultValues();
    } else {
        $hsModel = $node->hsTreeNode;
    }
    $inputOpts = [];
    if ($node->isReadonly()) {
        $inputOpts['readonly'] = true;
    }
    if ($node->isDisabled()) {
        $inputOpts['disabled'] = true;
    }

    $fieldOptions = [
    'template' => '{label}<div class="col-md-10 col-sm-10">{input}{hint}{error}</div>',
    'labelOptions' => ['class' => 'control-label col-sm-2 col-md-2 col-xs-12'],
    'errorOptions' => ['class' => 'text-danger'],
    ];

    $CKEditorToolbar = [
    ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
    ['NumberedList', 'BulletedList', '-', 'Blockquote'],
    ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
    ['Link', 'Unlink', 'Anchor'],
    '/',
    ['Styles', 'Format', 'Font', 'FontSize'],
    ['TextColor', 'BGColor'],
    ['Maximize'],
    ['abbr', 'inserthtml']
    ];
    $uploadURL = Url::to(['/page/upload-image/', 'id' => $node->id]);
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($node, 'hs_tree_id')->hiddenInput()->label(false); ?>
            <?= $form->field($hsModel, 'code', $fieldOptions)->textInput($inputOpts); ?>
            <?= $form->field($node, 'name', $fieldOptions)->textInput($inputOpts); ?>
            <?=  $form->field($hsModel, 'description', $fieldOptions)->widget(CKEditor::className(), [
                'preset' => 'standard',
                'options' => ['rows' => 6],
                'clientOptions' => [
                    'filebrowserUploadUrl' => $uploadURL,
                    'toolbar' => $CKEditorToolbar
                ],
            ]) ?>

            <?=  $form->field($hsModel, 'notes_application', $fieldOptions)->widget(CKEditor::className(), [
                'preset' => 'standard',
                'options' => ['rows' => 6],
                'clientOptions' => [
                    'filebrowserUploadUrl' => $uploadURL,
                    'toolbar' => $CKEditorToolbar
                ],
            ]) ?>

            <?=  $form->field($hsModel, 'notes_exclusion', $fieldOptions)->widget(CKEditor::className(), [
                'preset' => 'standard',
                'options' => ['rows' => 6],
                'clientOptions' => [
                    'filebrowserUploadUrl' => $uploadURL,
                    'toolbar' => $CKEditorToolbar
                ],
            ]) ?>

            <?= $form->field($hsModel, 'active', $fieldOptions)->checkbox([], false)->hiddenInput()->label(false) ?>

            <?= $form->field($hsModel, 'conservation_term', $fieldOptions)->dropDownList(range(0, 99)); ?>

            <?= $form->field($hsModel, 'final_destination_id', $fieldOptions)->dropDownList( ArrayHelper::map(HsFinalDestination::find()->all(), 'id', 'description'), [
                'prompt' => Yii::t('app', 'Choose final destination'),
            ]); ?>

        </div>
    </div>

    <?php if (empty($inputOpts['disabled']) || ($isAdmin && $showFormButtons)): ?>
        <div class="pull-right">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <div class="clearfix"></div><br />
    <?php endif; ?>

<?php endif; ?>
<?php
/**
 * END VALID NODE DISPLAY
 */
?>

<?php ActiveForm::end() ?>

<?php
/**
 * SECTION 13: Additional views part 5 accessible by all users after admin zone.
 */
?>
<?= $noNodesMessage ? $noNodesMessage : $renderContent(Module::VIEW_PART_5) ?>