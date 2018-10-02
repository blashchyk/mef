<?php

namespace modules\hierarchicalStructure\controllers\backend;


use common\controllers\BaseController;
use hscstudio\export\OpenTBS;
use modules\hierarchicalStructure\models\Files;
use modules\hierarchicalStructure\models\Records;
use modules\hierarchicalStructure\models\ReportsFiles;
use modules\hierarchicalStructure\models\SearchRecordsEol;
use modules\hierarchicalStructure\models\UnsupportedFiles;
use yii\data\ActiveDataProvider;
use Yii;
use yii\helpers\FileHelper;
use yii\web\Cookie;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ReportsController extends BaseController
{
    const NOT_SUPPORTED = 0;
    const SUPPORTED = 1;
    /**
     * @return array
     */
    public function permissionMapping()
    {
        return [
            'index' => 'hierarchicalStructure.reports.index',
            'support' => 'hierarchicalStructure.reports.update',
            'no-support' => 'hierarchicalStructure.reports.update',
            'eol' => 'hierarchicalStructure.reports.index',
            'update-eol' => 'hierarchicalStructure.reports.update',
            'elimination' => 'hierarchicalStructure.reports.update',
            'generate' => 'hierarchicalStructure.reports.update',
            'generate-pdf' => 'hierarchicalStructure.reports.update',
            'pdf-open' => 'hierarchicalStructure.reports.update',
            'generate-otd' => 'hierarchicalStructure.reports.update',
            'delete' => 'hierarchicalStructure.reports.delete',
            'delete-all' => 'hierarchicalStructure.reports.delete',
            'download-file' => 'hierarchicalStructure.reports.update',
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Files::find()->select(['type', 'version', 'support'])->distinct(),
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'version'  => 'SORT_DESC',
                ]
            ],
        ]);
        return $this->render('reports-list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionEol()
    {
        $query = new SearchRecordsEol();
        $dataProvider = $query->search();
        return $this->render('reports-eol-list', [
            'eol' => $dataProvider,
        ]);
    }

    /**
     * @param float $version
     * @param string$type
     * @param int $support
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSupport($version, $type, $support = self::NOT_SUPPORTED)
    {
        $files = Files::find()->where(['version' => $version, 'type' => $type])->all();
        if ($files === null) {
            throw new NotFoundHttpException('Files not found!');
        }

        foreach ($files as $file) {

            $file->support = $support;
            $file->save();
            $this->unsupportedFile($file, $support);
        }

        return $this->redirect('index');
    }

    /**
     * @param $file
     * @param integer $support
     * @throws ForbiddenHttpException
     */
    protected function unsupportedFile($file, $support)
    {
        $array = explode('/', $file->path);
        $file_name = end($array);
        if ($support === self::NOT_SUPPORTED) {
            $unsupportedFile = new UnsupportedFiles();
            $unsupportedFile->old_file = $file_name;
            $unsupportedFile->reference_code = $file->record->full_code;
            $unsupportedFile->save();
        } else {
            if (!UnsupportedFiles::deleteAll(['reference_code' => $file->record->full_code, 'old_file' => $file_name])) {
                throw new ForbiddenHttpException('Error while deleting');
            }
        }
    }

    /**
     * @param $recordId
     * @return \yii\web\Response
     */
    public function actionUpdateEol($recordId)
    {
        $record = Records::findOne($recordId);
        if (Yii::$app->request->get('eliminate') !== null) {
            $record->eliminate = (int)Yii::$app->request->get('eliminate');
            $record->date = date("Y-m-d", $record->date);
            $record->final_date = !empty($record->final_date) ? date("Y-m-d", $record->final_date) : null;
            if ($record->save()) {
                return $this->redirect('eol');
            }
        }
    }

    public function actionElimination()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ReportsFiles::find(),
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id'  => 'SORT_DESC',
                ]
            ],
        ]);
        return $this->render('elimination', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionGenerate()
    {
        $records = Records::find()->where(['eliminate' => 1])->asArray()->all();
        $treeNodeService = new \common\services\TreeNodeService();
        $data = $treeNodeService->addDataToOdtEolExport($records);
        $report = new ReportsFiles();
        $report->date = date('Y-m-d');
        $report->data_file = json_encode($data);
        if ($report->save()) {
            Records::updateAll(['report' => 1, 'eliminate' => 0], ['id' => array_column($records, 'id')]);
            return $this->redirect('elimination');
        }
    }

    /**
     * @param integer $reportId
     */
    public function actionGenerateOtd($reportId)
    {
        $report = ReportsFiles::findOne($reportId);
        $data = json_decode($report->data_file);
        $OpenTBS = new OpenTBS();
        $template = Yii::getAlias('@modules').'/hierarchicalStructure/export-templates/nodes-eol-template.odt';
        $OpenTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
        $OpenTBS->MergeBlock('a', $data);
        unset($data);
        $this->sendCookie('downloadOdt', null, true);
        $OpenTBS->Show(OPENTBS_DOWNLOAD, 'report-'.date('mdY').'.odt');
        exit;
    }

    /**
     * @param integer $reportId
     * @param null $view
     */
    public function actionGeneratePdf($reportId, $view = null)
    {
        $report = ReportsFiles::findOne($reportId);
        if (Yii::$app->request->isPost) {
            $downloadFile = UploadedFile::getInstance($report, 'file');
            if ($downloadFile !== null) {
                FileHelper::createDirectory(Yii::getAlias('@runtime') . '/exportmef/reports/' . $reportId, 0777, true);
                $report->file =
                    'exportmef/reports/'
                    . $reportId
                    . '/'
                    . $downloadFile->baseName
                    . '.'
                    . $downloadFile->extension;
                $path = Yii::getAlias('@runtime') . '/' . $report->file;
                $downloadFile->saveAs($path);
                $report->save();
                return $this->redirect('elimination');
            }
        }
        return $this->render('add', [
            'reportId' => $reportId,
            'report' => $report,
        ]);
    }

    /**
     * @param integer $reportId
     * @return $this
     */
    public function actionPdfOpen($reportId)
    {
        $report = ReportsFiles::findOne($reportId);

        if ($report->file === null) {
            throw new ForbiddenHttpException('File not found');
        }
        return Yii::$app->response->sendFile(Yii::getAlias('@runtime') . '/' . $report->file);

    }

    /**
     * @param $name
     * @param $value
     * @param $isResponseSend
     */
    private function sendCookie($name, $value, $isResponseSend)
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => $name,
            'value' => $value,
            'httpOnly' => false,
        ]));
        if ($isResponseSend) {
            Yii::$app->response->send();
        }
    }

    /**
     * @param $reportId
     * @return \yii\web\Response
     */
    public function actionDelete($reportId)
    {
        $report = ReportsFiles::findOne($reportId);
        if ($report->delete()) {
            return $this->redirect('elimination');
        }
    }

    /**
     * @param integer $id
     * @return $this
     * @throws ForbiddenHttpException
     */
    public function actionDownloadFile($id)
    {
        $report = ReportsFiles::findOne($id);
        if ($report === null) {
            throw new ForbiddenHttpException('File not found');
        }
        return Yii::$app->response->sendFile(Yii::getAlias('@backend') . '/runtime/' . $report->file);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteAll()
    {
        if (Records::deleteAll(['report' => 1])) {
            return $this->redirect('eol');
        }
    }
}
