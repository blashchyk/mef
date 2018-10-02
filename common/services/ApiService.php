<?php

namespace common\services;

use Yii;
use modules\hierarchicalStructure\models\HsTree;

class ApiService
{
    /**
     * @param string $view
     * @param string $category
     * @param HsTree $hs
     */
    public function setApiLogs( $view, HsTree $hs = null, $category = 'api_request')
    {
        $userService = new UserService();
        $user = $userService->getCurrentUser();

        $messageLog = [
            'accessToken' => $user->access_token,
            'userName' => $user->username,
            'view' => Yii::t('app', $view)
        ];

        if ($hs !== null) {
            $messageLog['hsName'] = $hs->name;
        }

        Yii::info($messageLog, $category);
    }
}