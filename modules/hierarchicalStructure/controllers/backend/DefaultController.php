<?php

namespace modules\hierarchicalStructure\controllers\backend;

use common\library\config\AccessApplicant;
use common\library\permission\AccessManager;
use common\models\User;
use common\services\DeleteService;
use common\services\MoveService;
use common\services\TreeNodeService;
use common\services\ExcelService;
use common\services\UserService;
use modules\hierarchicalStructure\models\ConnectionFundsStructure;
use modules\hierarchicalStructure\models\Files;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\Permission;
use modules\hierarchicalStructure\models\Records;
use Yii;
use common\controllers\BaseController;
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\models\UploadForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use modules\hierarchicalStructure\widgets\HsView;
use hscstudio\export\OpenTBS;
use bupy7\xml\constructor\XmlConstructor;
use yii\web\Cookie;
use Closure;
use Exception;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\NotSupportedException;
use yii\db\Exception as DbException;

class DefaultController extends BaseController
{
    private $successful = 1;
    private $permissionsDenied = 4;
    private $unexpectedError = 5;

    /**
     * @param null|integer $errorIndex
     * @return array|string
     *
     */
    private function getMessages($errorIndex = null)
    {
        $messages = [
            $this->successful => Yii::t('app', 'Successful execution'),
            $this->permissionsDenied => Yii::t('app', 'Permission denied'),
            $this->unexpectedError => Yii::t('app', 'An unexpected error occurred'),
        ];
        return !is_null($errorIndex) && in_array($errorIndex, array_keys($messages)) ? $messages[$errorIndex]: $messages ;
    }


