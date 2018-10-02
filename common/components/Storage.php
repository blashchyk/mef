<?php

namespace common\components;

use Yii;
use yii\base\Object;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;

class Storage extends Object
{
    const PREFIX_THUMBNAIL = 'thumbnail-';
    const DIR_USER = 'user';
    const DIR_MEDIA = 'media';
    const DIR_PRODUCT = 'product';
    const DIR_QUOTE = 'quote';
    const DIR_SLIDER = 'slider';
    const DIR_LOTTERY = 'lottery';
    const DIR_CAMPAIGN = 'campaign';

    const ERROR_NO_FILE = 1;
    const ERROR_EMPTY_FILE = 2;
    const ERROR_WRONG_FORMAT = 3;
    const ERROR_UPLOAD_ERROR = 4;

    private $directories = [
        'User' => self::DIR_USER,
        'Media' => self::DIR_MEDIA,
        'Product' => self::DIR_PRODUCT,
        'Quote' => self::DIR_QUOTE,
        'Slider' => self::DIR_SLIDER,
    ];

    public static $imageMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    public static $videoMimeTypes = ['video/quicktime', 'video/mp4', 'video/webm', 'video/ogg', 'video/x-msvideo'];

    private $_storagePath = null;
    private $_storageUrl = null;
    private $_defaultImage = null;

    private $_width = null;
    private $_height = null;

    private $_errorCode = null;

    /**
     * Storage constructor.
     */
    public function __construct()
    {
        $this->_storagePath = Yii::getAlias('@image.storage');
        $this->_storageUrl = Yii::getAlias('@image.url');
        $this->_defaultImage = Yii::getAlias('@image.default');

        $params = Yii::$app->params;
        $this->_width = $params['image']['width'];
        $this->_height = $params['image']['height'];
    }

    /**
     * @return array
     */
    private static function getMessages()
    {
        return [
            self::ERROR_NO_FILE => Yii::t('app', 'No file uploaded.'),
            self::ERROR_EMPTY_FILE => Yii::t('app', 'The file is empty.'),
            self::ERROR_WRONG_FORMAT => Yii::t('app', 'Wrong image format. Allowed formats are jpg, png and gif.'),
            self::ERROR_UPLOAD_ERROR => Yii::t('app', 'File uploading error. No writing/modifying file permission.'),
        ];
    }

    /**
     * @param $entity
     * @param $fieldName
     * @param null $inputName
     * @return null|string
     */
    public function getImageName($entity, $fieldName, $inputName = null)
    {
        $file = $this->getFile($entity, $fieldName, $inputName);

        $imageName = null;
        if (!empty($file)) {
            $time = new \DateTime('now');
            $imageName = $time->getTimestamp() . '.' . $file->extension;
        } elseif (!$entity->isNewRecord && Yii::$app->controller->action->id != 'delete-image') {
            if ($entity->getAttribute($fieldName) != null) {
                $imageName = $entity->getAttribute($fieldName);
            } else {
                $this->deleteImage($entity);
            }
        }

        return $imageName;
    }

