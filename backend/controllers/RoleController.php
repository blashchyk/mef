<?php

namespace backend\controllers;

use common\controllers\BaseController;
use common\models\RoleForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;

/**
 * RoleController.
 */
class RoleController extends BaseController
{

    public function permissionMapping()
    {
        return [
            'index' => 'role.index',
            'update' => 'role.update',
            'create' => 'role.create',
            'delete' => 'role.delete',
        ];
    }
    /**
     * Lists all Roles.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => Yii::$app->authManager->getRoles(),
            'sort' => [
                'attributes' => ['name', 'description'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Role.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $permissions = Yii::$app->authManager->getPermissionsChildrenTree();

        $roleForm = new RoleForm(['scenario' => RoleForm::IS_NEW_SCENARIO]);

        $post = Yii::$app->request->post();

        if ($roleForm->load($post) && $roleForm->validate()) {
            $role = Yii::$app->authManager->createRole($roleForm->name);
            $role->description = $roleForm->description;
            $createRole = Yii::$app->authManager->add($role);

            if ($createRole) {
                $toAdd = Yii::$app->request->post('Permissions', []);
                $result = Yii::$app->authManager->addPermissions($role, $toAdd);

                if ($result) {
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Error create role.'));
                }
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Error create role.'));
            }
        }

        return $this->render('create', [
            'model' => $roleForm,
            'permissions' => $permissions,
            'rolePermissions' => [],
        ]);
    }

    /**
     * Updates an existing Role.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($name)
    {
        $role = Yii::$app->authManager->getRole($name);
        $roleForm = new RoleForm();

        $permissions = Yii::$app->authManager->getPermissionsChildrenTree();

        if (!is_null($role)) {
            $rolePermissions = Yii::$app->authManager->getPermissionsByRole($role->name);
        } else {
            throw new NotFoundHttpException();
        }

        $post = Yii::$app->request->post();

        if ($roleForm->load($post) && $roleForm->validate()) {
            $role->name = $roleForm->name;
            $role->description = $roleForm->description;

            $newPermissions = array_keys(Yii::$app->request->post('Permissions', []));

            $update = Yii::$app->authManager->updatePermissions($name, $role, $newPermissions);

            if ($update) {
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Error update role.'));
            }
        }

        $roleForm->name = $role->name;
        $roleForm->description = $role->description;

        return $this->render('update', [
            'model' => $roleForm,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions,
        ]);
    }

    /**
     * Deletes an existing Role.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name
     * @return mixed
     */
    public function actionDelete($name)
    {
        $result = Yii::$app->authManager->deleteRole($name);

        if (!$result) {
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Error delete role.'));
        }

        return $this->redirect(['index']);
    }
}
