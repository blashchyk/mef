<?php

namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;

class ImageBehavior extends Behavior
{
    public $fieldName = 'image';

    public $inputFileName = null;

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    /**
     * @param object $event
     */
    public function beforeValidate()
    {
        $imageName = Yii::$app->storage->getImageName($this->owner, $this->fieldName, $this->inputFileName);
        $this->owner->setAttribute($this->fieldName, $imageName);
    }

    /**
     * @param object $event
     */
    public function beforeSave($event)
    {
        $imageName = Yii::$app->storage->getImageName($this->owner, $this->fieldName, $this->inputFileName);
        $this->owner->setAttribute($this->fieldName, $imageName);
    }

    /**
     * @param object $event
     */
    public function afterSave($event)
    {
        Yii::$app->storage->saveImage($this->owner, $this->fieldName, $this->inputFileName);
    }

    /**
     * @param object $event
     */
    public function beforeDelete($event)
    {
        Yii::$app->storage->deleteImage($this->owner);
    }

    /**
     * @return boolean
     */
    public function deleteImage()
    {
        Yii::$app->storage->deleteImage($this->owner);
        $this->owner->setAttribute($this->fieldName, null);
        return $this->owner->save();
    }

    /**
     * @return string
     */
    public function getImageUrl($isThumbnail = false)
    {
        return Yii::$app->storage->getImageUrl($this->owner, $this->fieldName, $isThumbnail);
    }

    /**
     * @return string
     */
    public function getImageThumbnailUrl()
    {
        return $this->owner->getImageUrl(true);
    }
}
