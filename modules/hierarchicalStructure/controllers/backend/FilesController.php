<?php

namespace modules\hierarchicalStructure\controllers\backend;

use common\controllers\BaseController;
use common\services\FundService;
use modules\hierarchicalStructure\models\Files;
use modules\hierarchicalStructure\models\Records;
use modules\hierarchicalStructure\models\UnsupportedFiles;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;

class FilesController extends BaseController
{
    /**
     * @return array
     */
    public function permissionMapping()
    {
        return [
            'index' => 'hierarchicalStructure.files.index',
            'update' => 'hierarchicalStructure.files.update',
            'archiving' => 'hierarchicalStructure.files.update',
            'archive-download' => 'hierarchicalStructure.files.update',
            'replace' => 'hierarchicalStructure.files.update',
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UnsupportedFiles::find(),
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id'  => 'SORT_ASC',
                ]
            ],
        ]);
        $file = new Files();
        return $this->render(
            'files-list',
            [
                'dataProvider' => $dataProvider,
                'file' => $file
            ]
        );
    }

    /**
     * @param integer $fileId
     * @return string
     */
    public function actionUpdate($fileId)
    {
        $recordFile = Files::findOne($fileId)->record;
        $file = new Files();
        if (!empty(Yii::$app->request->post('Files'))) {
            $this->download($file, Yii::$app->request->post('Files')['record_id']);
            $this->deleteFile($fileId);
        }
        return $this->render(
            'update',
            [
                'file' => $file,
                'record' => $recordFile,
                'fileId' => $fileId,
            ]
        );
    }

    /**
     * @param object $file
     * @param integer $record_id
     */
    protected function download($file, $recordId)
    {
        $downloadFile = UploadedFile::getInstance($file, 'path');
        if ($downloadFile !== null) {
            $file->record_id = $recordId;
            $file->path = 'exportmef/' . $recordId . '/' . $downloadFile->baseName . '.' . $downloadFile->extension;
            $path = Yii::getAlias('@runtime') . '/' . $file->path;
            $downloadFile->saveAs($path);
            $file->type = FileHelper::getMimeType($path);
            $file->version = FundService::versionFile($path);
            $file->save();
        }
    }


    /**
     * @param integer$id
     * @return string
     * @throws NotFoundHttpException
     */
    private function deleteFile($id)
    {
        $file = Files::findOne($id);
        if ($file === null) {
            throw new NotFoundHttpException('File not found');
        }
        if ($file->delete() && unlink(Yii::getAlias('@runtime/') . $file->path)) {
            return $this->redirect('index');
        }
    }

    /**
     * @return $this|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionArchiving()
    {
        $unsupported_files = UnsupportedFiles::find()->all();
        if (empty($unsupported_files)) {
            throw new ForbiddenHttpException('No unsupported files');
        }
        $zip = new \ZipArchive();
        $archive = Yii::getAlias('@backend') . '/runtime/exportmef/export_files.zip';
        $res = $zip->open($archive, \ZipArchive::CREATE);

        if ($res === true) {
            $files = Files::findAll(['support' => 0]);
            if ($files !== null) {
                foreach ($files as $file) {
                    $move_file = Files::findOne($file->id);
                    $path = Yii::getAlias('@backend') . '/runtime/' . $file->path;
                    $file_info = new \SplFileInfo($path);
                    $zip->addFile($path, $move_file->record->full_code . '/' . $file_info->getFilename());
                }
                if ($zip->close() === true) {
                    return Yii::$app->response->sendFile(Yii::getAlias('@backend') . '/runtime/exportmef/export_files.zip');
                } else {
                    throw new BadRequestHttpException('Could not close file');
                }
            }
            return $this->redirect('index');
        } else {
            $this->errorMessage($res);
        }
    }

    /**
     * @throws BadRequestHttpException
     */
    public function actionArchiveDownload()
    {
        $unsupported_files = UnsupportedFiles::find()->all();
        if (empty($unsupported_files)) {
            throw new ForbiddenHttpException('No unsupported files');
        }
        $file = new Files();
        $downloadFile = UploadedFile::getInstance($file, 'archive');
        if ($downloadFile !== null) {
            $path = Yii::getAlias('@runtime') . '/exportmef/export_files.' . $downloadFile->extension;
            $downloadFile->saveAs($path);
            $zip =  new  \ZipArchive();
                $res = $zip->open($path);
                if ($res === true) {
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $stat = $zip->statIndex($i);
                        $archive_item = explode('/', $stat['name']);
                        $unsupportedFile = UnsupportedFiles::findOne(['reference_code' => $archive_item[0]]);
                        if ($unsupportedFile !== null) {
                            $unsupportedFile->new_file = $stat['name'];
                            $unsupportedFile->save();
                        }
                    }
                    if (!$zip->close()) {
                        throw new BadRequestHttpException('Could not close file');
                    }
                } else {
                    $this->errorMessage($res);
                }
        }
        $this->redirect('index');
    }

    /**
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     * @throws Exception
     */
    public function actionReplace()
    {
        $id = array_keys(Yii::$app->request->post());

        $unsupportedFile = UnsupportedFiles::findAll($id);
        $zip_path = Yii::getAlias('@runtime') . '/exportmef/export_files.zip';
        foreach ($unsupportedFile as $file) {
            $records = Records::findOne(['full_code' => $file->reference_code]);
            $path = 'exportmef/' . $records->id . '/' . $file->old_file;
            $zip = new  \ZipArchive();
            $res = $zip->open($zip_path);
            if ($res === true) {
                $this->addNewFiles($zip, $file);
            } else {
                $this->errorMessage($res);
            }
            if (!Files::deleteAll(['path' => $path])) {
                throw new Exception('Error while deleting');
            }

            unlink(Yii::getAlias('@runtime/') . $path);
            if (!$zip->close()) {
                throw new BadRequestHttpException('Could not close file');
            }
            if (!$file->delete()) {
                throw new BadRequestHttpException('Unable to delete file data');
            }
        }
        unlink($zip_path);
        return $this->redirect('index');
    }

    protected function addNewFiles($zip, $file)
    {
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            $code = explode('/', $stat['name']);
            if ($code[0] == $file->reference_code) {
                $zip->renameName($stat['name'], explode('/', $stat['name'])[1]);
                $record = Records::findOne(['full_code' => $code[0]]);
                $zip->extractTo(Yii::getAlias('@runtime/exportmef/' . $record->id), explode('/', $stat['name'])[1]);
                $new_file = new Files();
                $new_file->record_id = $record->id;
                $path = 'exportmef/' . $record->id . '/' . explode('/', $stat['name'])[1];
                $new_file->path = $path;
                $new_file->type = FileHelper::getMimeType(Yii::getAlias('@backend') . '/runtime/' . $path);
                $new_file->support = 1;
                $new_file->version = FundService::versionFile(Yii::getAlias('@backend') . '/runtime/' . $path);
                $new_file->save();
            }
        }
    }

    /**
     * @param $res
     * @throws BadRequestHttpException
     */
    protected function errorMessage($res)
    {
        switch ($res) {
            case \ZipArchive::ER_EXISTS:
                $ErrMsg = "File already exists.";
                break;

            case \ZipArchive::ER_INCONS:
                $ErrMsg = "Zip archive inconsistent.";
                break;

            case \ZipArchive::ER_MEMORY:
                $ErrMsg = "Malloc failure.";
                break;

            case \ZipArchive::ER_NOENT:
                $ErrMsg = "No such file.";
                break;

            case \ZipArchive::ER_NOZIP:
                $ErrMsg = "Not a zip archive.";
                break;

            case \ZipArchive::ER_OPEN:
                $ErrMsg = "Can't open file.";
                break;

            case \ZipArchive::ER_READ:
                $ErrMsg = "Read error.";
                break;

            case \ZipArchive::ER_SEEK:
                $ErrMsg = "Seek error.";
                break;

            default:
                $ErrMsg = "Unknow (Code $res)";
                break;
        }
        throw new BadRequestHttpException('ZipArchive Error: ' . $ErrMsg);
    }
}
