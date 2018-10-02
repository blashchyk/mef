<?php

namespace modules\hierarchicalStructure\widgets;

use common\library\config\AccessApplicant;
use common\library\permission\AccessManager;
use kartik\tree\models\Tree;
use kartik\tree\Module;
use kartik\tree\TreeView;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\Permission;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

/**
 * Class HsView
 * @package modules\hierarchicalStructure\models
 */
class HsView extends TreeView
{
    public $hsTreeId;
    private $message = null;
    public $fund;
    public $update = false;
    /**
     * Renders the markup for the detail form to edit/view the selected tree node
     *
     * @return string
     */
    public function renderDetail()
    {
        /**
         * @var KartikTreeNode $modelClass
         * @var KartikTreeNode $node
         */
        $modelPermission = new Permission();
        $accessManager = new AccessManager();
        $list = [];
        $permission = [];
        $root = false;

        $parentKey = (new KartikTreeNode())->getUParent();
        $this->fund = Yii::$app->controller->id;
        $tempId = $this->displayValue;
        if (!empty($this->displayValue)) {
            $partOfView = explode('-', $this->displayValue);
            $this->displayValue = $partOfView[0];
            $this->nodeView = '@modules/hierarchicalStructure/views/common/_tree-node';
        }

        $modelClass = 'modules\hierarchicalStructure\models\KartikTreeNode';
        $node = $this->displayValue ? $modelClass::findOne($tempId) : null;
        if (!empty($tempId)) {
            $this->accessManager($node, $accessManager);
            $list = $accessManager->listAllAccessHolders($node, null);
            $permission = $accessManager->getPermissions($node,
                new AccessApplicant(Yii::$app->user->id, AccessManager::USER));
        }
        $msg = null;
        if (empty($node)) {
            $msg = Html::tag('div', $this->emptyNodeMsg, $this->emptyNodeMsgOptions);
            $node = new $modelClass;
        }
        $iconTypeAttribute = ArrayHelper::getValue($this->_module->dataStructure, 'iconTypeAttribute', 'icon_type');
        if ($this->_iconsList !== false) {
            $node->$iconTypeAttribute = ArrayHelper::getValue($this->iconEditSettings, 'type', self::ICON_CSS);
        }
        $params = $this->_module->treeStructure + $this->_module->dataStructure + [
                'node' => $node,
                'update' => $this->update,
                'permission' => $permission,
                'modelPermission' => $modelPermission,
                'listPermission' => $list,
                'root' => $root,
                'parentKey' => $parentKey,
                'action' => $this->nodeActions[Module::NODE_SAVE],
                'formOptions' => $this->nodeFormOptions,
                'modelClass' => $modelClass,
                'currUrl' => Yii::$app->request->url,
                'isAdmin' => $this->isAdmin,
                'iconsList' => $this->_iconsList,
                'softDelete' => $this->softDelete,
                'allowNewRoots' => $this->allowNewRoots,
                'showFormButtons' => $this->showFormButtons,
                'showIDAttribute' => $this->showIDAttribute,
                'nodeView' => $this->nodeView,
                'nodeAddlViews' => $this->nodeAddlViews,
                'nodeSelected' => $this->_nodeSelected,
                'breadcrumbs' => $this->breadcrumbs,
                'noNodesMessage' => $msg,
                'hsTreeId' => $this->hsTreeId,
                'fund' => $this->fund,
            ];
        $content = $this->render($this->nodeView, ['params' => $params]);

        return Html::tag('div', $content, $this->detailOptions);
    }

    /**
     * @param $node
     * @param $accessManager
     * @return string
     */
    public function accessManager($node, $accessManager)
    {
        if (empty($node)) {
            $this->message = Yii::t('app', 'Document deleted or missing such');

            return $this->renderBodyError();
        }
        if (Yii::$app->user->getIdentity()) {
            if (!$accessManager->checkPermission($node, Yii::$app->user->getIdentity(),
                AccessManager::VIEW | AccessManager::ASSIGN)
            ) {
                if ($node->hsTreeNode->user_id !== Yii::$app->user->id) {
                    $this->message = Yii::t('app', 'Permission denied');

                    return $this->renderBodyError();
                }
            }
            if ($accessManager->checkPermission($node, Yii::$app->user->getIdentity(),
                    AccessManager::UPDATE | AccessManager::ASSIGN) || $node->hsTreeNode->user_id === Yii::$app->user->id
            ) {
                $this->update = true;
            }
        }
    }



