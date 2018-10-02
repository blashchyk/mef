<?php
namespace modules\hierarchicalStructure\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class UploadForm extends Model
{
    const DIR_PATH = '@backend/runtime/uploads/';

    /**
     * @var UploadedFile
     */
    public $importFile;

    public function rules()
    {
        return [
            [['importFile'], 'file',],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'importFile' => Yii::t('app', 'Import File'),
        ];
    }

    /**
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->importFile->saveAs(Yii::getAlias(self::DIR_PATH) . $this->importFile->baseName . '.' . $this->importFile->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function createDir()
    {
        $path = Yii::getAlias(self::DIR_PATH);
        return FileHelper::createDirectory($path);
    }
}