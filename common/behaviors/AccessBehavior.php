<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use common\library\permission\AccessManager;
use common\library\config\AccessApplicant;

/**
 * Class AccessBehavior
 *
 * @package common\behaviors
 */
class AccessBehavior extends Behavior
{

    /**
     * @var null
     */
    public $applicant;

    /**
     * @var AccessManager|null
     */
    private $accessManager;

    /**
     * FieldBehavior constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->accessManager = new AccessManager();
        $this->applicant = new AccessApplicant(Yii::$app->user->id, AccessManager::USER);
    }

    /**
     * @param int $permission
     *
     * @return bool
     */
    public function checkPermission($permission)
    {
        return $this->accessManager->checkPermission($this->owner, Yii::$app->user->getIdentity(), $permission);
    }

    /**
     * @return array
     */
    public function getListAllAccessHolders()
    {
        return $this->accessManager->listAllAccessHolders($this->owner, null);
    }

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->accessManager->getPermissions($this->owner, $this->applicant);
    }

    /**
     * @param $applicant
     */
    public function removePermission()
    {
        $this->accessManager->removePermissions($this->owner, $this->applicant);
    }

    /**
     * @param $sumPermission
     */
    public function assignPermission($sumPermission)
    {
        $this->accessManager->assignPermissions($this->owner, $this->applicant, $sumPermission);
    }
}
