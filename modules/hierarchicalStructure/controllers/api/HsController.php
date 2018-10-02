<?php
namespace modules\hierarchicalStructure\controllers\api;

use common\services\ApiService;
use yii\web\Response;
use modules\hierarchicalStructure\models\HsTree;
use modules\hierarchicalStructure\models\HsTreeNode;
use modules\hierarchicalStructure\models\KartikTreeNode;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use Yii;


class HsController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::className(),
        ];

        return $behaviors;
    }

    /**
     * Set API response format by query param from route
     * @param \yii\base\Action $action
     * @return string
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        return \Yii::$app->response->format = (string) \yii::$app->getRequest()->getQueryParam('format',
            Response::FORMAT_JSON);
    }

    /**
     * @return array
     */
    public function actionListHs()
    {
        $hsList = HsTree::find()->orderBy('name')->all();

        $apiService = new ApiService();
        $apiService->setApiLogs('Hs List');

        return ['hs' => $hsList];
    }

    /**
     * @param string $hsKey
     * @return array
     */
    public function actionListRootNodes($hsKey)
    {
        $hs = HsTree::findOne(['key' => $hsKey]);

        $rootList = HsTreeNode::find()
            ->alias('htn')
            ->joinWith('kartikTreeNode')
            ->where([
                'hs_tree_id' => $hs->id,
                'lft' => 1,
                'htn.active' => 1,
            ])
            ->orderBy('root')
            ->all();

        $apiService = new ApiService();
        $apiService->setApiLogs('List root nodes', $hs);

        return ['node' => $rootList];
    }

    /**
     * @param string $hsKey
     * @param string $codePath
     * @return array
     */
    public function actionListChild($hsKey, $codePath)
    {
        $hs = HsTree::findOne(['key' => $hsKey]);

        /**
         * @var KartikTreeNode $rootNode
         * @var KartikTreeNode $parentNode
         */

        if (strpos($codePath, '.') === false) {
            $rootNode = KartikTreeNode::find()
                ->alias('ktn')
                ->joinWith(['hsTreeNode' => function($q) {
                    $q->from('hs_tree_node htn');
                },
                ])
                ->where([
                    'ktn.hs_tree_id' => $hs->id,
                    'ktn.lft' => 1,
                    'htn.code' => $codePath,
                    'htn.active' => 1,
                ])
                ->one();

            if (empty($rootNode)) {
                return [
                    'status' => 'error',
                    'message' => Yii::t('app', 'A node with code: ' . $codePath . ' does not exist'),
                ];
            }

            $parentNode = $rootNode;
        } else {
            $codes = explode('.' , $codePath);
            $rootCode = $codes[0];
            $lastCode = end($codes);
            $depth = key($codes);

            $rootNode = KartikTreeNode::find()
                ->alias('ktn')
                ->joinWith(['hsTreeNode' => function($q) {
                    $q->from('hs_tree_node htn');
                },
                ])
                ->where([
                    'ktn.hs_tree_id' => $hs->id,
                    'ktn.lft' => 1,
                    'htn.code' => $rootCode,
                    'htn.active' => 1,
                ])
                ->one();

            if (empty($rootNode)) {
                return [
                    'status' => 'error',
                    'message' => Yii::t('app', 'Root node with code: ' . $rootCode . ' does not exist'),
                ];
            }

            $parentNode = KartikTreeNode::find()
                ->alias('ktn')
                ->joinWith(['hsTreeNode' => function($q) {
                    $q->from('hs_tree_node htn');
                },
                ])
                ->where([
                    'ktn.hs_tree_id' => $hs->id,
                    'ktn.root' => $rootNode->id,
                    'ktn.lvl' => $depth,
                    'htn.code' => $lastCode,
                    'htn.active' => 1,
                ])
                ->one();

            if (empty($parentNode)) {
                return [
                    'status' => 'error',
                    'message' => Yii::t('app', 'Child node with code: ' . $lastCode . ' does not exist at root with code: ' . $rootCode),
                ];
            }
        }

        $directChildren = HsTreeNode::find()
            ->alias('htn')
            ->joinWith('kartikTreeNode')
            ->where([
                'and',
                ['=', 'hs_tree_id', $hs->id],
                ['=', 'root', $rootNode->id],
                ['>', 'lft', $parentNode->lft],
                ['<', 'rgt', $parentNode->rgt],
                ['<=', 'lvl', $parentNode->lvl + 1],
                ['=', 'htn.active', 1],
            ])
            ->orderBy('lft')
            ->all();

        $apiService = new ApiService();
        $apiService->setApiLogs('List Children for node: ' . $codePath, $hs);

        if (!empty($directChildren)) {
            return ['node' => $directChildren];
        } else {
            return ['node' => Yii::t('app', 'Children nodes not exist')];
        }
    }
}