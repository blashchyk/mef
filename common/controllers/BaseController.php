<?php

namespace common\controllers;

use common\services\MoveService;
use modules\hierarchicalStructure\controllers\backend\FundsController;
use modules\hierarchicalStructure\models\KartikTreeNode;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class BaseController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        $action = $this->action->id;
        $permissionMap = $this->permissionMapping();
        $permission = array_key_exists($action, $permissionMap) ? $permissionMap[$action] : $action;

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => [$action],
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => [$action],
                        'roles' => [$permission]
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array of permissions for module
     */
    public function permissionMapping()
    {
        return [];
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $language = Yii::$app->session->get('language', 'pt');
        Yii::$app->language = $language;

        return parent::beforeAction($action);
    }

    /**
     * @param string $move_node_id
     * @param string $internal_node_id
     * @param string $root_element
     * @return string
     */
    public function dragging($move_node_id, $internal_node_id, $root_element)
    {
        $move_node = KartikTreeNode::findOne($move_node_id);
        if ($move_node->type == FundsController::RECORD_TYPE && $root_element !== null) {
            return Yii::t('app', 'You can not move a single record');
        }
        if ($root_element !== null) {
            return MoveService::transferToRoot($move_node);
        } else {
            return MoveService::movingInsideNodes($move_node, $internal_node_id);
        }
    }
}
