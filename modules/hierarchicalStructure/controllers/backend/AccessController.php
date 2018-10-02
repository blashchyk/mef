<?php

namespace modules\hierarchicalStructure\controllers\backend;


use bupy7\xml\constructor\XmlConstructor;
use common\controllers\BaseController;
use common\services\ExcelService;
use common\services\FundService;
use modules\hierarchicalStructure\models\AccessRequests;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\KartikTreeNode;
use modules\hierarchicalStructure\models\Records;
use modules\setting\models\Setting;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\web\ForbiddenHttpException;
use Yii;

class AccessController extends BaseController
{
    /**
     * @return array
     */
    public function permissionMapping()
    {
        return [
            'index' => 'accessRequests.backend.index',
            'create' => 'accessRequests.backend.create',
            'update' => 'accessRequests.backend.update',
            'delete' => 'accessRequests.backend.delete',
            'email' => 'accessRequests.backend.index',
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AccessRequests::find(),
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id'  => 'SORT_DESC',
                ]
            ],
        ]);
        return $this->render('access-list', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $request = new AccessRequests();

        if ($request->load(\Yii::$app->request->post()) && $request->save()) {
            return $this->redirect(['/hierarchicalStructure/access/index']);
        } else {
            return $this->render('access-create', [
                'request' => $request,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $request = AccessRequests::findOne($id);

        if ($request->load(\Yii::$app->request->post()) && $request->save()) {
            return $this->redirect(['/hierarchicalStructure/access/index']);
        } else {
            return $this->render('access-update', [
                'request' => $request,
            ]);
        }
    }

    /**
     * @param integer $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     */
    public function actionDelete($id)
    {
        $request = AccessRequests::findOne($id);
        if ($request->delete()) {
            return $this->redirect('index');
        } else {
            throw new ForbiddenHttpException('Data could not be deleted');
        }
    }

    public function actionEmail($id)
    {
        $this->setPhpIniValue();
        $request = AccessRequests::findOne($id);
        $fund = Funds::findOne(['code' => $request->code]);
        $record = Records::findOne(['full_code' => $request->code]);
        if (empty($fund) && empty($record)) {
            throw new ForbiddenHttpException('There is no such fund.');
        }
        $records = Records::find()->where(['fond_id' => $fund->id])->orderBy(['node_id' => SORT_ASC])->all();
        $message = \Yii::$app->mailer->compose();
        if ($request->pdf === 1 && $fund) {

            $html = $this->renderPartial('../funds/export-templates/_pdf_fund', [
                'fund' => $fund,
                'records' => $records,
            ]);
        } elseif ($request->pdf === 1 && $record) {
            $html = $this->renderPartial('../funds/export-templates/_pdf_record', [
                'record' => $record,
            ]);
        }
        $mpdf = new \mPDF('c', 'A4', '', '', 10, 10, 5, 5, 0, 0, 'L');
        $mpdf->list_indent_first_level = 0;
        $mpdf->useSubstitutions = false;
        $mpdf->simpleTables = true;
        $mpdf->WriteHTML($html);
        unset($html);
        FileHelper::createDirectory(\Yii::getAlias('@runtime') . '/well', 0775, true);
        $path[0] = \Yii::getAlias('@runtime') . '/well/report-' . date('mdY') . '.pdf';
        $mpdf->Output($path[0], 'F');
        $message->attach($path[0]);
        if ($request->excel === 1 && $fund) {
            $ecxel = new ExcelService();
            $objWriter = new \PHPExcel_Writer_Excel5($ecxel->addExcelFile($fund, $records));
            $path[1] = Yii::getAlias('@runtime') . '/well/excel-' . date('mdY') . '.xls';
            $objWriter->save($path[1]);
            $message->attach($path[1]);
        } elseif ($request->excel && $record) {
            $ecxel = new ExcelService();
            $objWriter = new \PHPExcel_Writer_Excel5($ecxel->addExcelFileNoFond($record));
            $path[1] = Yii::getAlias('@runtime') . '/well/excel-' . date('mdY') . '.xls';
            $objWriter->save($path[1]);
            $message->attach($path[1]);
        }
        if ($request->xml === 1 && $fund) {
            $this->setPhpIniValue();
            $fundService = new FundService();
            $data = $fundService->addFundStructureToXml($fund);
            $in = [
                [
                    'tag' => 'root',
                    'elements' => $data,
                ],
            ];
            $xml = new XmlConstructor();
            $dom_xml= new \DOMDocument();
            $dom_xml->loadXML($xml->fromArray($in)->toOutput());
            $path[2] = Yii::getAlias('@runtime') . '/well/xml-' . date('mdY') . '.xml';
            $dom_xml->save($path[2]);
            $message->attach($path[2]);
        }
            $message
            ->setFrom(Setting::findOne(['key' => 'email_sent_from'])->value)
            ->setTo($request->email)
            ->setSubject($fund->code)
            ->setTextBody($fund->title);
        if ($fund == null) {
            $message
                ->setSubject($record->full_code)
                ->setTextBody($record->title);
        }
        if ($message->send()) {
            $request->confirmation = 1;
            $request->save();
            $session = Yii::$app->session;
            $session->set('message', 'Email sent');
            $this->deleteFiles($path);
            return $this->redirect('index');
        } else {
            throw new ForbiddenHttpException('Message not sent');
        }
    }

    private function setPhpIniValue()
    {
        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '1024M');
    }

    /**
     * @param array $path
     */
    private function deleteFiles($path)
    {
        foreach ($path as $value) {
            unlink($value);
        }
    }
}
