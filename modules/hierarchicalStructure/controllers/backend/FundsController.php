<?php

namespace modules\hierarchicalStructure\controllers\backend;

use common\controllers\BaseController;
use common\services\CodeService;
use common\services\DeleteService;
use common\services\FundService;
use common\services\MoveService;
use modules\hierarchicalStructure\models\ConnectionFundsStructure;
use modules\hierarchicalStructure\models\Files;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\models\HsTreeNode;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\Records;
use modules\hierarchicalStructure\models\UploadForm;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

/**
 * Class FundsController
 * @package modules\hierarchicalStructure\controllers\backend
 */
class FundsController extends BaseController
{
    use StructureHelper;
    use ExportHelper;

    const DELIMITER = '.';
    const RECORD_TYPE = 2;
    const WITHOUT_HS = 'Without HS';
    const DELIMITER_RECORDS = '-';
    const NODE_TYPE = 1;
    const PLUS = ' + ';

    /**
     * @return array
     */
    public function permissionMapping()
    {
        return [
            'index' => 'hierarchicalStructure.funds.index',
            'view' => 'hierarchicalStructure.funds.index',
            'create' => 'hierarchicalStructure.funds.create',
            'update' => 'hierarchicalStructure.funds.update',
            'delete' => 'hierarchicalStructure.funds.delete',
            'create-records' => 'hierarchicalStructure.funds.create',
            'update-records' => 'hierarchicalStructure.funds.update',
            'delete-records' => 'hierarchicalStructure.funds.delete',
            'download-file' => 'hierarchicalStructure.funds.update',
            'import' => 'hierarchicalStructure.funds.create',
            'delete-file' => 'hierarchicalStructure.funds.delete',
            'export' => 'hierarchicalStructure.funds.index',
            'export-xml' => 'hierarchicalStructure.funds.index',
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Funds::find(),
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id'  => 'SORT_ASC',
                ]
            ],
        ]);
        return $this->render('funds-list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $fundId
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($fundId, $id = null)
    {
        $params = Yii::$app->request->get();
        $fund = Funds::findOne($fundId);
        if (empty($fund)) {
            throw new NotFoundHttpException('Fund is not found!');
        }
        if ($params['move_node_id'] || $params['parent_id']) {
            return $this->dragging($params['move_node_id'], $params['parent_id'], $params['root']);
        }
        if (isset($params['chenge_tree'])) {
            $fund->tree = $params['chenge_tree'] == 0 ? 1 : 0;
            $fund->save();
        }
        $records = Records::find()->where(['fond_id' => $fund->id])->orderBy(['node_id' => SORT_ASC])->all();
        $disabledButtons = [];
        return $this->render('index', [
            'isAdmin' => true,
            'fund' => $fund,
            'disabledButtons' => $disabledButtons,
            'records' => $records,
            'id' => $id,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $fund = new Funds();
        if ($fund->load(Yii::$app->request->post()) && $fund->save()) {
            $formHsTree = array_unique(Yii::$app->request->post('Funds')['formHsTree']);
            if (!empty($formHsTree[0])) {
                foreach ($formHsTree as $item) {
                    $hs = HsTree::findOne($item);
                    $fund->link("hsTree", $hs);
                }
            } else {
                $hs = new HsTree();
                $hs->name = self::WITHOUT_HS;
                $hs->key = uniqid(5);
                $hs->type = 2;
                $hs->save();
                $fund->link("hsTree", $hs);
            }
            return $this->redirect('index');
        } else {
            return $this->render('funds-create', [
                'fund' => $fund,
            ]);
        }
    }

    /**
     * @param $fundId
     * @return string|\yii\web\Response
     */
    public function actionUpdate($fundId)
    {
        $fund = Funds::findOne($fundId);
        if (Yii::$app->request->get('public') !== null) {
            $fund->public_fund = (int)Yii::$app->request->get('public');
            if ($fund->save()) {
                Records::updateAll(['public' => (int)Yii::$app->request->get('public')], ['fond_id' => $fundId]);
                return $this->redirect('index');
            }
        }
        if (isset(Yii::$app->request->post('Funds')['dateFormat'])) {
            $fund->date = Yii::$app->request->post('Funds')['dateFormat'];
        }
        if (isset(Yii::$app->request->post('Funds')['dateFormat'])) {
            $fund->final_date = Yii::$app->request->post('Funds')['finalDate'];
        }
        if ($fund->load(Yii::$app->request->post()) && $fund->save()) {
            $hsTree = array_unique(Yii::$app->request->post('Funds')['formHsTree']);
            if (empty($hsTree[0])) {
                $hsTree[0] = $fund->hsTree[0]->id;
            }
            $this->saveUpdateFunds($fundId, $hsTree);
            return $this->redirect('index');
        } else {
            return $this->render('fund-update', [
                'fund' => $fund,
            ]);
        }
    }

    /**
     * @param integer $fundId
     */
    public function actionDelete($fundId)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $delete_funds = ArrayHelper::getColumn(
                ConnectionFundsStructure::find()
                    ->select('fund_id')
                    ->where(['fund_id' => $fundId])
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
            if (!KartikTreeNode::deleteAll(['fund_id' => $delete_funds])) {
                throw new \yii\base\Exception('Error while deleting');
            }
            if (!empty($delete_records)) {
                DeleteService::deleteRecord(...$delete_funds);
            }
            if (!empty($delete_files)) {
                DeleteService::deleteFiles(...$delete_records);
                foreach ($delete_files as $file_path) {
                    unlink(\Yii::getAlias('@runtime/') . $file_path);
                }
            }
            $transaction->commit();

        } catch (Exception $e) {
            $transaction->rollBack();
        }
        $this->redirect('index');
    }

    /**
     * @param integer $fundId
     * @param integer $hsTree
     */
    protected function saveUpdateFunds($fundId, $hsTree)
    {
        $fund = Funds::find('id')->with('hsTree')->where(['id' => $fundId])->one();
        $connections = $fund->hsTree;
        $arrayStored = ArrayHelper::getColumn($connections, 'id');
        $delete = array_diff($arrayStored, $hsTree);
        $addition = array_diff($hsTree, $arrayStored);
        ConnectionFundsStructure::deleteAll(['fund_id' => $fundId, 'hs_id' => $delete]);
        foreach ($addition as $item) {
            $hs = HsTree::findOne($item);
            if ($hs === null) {
                throw new NotFoundHttpException('HS not found');
            }
            $fund->link('hsTree', $hs);
        }
    }

    /**
     * @param integer $fundId
     * @return string|\yii\web\Response
     */
    public function actionCreateRecords($fundId)
    {
        $record = new Records();
        $file = new Files();
        $fund = Funds::findOne($fundId);
        foreach ($fund->hsTree as $value) {
            $allNodes[] = $this->getAllLowerNodes($fundId, $value->id);
        }
        if ($record->load(Yii::$app->request->post()) && $record->validate()) {

            $post = Yii::$app->request->post('Records');
            $this->creatingRecordInSeveralStructures($record, $post, $fundId);
            $this->download($file, $record->id);
            return $this->redirect(Url::to(['view', 'fundId' => $fundId]));
        } else {
            return $this->render('records-create', [
                'record' => $record,
                'fundId' => $fundId,
                'file' => $file,
                'allNodes' => $allNodes,
            ]);
        }
    }

    /**
     * @param object $record
     * @param array $post
     * @param integer $fundId
     */
    public function creatingRecordInSeveralStructures($record, $post, $fundId)
    {
        foreach ($post['node_id'] as $node_id) {
            if (empty($node_id)) {
                continue;
            }
            if ($node_id == $post['fond_id'] || $node_id == '') {
                $postData['KartikTreeNode'] = [
                    'name' => $post['title'],
                    'type' => 2,
                    'hs_tree_id' => ConnectionFundsStructure::findOne(['fund_id' => $fundId])->hs_id,
                    'fund_id' => $fundId,
                ];
                $node = new KartikTreeNode();
                $node->activeOrig = $node->active;
                $node->load($postData);
                $node->makeRoot();
                $node->save();
                $record->node_id = $node->id;
                $record->save();
            } else {
                $parent_id = $node_id;
                $code = Yii::$app->request->post('Records')['code'];
                $parent = KartikTreeNode::findOne($parent_id);
                $children = $parent->children()->select('id')->asArray()->all();

                $node = new KartikTreeNode();
                $node->activeOrig = $node->active;
                $node->name = $record->title;
                $node->fund_id = $fundId;
                if (!empty($children)) {
                    $max = $this->sortChildren($children, $code);
                    $node = $this->saveNode($node, $max, $node_id);
                } else {
                    $nodeModel = KartikTreeNode::findOne($parent_id);
                    $node->hs_tree_id = $nodeModel->hs_tree_id;
                    $node->appendTo($nodeModel);
                }
                $node->type = self::RECORD_TYPE;
                if ($node->save()) {
                    $parent_hs_tree_node = HsTreeNode::findOne($node_id);
                    $hs_tree_node = HsTreeNode::findOne($node->id);
                    $hs_tree_node->conservation_term = $parent_hs_tree_node->conservation_term;
                    $hs_tree_node->final_destination_id = $parent_hs_tree_node->final_destination_id;
                    $hs_tree_node->save();
                    $record->node_id = $node->id;
                    $record->full_code = CodeService::getFullCodeRecord($record);
                    $record->save();
                }
            }
        }
    }

    /**
     * @param object $node
     * @param array $max
     * @return mixed
     */
    private function saveNode($node, $max, $node_id)
    {
        if (isset($max['after'])) {
            $nodeModel = KartikTreeNode::findOne($max['after']);
            $node->hs_tree_id = $nodeModel->hs_tree_id;
            $node->insertAfter($nodeModel);
            $parent_hs_tree_node = HsTreeNode::findOne($node_id);
            $hs_tree_node = HsTreeNode::findOne($node->id);
            $hs_tree_node->conservation_term = $parent_hs_tree_node->conservation_term;
            $hs_tree_node->final_destination_id = $parent_hs_tree_node->final_destination_id;
            $hs_tree_node->save();
        } else {
            $nodeModel = KartikTreeNode::findOne($max['before']);
            $node->hs_tree_id = $nodeModel->hs_tree_id;
            $node->insertBefore($nodeModel);
            $parent_hs_tree_node = HsTreeNode::findOne($node_id);
            $hs_tree_node = HsTreeNode::findOne($node->id);
            $hs_tree_node->conservation_term = $parent_hs_tree_node->conservation_term;
            $hs_tree_node->final_destination_id = $parent_hs_tree_node->final_destination_id;
            $hs_tree_node->save();
        }
        return $node;
    }

    /**
     * @param array $children
     * @param string $code
     * @return int|string
     */
    protected function sortChildren($children, $code)
    {
        $q = Records::find()->where(['node_id' => array_column($children, 'id')]);
        $result = $q->all();
        $code_sort = array();
        foreach ($result as $key => $row) {
            $code_sort[$key] = $row->code;
        }
        array_multisort($code_sort, SORT_DESC, $result);

        foreach ($result as $value) {
            $max = ['before' => $value->node_id];
            if ($value->code < $code) {
                $max = ['after' => $value->node_id];
                break;
            }
        }
        return $max;
    }



    /**
     * @param integer $recordId
     * @return string|\yii\web\Response
     */
    public function actionUpdateRecords($recordId)
    {
        $record = Records::findOne($recordId);
        $file = new Files();
        if (isset(Yii::$app->request->post('Records')['dateFormat'])) {
            $record->date = Yii::$app->request->post('Records')['dateFormat'];
        }
        if (isset(Yii::$app->request->post('Records')['dateFormat'])) {
            $record->final_date = Yii::$app->request->post('Records')['finalDate'];
        }

        if ($record->load(Yii::$app->request->post()) && $record->save()) {
            $update_node = KartikTreeNode::findOne($record->node_id);
            $parent = $update_node->parents(1)->one();
            $childrens = $parent->children(1)->all();
            foreach ($childrens as $children) {
                $code_childrens[$children->id] = Records::findOne(['node_id' => $children->id])->code;
            }
            MoveService::saveNode($update_node, $code_childrens);
            $this->download($file, $record->id);
            $active = Yii::$app->request->post('active');
            if ($active == '#download') {
                $active = substr($active, 1);
                return $this->redirect(Url::to(['update-records', 'recordId' => $record->id, 'active' => $active]));
            }
        }
        return $this->redirect(['view', 'fundId' => $record->fond_id]);
    }

    /**
     * @param $recordId
     * @return \yii\web\Response
     */
    public function actionDeleteRecords($recordId)
    {
        $record = Records::findOne($recordId);
        $nodeModel = KartikTreeNode::findOne($record->node_id);
        $nodeModel->removeNode(false);
        $files = Files::findAll(['record_id' => $recordId]);
        if ($record->delete() && Files::deleteAll(['record_id' => $recordId])) {
            foreach ($files as $file) {
                unlink(Yii::getAlias('@runtime/') . $file->path);
            }
        }
        return $this->redirect(Url::to(['view', 'fundId' => $record->fond_id]));
    }

    /**
     * @param integer $id
     * @throws NotFoundHttpException
     */
    public function actionDeleteFile($id)
    {
        $file = Files::findOne($id);
        if ($file === null) {
            throw new NotFoundHttpException('File not found');
        }
        $active = Yii::$app->request->get('fundId');
        if ($file->delete() && unlink(Yii::getAlias('@runtime/') . $file->path)) {

            if (Yii::$app->request->get('view') == 'files') {
                return $this->redirect(Url::to(['files/index']));
            }
            $this->redirect(Url::to(['funds/view', 'fundId' => $active]));
        }
    }

    /**
     * @param integer $file
     * @param integer $recordId
     */
    public function download($file, $recordId)
    {
        $downloadFile = UploadedFile::getInstance($file, 'path');
        if ($downloadFile !== null) {
            $file->record_id = $recordId;
            FileHelper::createDirectory(
                Yii::getAlias('@runtime') . '/exportmef/' . $recordId,
                0777,
                true
            );
            $file->path = 'exportmef/' . $recordId . '/' . $downloadFile->baseName . '.' . $downloadFile->extension;
            $path = Yii::getAlias('@runtime') . '/' . $file->path;
            $downloadFile->saveAs($path);
            $file->type = FileHelper::getMimeType($path);
            $file->version = FundService::versionFile($path);
            $file->save();
        }
    }

    /**
     * @param integer $id
     * @return $this
     * @throws ForbiddenHttpException
     */
    public function actionDownloadFile($id)
    {
        $file = Files::findOne($id);
        if ($file === null) {
            throw new ForbiddenHttpException('File not found');
        }
        return Yii::$app->response->sendFile(Yii::getAlias('@backend') . '/runtime/' . $file->path);
    }

    /**
     * @return string
     */
    public function actionImport()
    {
        $this->setPhpIniValue();
        $uploadForm = new UploadForm();
        $fundServices = new FundService();
        if (Yii::$app->request->isPost) {
            $nodesData = $fundServices->convertUploadedFileToCSV('importFile');
            return $this->render('import-status', [
                'errorMessage' => $nodesData['errorMessage'],
            ]);
        }
        return $this->render('upload-excel', [
            'uploadForm' => $uploadForm,
            ]
        );
    }

    /**
     * @param integer $node_id
     * @return string
     */
    public static function getCodeRecordParent($node_id)
    {
        $result = [];
        $id = $node_id;
        while ($id > 0) {
            $parent_id = KartikTreeNode::findOne($id)->getParentNodeId();
            $id = $parent_id;
            $result[] = $parent_id;
        }
        foreach ($result as $value) {
            if (Records::findOne(['node_id' => $value]) === null) {
                break;
            }
            $record_code[] = Records::findOne(['node_id' => $value])->code;
        }
        if (!empty($record_code)) {
            $parent_record_code = implode(self::DELIMITER_RECORDS, array_reverse($record_code));
        }
        return $parent_record_code;
    }

    public function actionExport()
    {

        if (Yii::$app->request->isPost) {
            $format = Yii::$app->request->post('KartikTreeNode')['format'];
            $fund_id = Yii::$app->request->post('KartikTreeNode')['name'];
            switch ($format) {
                case 'pdf': $this->exportPdf($fund_id);
                    break;
                case 'xml': $this->redirect(['export-xml', 'fundId' => $fund_id]);
                    break;
                case 'xlsx': $this->exportExcel($fund_id);
                    break;
                case 'odt': $this->exportOdt($fund_id);
                    break;
                case 'csv': $this->exportCsv($fund_id);
                    break;
                default: throw new ForbiddenHttpException(Yii::t('app', 'Unknown format'));
            }
        }
        return $this->render('export', [
            'funds' => new KartikTreeNode(),
        ]);
    }
}
