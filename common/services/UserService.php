<?php

namespace common\services;

use Yii;
use common\models\User;

class UserService
{
    /**
     * @return \common\models\User
     */
    public function getCurrentUser()
    {
        return User::findOne(['id' => Yii::$app->user->id]);
    }

    /**
     * @return User | false
     */
    public function resetAccessToken()
    {
        /** @var User $user */
        $user = $this->getCurrentUser();
        $user->removeAccessToken();
        $user->generateAccessToken();
        $saved = (bool) $user->save();
        return $saved ? $user : false;
    }
}