    /**
     * @return string
     */
    public function renderTree()
    {
        $structure = $this->_module->treeStructure + $this->_module->dataStructure;
        extract($structure);
        $nodeDepth = $currDepth = $counter = 0;
        $out = Html::beginTag('ul', ['class' => 'kv-tree']) . "\n";
        foreach ($this->_nodes as $node) {
            /**
             * @var Tree $node
             */
            if (!$this->isAdmin && !$node->isVisible() || !$this->showInactive && !$node->isActive()) {
                continue;
            }
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeDepth = $node->$depthAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeLeft = $node->$leftAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeRight = $node->$rightAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeKey = $node->$keyAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeName = $node->$nameAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeIcon = $node->$iconAttribute;
            /** @noinspection PhpUndefinedVariableInspection */
            $nodeIconType = $node->$iconTypeAttribute;

            $isChild = ($nodeRight == $nodeLeft + 1);
            $indicators = '';

            if (isset($this->nodeLabel)) {
                $label = $this->nodeLabel;
                $nodeName = is_callable($label) ? $label($node) :
                    (is_array($label) ? ArrayHelper::getValue($label, $nodeKey, $nodeName) : $nodeName);
            }
            if ($nodeDepth == $currDepth) {
                if ($counter > 0) {
                    $out .= "</li>\n";
                }
            } elseif ($nodeDepth > $currDepth) {
                $out .= Html::beginTag('ul') . "\n";
                $currDepth = $currDepth + ($nodeDepth - $currDepth);
            } elseif ($nodeDepth < $currDepth) {
                $out .= str_repeat("</li>\n</ul>", $currDepth - $nodeDepth) . "</li>\n";
                $currDepth = $currDepth - ($currDepth - $nodeDepth);
            }
            if (trim($indicators) == null) {
                $indicators = '&nbsp;';
            }
            $nodeOptions = [
                'data-key' => $nodeKey,
                'data-lft' => $nodeLeft,
                'data-rgt' => $nodeRight,
                'data-lvl' => $nodeDepth,
                'data-readonly' => static::parseBool($node->isReadonly()),
                'data-movable-u' => static::parseBool($node->isMovable('u')),
                'data-movable-d' => static::parseBool($node->isMovable('d')),
                'data-movable-l' => static::parseBool($node->isMovable('l')),
                'data-movable-r' => static::parseBool($node->isMovable('r')),
                'data-removable' => static::parseBool($node->isRemovable()),
                'data-removable-all' => static::parseBool($node->isRemovableAll()),
            ];

            $css = [];
            if (!$isChild) {
                $css[] = 'kv-parent ';
            }
            if (!$node->isVisible() && $this->isAdmin) {
                $css[] = 'kv-invisible';
            }
            if ($this->showCheckbox && $node->isSelected()) {
                $css[] = 'kv-selected ';
            }
            if ($node->isCollapsed()) {
                $css[] = 'kv-collapsed ';
            }
            if ($node->isDisabled()) {
                $css[] = 'kv-disabled ';
            }
            if (!$node->isActive()) {
                $css[] = 'kv-inactive ';
            }
            $indicators .= $this->renderToggleIconContainer(false) . "\n";
            $indicators .= $this->showCheckbox ? $this->renderCheckboxIconContainer(false) . "\n" : '';
            if (!empty($css)) {
                Html::addCssClass($nodeOptions, $css);
            }
            $out .= Html::beginTag('li', $nodeOptions) . "\n" .
                Html::beginTag('div', ['tabindex' => -1, 'class' => 'kv-tree-list']) . "\n" .
                Html::beginTag('div', ['class' => 'kv-node-indicators']) . "\n" .
                $indicators . "\n" .
                '</div>' . "\n" .
                Html::beginTag('div', ['tabindex' => -1, 'class' => 'kv-node-detail']) . "\n" .
                $this->renderNodeIcon($nodeIcon, $nodeIconType, $isChild) . "\n" .
                Html::tag('span', $nodeName, ['class' => 'kv-node-label']) . "\n" .
                '</div>' . "\n" .
                '</div>' . "\n";
            ++$counter;
        }
        $out .= str_repeat("</li>\n</ul>", $nodeDepth) . "</li>\n";
        $out .= "</ul>\n";

        return Html::tag('div', $this->renderRoot() . $out, $this->treeOptions);
    }


    private function renderBodyError()
    {
        $alertDiv = Html::tag('div', $this->message, ['class' => 'alert alert-danger', 'style' => 'margin-top:20px']);

        return Html::tag('div', $alertDiv, ['class' => 'kv-detail-container']);
    }
}