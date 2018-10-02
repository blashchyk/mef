<?php
namespace common\behaviors;

use Yii;
use yii\behaviors\TimestampBehavior as BaseTimestampBehavior;

class TimestampBehavior extends BaseTimestampBehavior
{
    /**
     * @return string
     */
    public function getCreated()
    {
        return Yii::$app->formatter->asDatetime($this->owner->created_at);
    }

    /**
     * @return string
     */
    public function getUpdated()
    {
        return Yii::$app->formatter->asDatetime($this->owner->updated_at);
    }
}
