<?php

namespace common\services;

use modules\hierarchicalStructure\models\Files;
use modules\hierarchicalStructure\models\Funds;
use modules\hierarchicalStructure\models\Records;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

/**
 * Class DeleteService
 * @package common\services
 */
class DeleteService
{
    /**
     * @param array $funds,...
     * @throws \yii\base\Exception
     */
    public static function deleteFund(...$funds)
    {
        if (!Funds::deleteAll(['id' => $funds])) {
            throw new \yii\base\Exception('Error while deleting');
        }
    }

    /**
     * @param array $funds,...
     * @throws \yii\base\Exception
     */
    public static function deleteRecord(...$funds)
    {
        if (!Records::deleteAll(['fond_id' => $funds])) {
            throw new \yii\base\Exception('Error while deleting');
        }
    }

    /**
     *
     * Delete all files that are related to deleted records
     * @param array $records,...
     * @throws \yii\base\Exception
     */
    public static function deleteFiles(...$records)
    {
        if (!Files::deleteAll(['record_id' => $records])) {
            throw new \yii\base\Exception('Error while deleting');
        }
    }
}
