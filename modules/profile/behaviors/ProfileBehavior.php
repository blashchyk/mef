<?php

namespace modules\profile\behaviors;

use yii\base\Behavior;
use modules\profile\models\Profile;

class ProfileBehavior extends Behavior
{
    /**
     * Relationship User to Profile
     *
     * @return mixed
     */
    public function getProfile()
    {
        return $this->owner->hasOne(Profile::className(), ['user_id' => 'id']);
    }
}

