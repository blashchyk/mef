<?php

namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;

class CreatorBehavior extends Behavior
{
    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
        ];
    }

    /**
     * @param $event
     */
    public function beforeInsert($event)
    {
        $user = Yii::$app->user;
        if (!$user->isGuest && empty($this->owner->user_id)) {
            $this->owner->user_id = $user->id;
        }
    }

    /**
     * @return null
     */
    public function getCreator()
    {
        return !empty($this->owner->user) ? $this->owner->user->username : null;
    }
}