    /**
     * @param $entity
     * @param $fieldName
     * @param null $inputName
     * @return bool
     */
    public function saveImage($entity, $fieldName, $inputName = null)
    {
        $file = $this->getFile($entity, $fieldName, $inputName);

        if (!empty($file) && ($entity->getAttribute($fieldName))) {
            $filePath = $this->_storagePath . '/' . $this->getDirName($entity) . '/' . $entity->id;
            $fullName = $filePath . '/' . $entity->getAttribute($fieldName);
            $thumbnailName = $filePath . '/' . self::PREFIX_THUMBNAIL . $entity->getAttribute($fieldName);

            $this->createDir($filePath);
            $this->clearDir($filePath);

            if ($file->saveAs($fullName)) {
                if (in_array($file->type, self::$imageMimeTypes)) {
                    $this->saveThumbnail($fullName, $thumbnailName);
                }
            } else {
                $this->_errorCode = self::ERROR_UPLOAD_ERROR;
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param $entity
     * @param $fieldName
     * @param null $inputName
     * @return null|UploadedFile
     * @throws \yii\base\InvalidConfigException
     */
    public function getFile($entity, $fieldName, $inputName = null)
    {
        $file = null;
        if (empty($inputName)) {
            $file = UploadedFile::getInstance($entity, $fieldName);
        } else {
            $file = UploadedFile::getInstanceByName($inputName);
        }

        if ($file == null) {
            $this->_errorCode = self::ERROR_NO_FILE;
        } elseif ($file->size == 0) {
            $this->_errorCode = self::ERROR_EMPTY_FILE;
            return null;
        } elseif (!in_array(FileHelper::getMimeType($file->tempName), array_merge(self::$imageMimeTypes, self::$videoMimeTypes))) {
            $this->_errorCode = self::ERROR_WRONG_FORMAT;
            return null;
        } elseif ($file->tempName == null) {
            $this->_errorCode = self::ERROR_NO_FILE;
            return null;
        }

        return $file;
    }

    /**
     * @param $fullName
     * @param $thumbnailName
     * @return static
     */
    public function saveThumbnail($fullName, $thumbnailName)
    {
        $imagine = new Image();
        $tools = $imagine->getImagine();
        $image = $tools->open($fullName);
        $size = $image->getSize();
        $width = $size->getWidth();
        $height = $size->getHeight();

        if ($width > $height) {
            $this->_height = (int) ($this->_width / $width * $height);
        } else {
            $this->_width = (int) ($this->_height / $height * $width);
        }

        return $imagine::thumbnail($fullName, $this->_width, $this->_height)->save($thumbnailName);
    }

    /**
     * @param $entity
     */
    public function deleteImage($entity)
    {
        $filePath = $this->_storagePath . '/' . $this->getDirName($entity) . '/' . $entity->id;
        $this->clearDir($filePath);
        $this->deleteDir($filePath);
    }

    /**
     * @param $entity
     * @param $fieldName
     * @param bool $isThumbnail
     * @return bool|null|string
     */
    public function getImageUrl($entity, $fieldName, $isThumbnail = false)
    {
        if ($entity->getAttribute($fieldName) == null) {
            return $this->_defaultImage;
        }

        return $this->_storageUrl . '/'
            . $this->getDirName($entity) . '/'
            . $entity->id . '/'
            . ($isThumbnail ? self::PREFIX_THUMBNAIL : '')
            . $entity->getAttribute($fieldName);
    }

    /**
     * @param $entity
     * @param $fieldName
     * @param $url
     * @return bool
     */
    public function copyImageFromUrl($entity, $fieldName, $url)
    {
        if (empty($url)) {
            return false;
        }

        $extension = pathinfo($url)['extension'];
        if (strpos($extension, '?') !== false) {
            $extension = substr($extension, 0, strpos($extension, '?'));
        }

        $time = new \DateTime('now');
        $imageName = $time->getTimestamp() . '.' . $extension;

        $entity->setAttribute($fieldName, $imageName);

        $filePath = $this->_storagePath . '/' . $this->getDirName($entity) . '/' . $entity->id;
        $fullName = $filePath . '/' . $entity->getAttribute($fieldName);
        $thumbnailName = $filePath . '/' . self::PREFIX_THUMBNAIL . $entity->getAttribute($fieldName);

        $this->createDir($filePath);
        $this->clearDir($filePath);

        $imageContent = file_get_contents($url);
        file_put_contents($fullName, $imageContent);
        $this->saveThumbnail($fullName, $thumbnailName);

        return true;
    }

    /**
     * @param $dir
     */
    private function createDir($dir)
    {
        if (!is_dir($dir)) {
            FileHelper::createDirectory($dir, 0777, true);
        }
    }

    /**
     * @param $dir
     */
    private function clearDir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    unlink($dir . '/' . $object);
                }
            }
        }
    }

    /**
     * @param $dir
     */
    private function deleteDir($dir)
    {
        if (is_dir($dir)) {
            rmdir($dir);
        }
    }

    /**
     * @param $entity
     * @return mixed
     */
    private function getDirName($entity)
    {
        $entityClass = StringHelper::basename(get_class($entity));
        return $this->directories[$entityClass];
    }
}
