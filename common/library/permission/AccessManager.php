<?php

namespace common\library\permission;

use common\library\config\AccessInterface;
use common\library\config\AccessApplicant;
use yii\db\Query;
use Yii;
use yii\web\IdentityInterface;


/**
 * Class AccessManager
 *
 * @package common\library\permission
 * @todo There is know issue when owner could be stripped of access to his instance is there is "restrictive" rule specified on child folder for group this owner belonged
 *
 */
class AccessManager
{

    const VIEW = 1;
    const UPDATE = 2;
    const CREATE = 4;
    const DELETE = 8;
    const ASSIGN = 16;

    const USER = 1;
    const GROUP = 2;

    /**
     * @var string the name of the table storing access instance. Defaults to "access_instance".
     */
    public $itemTable = '{{%access_instance}}';

    /**
     * @param int $applicant
     *
     * @return AccessApplicant[]
     */
    private function applicantsReceipt ($applicant)

    {
        $role = Yii::$app->authManager->getRolesByUser($applicant);
        $roles = [];
        $roles[] = new AccessApplicant ($applicant, self::USER);
        foreach ($role as $item) {
            $roles[] = new AccessApplicant ($item->name, self::GROUP);
        }
        return $roles;
    }

    /**
     * @param int $identity
     * @param AccessApplicant[] $applicant
     *
     * @return bool
     */
    private function hasPermission($identity, array $applicant)
    {

        if (empty($identity) || empty($applicant)) {
            return false;
        }
        foreach ($applicant as $item) {
            $query = (new Query())
                ->from($this->itemTable)
                ->where([
                    'instance_id' => $identity,
                    'access_type' => $item->getUType(),
                    'access_id'   => $item->getUId(),
                ])->createCommand();
            if( $query->queryScalar()) {
                return true;
            }
        }
        return false;

    }

    /**
     * @param int $identity
     * @param AccessApplicant[] $applicant
     * @param int $permission
     *
     * @return bool
     */
    private function isAllowed($identity, array $applicant, $permission)
    {
        if (empty($identity) || empty($applicant)) {
            return false;
        }
        foreach ($applicant as $item) {
            $query = (new Query())
                ->from($this->itemTable)
                ->where([
                    'instance_id' => $identity,
                    'access_type' => $item->getUType(),
                    'access_id'   => $item->getUId(),
                ])
                ->andWhere(['&', 'permission', $permission])
                ->createCommand();

            if ($query->queryScalar()) {
                return true;
            }
        }

        return false;
    }


    /**
     * @param AccessInterface $identity
     * @param IdentityInterface $applicant
     * @param int $permission
     *
     * @return bool
     */
    public function checkPermission(AccessInterface $identity, IdentityInterface $applicant, $permission)
    {
        $applicants = $this->applicantsReceipt($applicant->getId());

        $instance = $identity;
        while ($instance !== null) {
            $instanceId = $instance->getUId();
            if ($this->hasPermission($instanceId, $applicants)) {
                return $this->isAllowed($instanceId, $applicants, $permission);
            }
            $instance = $instance->getUParent();
        }
        return false;
    }

    /**
     * @param AccessInterface $identity
     * @param AccessApplicant $applicant
     *
     * @return array
     */
    public function getPermissions(AccessInterface $identity, AccessApplicant $applicant)
    {
        $permissions = [];

        $instance = $identity;

        while ($instance !== null) {
            $instanceId = $instance->getUId();
            if ($this->hasPermission($instanceId, [$applicant])) {
                $query = (new Query())
                    ->select('access_type, access_id, permission')
                    ->from($this->itemTable)
                    ->where([
                        'instance_id' => $instanceId,
                        'access_type' => $applicant->getUType(),
                        'access_id'   => $applicant->getUId(),
                    ])->createCommand();

                if ($query->queryScalar()) {
                    $permissions[] = $query->queryOne();
                }

                return $permissions;
            }
            $instance = $instance->getUParent();
        }
    }

    /**
     * @param AccessInterface $identity
     * @param AccessApplicant $applicant
     * @param int $permissions
     */
    public function assignPermissions(AccessInterface $identity, AccessApplicant $applicant, $permissions)
    {
        $query = (new Query())
            ->from($this->itemTable)
            ->where([
                'instance_id' => $identity->getUId(),
                'access_id'   => $applicant->getUId(),
                'access_type' => $applicant->getUType(),
            ])
            ->createCommand();

        if ($query->queryScalar()) {
            Yii::$app->db->createCommand()->update($this->itemTable, [
                'instance_id' => $identity->getUId(),
            ], [
                'access_id'   => $applicant->getUId(),
                'access_type' => $applicant->getUType(),
                'permission'  => $permissions,
            ])->execute();
        } else {
            Yii::$app->db->createCommand()->insert($this->itemTable, [
                'instance_id' => $identity->getUId(),
                'access_id'   => $applicant->getUId(),
                'access_type' => $applicant->getUType(),
                'permission'  => $permissions,
            ])->execute();
        }
    }

    /**
     * @param AccessInterface $identity
     * @param AccessApplicant $applicant
     */
    public function removePermissions(AccessInterface $identity, AccessApplicant $applicant)
    {
        Yii::$app->db->createCommand()->delete($this->itemTable, [
            'instance_id' => $identity->getUId(),
            'access_id'   => $applicant->getUId(),
            'access_type' => $applicant->getUType(),
        ])->execute();
    }

    /**
     * @param AccessInterface $identity
     * @param int $permission
     *
     * @return array
     */
    public function listAllAccessHolders(AccessInterface $identity, $permission)
    {
        $applicant = [];
        $query = (new Query())
            ->select('access_type, access_id, permission')
            ->from($this->itemTable)
            ->where(['instance_id' => $identity->getUId()])
            ->andFilterCompare('permission', $permission, '&')
            ->createCommand();

        $applicant = $query->queryAll();

        return $applicant;
    }

}