    public function permissionMapping()
    {
        return [
            'index' => 'hierarchicalStructure.backend.index',
            'view' => 'hierarchicalStructure.backend.index',
            'create' => 'hierarchicalStructure.backend.create',
            'update' => 'hierarchicalStructure.backend.update',
            'delete' => 'hierarchicalStructure.backend.delete',
            'preview-node' => 'hierarchicalStructure.backend.index',
            'create-root-node' => 'hierarchicalStructure.backend.create',
            'create-node' => 'hierarchicalStructure.backend.create',
            'node-permission' => 'hierarchicalStructure.backend.delete',
            'update-node' => 'hierarchicalStructure.backend.update',
            'move-node' => 'hierarchicalStructure.backend.update',
            'delete-node' => 'hierarchicalStructure.backend.delete',
            'upload-excel' => 'hierarchicalStructure.backend.update',
            'import-excel' => 'hierarchicalStructure.backend.update',
            'export-pdf' => 'hierarchicalStructure.backend.index',
            'export-odt' => 'hierarchicalStructure.backend.index',
            'export-xml' => 'hierarchicalStructure.backend.index',
            'export-csv' => 'hierarchicalStructure.backend.index',
            'export-excel' => 'hierarchicalStructure.backend.index',
            'export' => 'hierarchicalStructure.backend.index',
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => HsTree::find()->where(['type' => 1]),
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id'  => 'SORT_DESC',
                    ]
            ],
        ]);

        return $this->render('hs-list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $hsId
     * @return string
     */
    public function actionView($hsId)
    {
        $params = Yii::$app->request->get();
        if ($params['move_node_id'] || $params['parent_id']) {
            return $this->dragging($params['move_node_id'], $params['parent_id'], $params['root']);
        }
        $this->setPhpIniValue();
        $hsTree = HsTree::findOne($hsId);
        $nodesCount = count(KartikTreeNode::findAll(['hs_tree_id' => $hsId]));
        if(empty($hsTree)){
            \Yii::$app->session->setFlash('error', \Yii::t('app', 'Invalid data passed'));
            $this->redirect(\Yii::$app->request->referrer);
        }

        $disabledButtons = [];
        $buttonOptions = [
            'alwaysDisabled' => true,
        ];

        if (!Yii::$app->user->can('hierarchicalStructure.backend.create')) {
            $disabledButtons = [
                'create' => $buttonOptions,
                'create-root' => $buttonOptions,
                'move-up' => $buttonOptions,
                'move-down' => $buttonOptions,
                'move-left' => $buttonOptions,
                'move-right' => $buttonOptions,
                'refresh' => $buttonOptions,
                'remove' => $buttonOptions,
            ];
        }
        return $this->render('@modules/hierarchicalStructure/views/common/index', [
            'isAdmin' => true,
            'hsTree' => $hsTree,
            'nodesCount' => $nodesCount,
            'disabledButtons' => $disabledButtons
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $hs = new HsTree();
        if ($hs->load(Yii::$app->request->post()) && $hs->save()) {
            return $this->redirect(['/hierarchicalStructure/default/index']);
        } else {
            return $this->render('hs-create', [
                'hs' => $hs,
            ]);
        }
    }

    /**
     * @param int $hsId
     * @return string|Response
     */
    public function actionUpdate($hsId)
    {
        $hs = HsTree::findOne($hsId);

        if ($hs->load(Yii::$app->request->post()) && $hs->save()) {
            return $this->redirect(['/hierarchicalStructure/default/index']);
        } else {
            return $this->render('hs-update', [
                'hs' => $hs,
            ]);
        }
    }

    /**
     * @param string $hsId
     * @return Response
     */
    public function actionDelete($hsId)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $delete_funds = ArrayHelper::getColumn(
                ConnectionFundsStructure::find()
                    ->select('fund_id')
                    ->where(['hs_id' => $hsId])
                    ->asArray()
                    ->all(),
                'fund_id'
            );
            $delete_records = ArrayHelper::getColumn(
                Records::find()
                    ->select('id')
                    ->where(['fond_id' => $delete_funds])
                    ->asArray()
                    ->all(),
                'id'
            );
            $delete_files = ArrayHelper::getColumn(
                Files::find()
                    ->select(['path'])
                    ->where(['record_id' => $delete_records])
                    ->asArray()
                    ->all(),
                'path'
            );
            if (!empty($delete_funds)) {
                DeleteService::deleteFund(...$delete_funds);
            }
            if (!empty($delete_records)) {
                DeleteService::deleteRecord(...$delete_funds);
                if (!KartikTreeNode::deleteAll(['hs_tree_id' => $hsId])) {
                    throw new \yii\base\Exception('Error while deleting');
                }
            }
            if (!HsTree::findOne($hsId)->delete()) {
                throw new \yii\base\Exception('Error while deleting');
            }
            if (!empty($delete_files)) {
                DeleteService::deleteFiles(...$delete_records);
                foreach ($delete_files as $file_path) {
                    unlink(\Yii::getAlias('@runtime/') . $file_path);
                }
            }
            $transaction->commit();
        } catch (\yii\base\Exception $e) {
            $transaction->rollBack();
        }

        return $this->redirect(['index']);
    }

    /**
     * @param KartikTreeNode $node
     * @param array $postData
     */
    private function setSelectedNodeData($node, $postData)
    {
        if (Yii::$app->has('session')) {
            $module = HsView::module();
            $keyAttr = $module->dataStructure['keyAttribute'];

            $session = Yii::$app->session;
            $session->set(ArrayHelper::getValue($postData, 'nodeSelected', 'kvNodeId'), $node->{$keyAttr});
        }
    }

    public function actionPreviewNode()
    {
        $modelPermission = new Permission();
        $postData = Yii::$app->request->post();
        $id = $postData['id'];
        $parentKey = $postData['parentKey'];
        Yii::$app->response->format = "json";
        $listPermission = [];
        $permission = [];
        $root = false;
        $update = false;
        if (empty($id)) {
            if (intval($parentKey)) {
                $nodeModel = self::findModel($parentKey);
                if (!$this->isNodeAccess($nodeModel, AccessManager::CREATE)) {
                    return [
                        "out" => Yii::t('app', 'Permission denied'),
                        "status" => "error",
                    ];
                }

                $nodeModel = new KartikTreeNode();
                $nodeModel->initDefaults();
                $update = true;
            } else {
                $nodeModel = new KartikTreeNode();
                $nodeModel->initDefaults();
                $root = true;
                $update = true;
            }
        } else {

            $nodeModel = self::findModel($id);
            if (empty($nodeModel)) {
                return [
                    "out" => Yii::$app->response->statusCode,
                    "status" => "error",
                ];
            }

            if ($this->isNodeAccess($nodeModel, AccessManager::UPDATE | AccessManager::ASSIGN)) {
                $update = true;
            }
            $listPermission = $nodeModel->listAllAccessHolders;
            $permission = $nodeModel->permissions;
        }

        $nodeView = '@modules/hierarchicalStructure/views/common/_tree-node';

        $params = [
            'node' => $nodeModel,
            'update' => $update,
            'permission' => $permission,
            'modelPermission' => $modelPermission,
            'listPermission' => $listPermission,
            'root' => $root,
            'parentKey' => $parentKey,
            'action' => $postData['formAction'],
            'formOptions' => empty($formOptions) ? [] : $formOptions,
            'modelClass' => $postData['modelClass'],
            'currUrl' => $postData['currUrl'],
            'isAdmin' => $postData['isAdmin'],
            'iconsList' => $postData['iconsList'],
            'softDelete' => $postData['softDelete'],
            'showFormButtons' => $postData['showFormButtons'],
            'showIDAttribute' => $postData['showIDAttribute'],
            'allowNewRoots' => $postData['allowNewRoots'],
            'nodeView' => $nodeView,
            'nodeAddlViews' => \Yii::$app->request->post('nodeAddlViews', []),
            'nodeSelected' => $postData['nodeSelected'],
            'breadcrumbs' => empty($breadcrumbs) ? [] : $breadcrumbs,
            'noNodesMessage' => '',
            'hsTreeId' => \Yii::$app->request->get('hsTreeId')
        ];

        $userService = new UserService();

        return [
            "out" => $this->renderAjax($nodeView, [
                'params' => $params,
                'isAdminRole' => $userService->getCurrentUser()->isAdmin()
            ]),
            "status" => "success",
        ];
    }

    public function actionCreateRootNode()
    {
        $postData = Yii::$app->request->post();
        $modelClass = $postData['modelClass'];
        /** @var KartikTreeNode $node */
        $node = new $modelClass;
        $node->activeOrig = $node->active;
        $node->load($postData);
        # todo: need to check root creating in other way, using AccessManager
        if (!Yii::$app->user->identity->isAdmin()) {
            $this->showMessage($this->getMessages($this->permissionsDenied));
            return $this->redirect(\Yii::$app->request->referrer);
        }

        $node->makeRoot();
        if (!$node->save()) {
            $this->showMessage(implode('<br>', $node->getFirstErrors()));
            return $this->redirect(\Yii::$app->request->referrer);
        }
        $node->assignPermission(
            AccessManager::VIEW |
            AccessManager::UPDATE |
            AccessManager::CREATE |
            AccessManager::DELETE
        );
        $this->showMessage(\Yii::t('app', 'Root node created successfully'), 'success');

        $this->setSelectedNodeData($node, $postData);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Create a new folder or file
     *
     * @throws NotFoundHttpException
     * @return array|Response
     */
    public function actionCreateNode()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $postData = Yii::$app->request->post();
        $parentKey = $postData['parentKey'];
        $nodeModel = self::findModel($parentKey);


        if (!$this->isNodeAccess($nodeModel, AccessManager::CREATE) ) {
            $this->showMessage($this->getMessages($this->permissionsDenied));
            return $this->redirect(\Yii::$app->request->referrer);
        }

        $modelClass = $postData['modelClass'];
        /** @var KartikTreeNode $node */
        $node = new $modelClass;
        $node->activeOrig = $node->active;
        $node->load($postData);
        $parent = $modelClass::findOne($parentKey);
        $node->appendTo($parent);

        if (!$node->save()) {
            $this->showMessage(implode('<br>', $node->getFirstErrors()));
            return $this->redirect(\Yii::$app->request->referrer);
        }

        if ($nodeModel->hsTreeNode->user_id !== Yii::$app->user->id) {
            $nodeModel->assignPermission(
                AccessManager::VIEW |
                AccessManager::UPDATE |
                AccessManager::CREATE |
                AccessManager::DELETE);
        }

        $this->showMessage(\Yii::t('app', 'Node created successfully'), 'success');

        $this->setSelectedNodeData($node, $postData);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * update file data
     *
     * @param $id
     *
     * @throws NotFoundHttpException
     * @return array|Response
     */
    public function actionUpdateNode($id)
    {
        $postData = Yii::$app->request->post();

        $node = $this->findModel($id);
        if (!$this->isNodeAccess($node, AccessManager::UPDATE | AccessManager::ASSIGN)) {
            $this->showMessage($this->getMessages($this->permissionsDenied));
        }else if ($node->load(Yii::$app->request->post()) && $node->save()) {
            $childrens = KartikTreeNode::findOne($node->id)->children()->all();
            foreach ($childrens as $children) {
                $children->hsTreeNode->conservation_term = $node->hsTreeNode->conservation_term;
                $children->hsTreeNode->final_destination_id = $node->hsTreeNode->final_destination_id;
                $children->hsTreeNode->save();
            }
            $parent = $node->parents(1)->one();
            $childrens = $parent->children(1)->all();
            foreach ($childrens as $children) {
                $all_code_array = explode(FundsController::DELIMITER, $children->getCodePath());
                $code_childrens[$children->id] = end($all_code_array);
            }
            MoveService::saveNode($node, $code_childrens);
            $this->showMessage(\Yii::t('app', 'Node updated successfully'), 'success');
        } else {
            $this->showMessage(implode('<br>', $node->getFirstErrors()));
        }

        $this->setSelectedNodeData($node, $postData);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * Checks if request is valid and throws exception if invalid condition is true
     *
     * @param boolean $isJsonResponse whether the action response is of JSON format
     * @param boolean $isInvalid whether the request is invalid
     *
     * @throws InvalidCallException
     */
    protected static function checkValidRequest($isJsonResponse = true, $isInvalid = null)
    {
        $app = Yii::$app;
        if ($isJsonResponse) {
            $app->response->format = Response::FORMAT_JSON;
        }
        if ($isInvalid === null) {
            $isInvalid = !$app->request->isAjax || !$app->request->isPost;
        }
        if ($isInvalid) {
            throw new InvalidCallException(Yii::t('app', 'This operation is not allowed.'));
        }
    }

    /**
     * Processes a code block and catches exceptions
     *
     * @param Closure $callback the function to execute (this returns a valid `$success`)
     * @param string $msgError the default error message to return
     * @param string $msgSuccess the default success error message to return
     *
     * @return array outcome of the code consisting of following keys:
     * - `out`: _string_, the output content
     * - `status`: _string_, success or error
     */
    public static function process($callback, $msgError, $msgSuccess)
    {
        $error = $msgError;
        try {
            $success = call_user_func($callback);
        } catch (DbException $e) {
            $success = false;
            $error = $e->getMessage();
        } catch (NotSupportedException $e) {
            $success = false;
            $error = $e->getMessage();
        } catch (InvalidParamException $e) {
            $success = false;
            $error = $e->getMessage();
        } catch (InvalidConfigException $e) {
            $success = false;
            $error = $e->getMessage();
        } catch (InvalidCallException $e) {
            $success = false;
            $error = $e->getMessage();
        } catch (Exception $e) {
            $success = false;
            $error = $e->getMessage();
        }
        if ($success !== false) {
            $out = $msgSuccess === null ? $success : $msgSuccess;
            return ['out' => $out, 'status' => 'success'];
        } else {
            return ['out' => $error, 'status' => 'error'];
        }
    }

    /**
     * @return array|Response
     */
    public function actionMoveNode()
    {
        static::checkValidRequest();
        $data = Yii::$app->request->post();
        $idFrom = $data['idFrom'];
        $idTo = $data['idTo'];
        $dir = $data['dir'];
        $allowNewRoots = $data['allowNewRoots'];
        $nodeFrom = KartikTreeNode::findOne($idFrom);
        $nodeTo = KartikTreeNode::findOne($idTo);
        $isMovable = $nodeFrom->isMovable($dir);
        $errorMsg = $isMovable ? Yii::t('app', 'Error while moving the node. Please try again later.') :
            Yii::t('app', 'The selected node cannot be moved.');

        if (!$this->isNodeAccess($nodeFrom, AccessManager::UPDATE)) {
            $this->showMessage($this->getMessages($this->permissionsDenied));
            return $this->redirect(\Yii::$app->request->referrer);
        }

        $callback = function () use ($dir, $nodeFrom, $nodeTo, $allowNewRoots, $isMovable) {
            if (!empty($nodeFrom) && !empty($nodeTo)) {
                if (!$isMovable) {
                    return false;
                }
                if ($dir == 'u') {
                    $nodeFrom->insertBefore($nodeTo);
                } elseif ($dir == 'd') {
                    $nodeFrom->insertAfter($nodeTo);
                } elseif ($dir == 'l') {
                    if ($nodeTo->isRoot() && $allowNewRoots) {
                        $nodeFrom->makeRoot();
                    } else {
                        $nodeFrom->insertAfter($nodeTo);
                    }
                } elseif ($dir == 'r') {
                    $nodeFrom->appendTo($nodeTo);
                }
                return $nodeFrom->save();
            }
            return true;
        };
        return self::process($callback, $errorMsg, Yii::t('app', 'The node was moved successfully.'));
    }

    /**
     * Deleting a file or folder
     *
     * @return array|Response
     * @throws NotFoundHttpException
     */
    public function actionDeleteNode()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $postData = Yii::$app->request->post();
        $id = $postData['id'];
        if (empty($id)) {
            return ['out' => $this->getMessages($this->unexpectedError), 'status' => 'error'];
        }
        $nodeModel = self::findModel($id);
        if ($this->isNodeAccess($nodeModel, AccessManager::DELETE)) {
            $nodeModel->removePermission();
            $nodeModel->removeNode(false);
            return ['out' => $this->getMessages($this->successful), 'status' => 'success'];
        }else{
            return ['out' => $this->getMessages($this->permissionsDenied), 'status' => 'error'];
        }

    }

    private function isNodeAccess(KartikTreeNode $kartikTreeNode, $permission)
    {
        $hasNode = $kartikTreeNode->checkPermission($permission);
        $isOwner = $kartikTreeNode->hsTreeNode->user_id === Yii::$app->user->id;

        return $hasNode || $isOwner;
    }

    /**
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return KartikTreeNode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KartikTreeNode::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * @param $errorIndex
     * @param string $type
     */
    private function showMessage($errorIndex, $type = 'error')
    {
        $message = is_numeric($errorIndex) ? $this->getMessages($errorIndex) : $errorIndex;
        Yii::$app->getSession()->setFlash($type, $message);
    }

    /**
     * @return array json
     */
    public function actionType($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (intval($id) === AccessManager::USER) {
            return User::getList();
        } else {
            return ArrayHelper::map(User::getListRoles(), 'name', 'name');
        }
    }

    public function actionNodePermission()
    {
        $postData = Yii::$app->request->post();
        $sumPermission = null;
        $nodeModel = self::findModel($postData['id']);

        if (!$this->isNodeAccess($nodeModel, AccessManager::UPDATE )) {
            $this->showMessage($this->getMessages($this->permissionsDenied));
        }else {
            $sumPermission = !empty($postData['permission']) ? array_sum($postData['permission']) : null;
            $nodeModel->applicant = new AccessApplicant ($postData['list'], 1); # 1 is hardcoded type (1-user, 2-group)
            $nodeModel->assignPermission($sumPermission);
            $this->showMessage(\Yii::t('app', 'Permission updated successfully'), 'success');
        }

        $this->setSelectedNodeData($nodeModel, $postData);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    /**
     * @return string
     */
    public function actionUploadExcel()
    {
        $this->setPhpIniValue();

        $uploadForm = new UploadForm();
        $treeNodeService = new \common\services\TreeNodeService();

        if (Yii::$app->request->isPost) {
            $TreeNodeData = Yii::$app->request->post('KartikTreeNode');
            $hsId = $TreeNodeData['hs_tree_id'];
            $hsModel = HsTree::findOne($hsId);
            $nodesData = $treeNodeService->convertUploadedFileToCSV('importFile', $hsId);
            return $this->render('@modules/hierarchicalStructure/views/backend/default/import-status', [
                'hsModel' => $hsModel,
                'hsId' => $hsId,
                'newNodesFile' =>  $nodesData['newNodesFile'],
                'updateNodesFile' => $nodesData['updateNodesFile'],
                'newNodesCount' => $nodesData['newNodesCount'],
                'nodesToUpdateCount' => $nodesData['nodesToUpdateCount'],
                'errorMessage' => $nodesData['errorMessage'],
            ]);
        }

        return $this->render('@modules/hierarchicalStructure/views/backend/default/upload-excel', [
            'uploadForm' => $uploadForm,
            'node' => new KartikTreeNode(),
        ]);
    }

    /**
     * @return array
     */
    public function actionImportExcel()
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;

        $this->setPhpIniValue();
        $treeNodeService = new \common\services\TreeNodeService();

        return $treeNodeService->importDataFromCSV();
    }

    /**
     * @param int $hsId
     * @param string $tokenValue
     */
    public function actionExportPdf($hsId, $tokenValue = null)
    {
        $this->setPhpIniValue();

        $treeNodeService = new \common\services\TreeNodeService();
        $nodesFromDB = $treeNodeService->getNodesByHsIdWithSortConditions($hsId, 'root, lft, code');

        $hsName = HsTree::findOne($hsId)->name;

        $html = $this->renderPartial('@modules/hierarchicalStructure/export-templates/_pdf', [
            'nodes' => $nodesFromDB,
            'hsName' => $hsName
        ]);

        $mpdf = new \mPDF('c','A4','','' , 10 , 10 , 5 , 5 , 0 , 0, 'L');

        $mpdf->list_indent_first_level = 0;
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;

        $mpdf->WriteHTML($html);
        unset($html);

        $this->sendCookie('downloadPdf', $tokenValue, true);

        $mpdf->Output('report-'.date('mdY').'.pdf', 'D');
        exit;
    }

    /**
     * @param integer $hsId
     */
    public function actionExportExcel($hsId)
    {
        $this->setPhpIniValue();
        $treeNodeService = new \common\services\TreeNodeService();
        $nodesFromDB = $treeNodeService->getNodesByHsIdWithSortConditions($hsId, 'root, lft, code');
        $excel = new ExcelService();
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=hs_export" . date('Y-m-d') . ".xlsx");
        $objWriter = new \PHPExcel_Writer_Excel5($excel->addExcelHs($nodesFromDB));
        $objWriter->save('php://output');
    }

    /**
     * @param int $hsId
     * @param string $tokenValue
     */
    public function actionExportOdt($hsId, $tokenValue = null)
    {
        $this->setPhpIniValue();
        $treeNodeService = new \common\services\TreeNodeService();
        $nodesFromDB = $treeNodeService->getNodesByHsIdWithSortConditions($hsId, 'root, lft, code');
        $data = $treeNodeService->addDataToOdtExport($nodesFromDB);

        $OpenTBS = new OpenTBS;
        $template = Yii::getAlias('@modules').'/hierarchicalStructure/export-templates/nodes-template.odt';
        $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
        $OpenTBS->MergeBlock('a', $data);

        unset($data);

        $this->sendCookie('downloadOdt', $tokenValue, true);

        $OpenTBS->Show(OPENTBS_DOWNLOAD, 'report-'.date('mdY').'.odt');
        exit;
    }

    /**
     * @param $hsId
     * @param $tokenValue
     * @return string
     */
    public function actionExportXml($hsId, $tokenValue = null)
    {
        $this->setPhpIniValue();

        $treeNodeService = new \common\services\TreeNodeService();
        $nodesFromDB = $treeNodeService->getNodesByHsIdWithSortConditions($hsId, 'root, lft, code');

        $data = $treeNodeService->addDataToXmlStructure($nodesFromDB);

        $in = [
            [
                'tag' => 'root',
                'elements' => $data
            ],
        ];
        $xml = new XmlConstructor();

        \Yii::$app->response->setDownloadHeaders('report-'.date('mdY').'.xml', 'application/xml');

        $this->sendCookie('downloadXml', $tokenValue, false);

        return $xml->fromArray($in)->toOutput();
    }

    /**
     * @return string|void
     * @throws ForbiddenHttpException
     */
    public function actionExport()
    {
        if (Yii::$app->request->isPost) {
            $format = Yii::$app->request->post('KartikTreeNode')['format'];
            $hs_id = Yii::$app->request->post('KartikTreeNode')['hs_tree_id'];
            switch ($format) {
                case 'pdf': $this->actionExportPdf($hs_id);
                break;
                case 'odt': $this->actionExportOdt($hs_id);
                break;
                case 'xml': $this->redirect(['export-xml', 'hsId' => $hs_id]);
                break;
                case 'csv': $this->actionExportCsv($hs_id);
                break;
                case 'xlsx': $this->actionExportExcel($hs_id);
                break;
                default: throw new ForbiddenHttpException(Yii::t('app', 'Unknown format'));
            }
        }
        return $this->render('export', [
            'node' => new KartikTreeNode(),
        ]);
    }

    /**
     * Send response with cookies to stop export loader.
     * @param string $name
     * @param string $value
     * @param bool $isResponseSend
     */
    private function sendCookie($name, $value, $isResponseSend)
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => $name,
            'value' => $value,
            'httpOnly' => false,
        ]));
        if ($isResponseSend) Yii::$app->response->send();
    }

    /**
     * Method set php.ini value
     */
    private function setPhpIniValue()
    {
        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '256M');
    }

    /**
     * @param integer $hsId
     * @return $this
     */
    public function actionExportCsv($hsId)
    {
        $this->setPhpIniValue();
        $hs = HsTree::findOne($hsId);
        $treeNodes = new TreeNodeService();
        $nodesFromDB = $treeNodes->getNodesByHsIdWithSortConditions($hsId, 'root, lft, code');
        foreach ($nodesFromDB as $node) {
            $codePath = $node->getCodePath();
            $arrayNode[$codePath]['code'] = $codePath;
            $arrayNode[$codePath]['title'] = $node->name;
            $arrayNode[$codePath]['term'] = $node->hsTreeNode->conservation_term;
            $arrayNode[$codePath]['finalDestination'] = $node->hsTreeNode->finalDestination->abbreviation;
            $arrayNode[$codePath]['description'] = strip_tags($node->hsTreeNode->description);
            $arrayNode[$codePath]['notesForUse'] = strip_tags($node->hsTreeNode->notes_application);
            $arrayNode[$codePath]['notesForExclusion'] = strip_tags($node->hsTreeNode->notes_exclusion);
            unset($node);
        }
        unset($nodesFromDB);
        $filePath = $treeNodes->saveDataToCSV($arrayNode, $hs->name, 'csvNodes');
        return Yii::$app->response->sendFile($filePath);
    }

    /**
     * @param string $move_node_id
     * @param string $internal_node_id
     * @param string $root_element
     * @return string
     */
    public function dragging($move_node_id, $internal_node_id, $root_element)
    {
        $move_node = KartikTreeNode::findOne($move_node_id);
        if ($root_element !== null) {
            return MoveService::transferToRoot($move_node);
        } else {
            return MoveService::movingInsideNodes($move_node, $internal_node_id);
        }
    }
}
