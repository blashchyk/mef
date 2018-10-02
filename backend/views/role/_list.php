<?php

/* @var yii\rbac\Permission[] $permissions */
/* @var yii\rbac\Permission[] $rolePermissions Permissions for current role */
/* @var yii\rbac\Permission $parent */

?>

<ul>
    <?php
    foreach ($permissions as $permission) :
        $children = $permission['children']; ?>

        <li>
            <div class="checkbox">
                <label>
                    <input type="checkbox"
                           class="permissions"
                           id="<?= $permission['name'] ?>"
                           name="Permissions[<?= Yii::t('app', $permission['name']) ?>]"
                        <?php
                        if (array_key_exists($permission['name'], $rolePermissions)) : ?>
                            checked="checked" value='1'
                        <?php endif; ?>
                        <?php
                        if (isset($parent) && array_key_exists($parent['name'], $rolePermissions)) : ?>
                            disabled="disabled" value='0'
                        <?php endif; ?>
                    />
                    <?= $permission['description'] ? Yii::t('app', $permission['description']) : Yii::t('app', $permission['name']) ?>
                </label>
            </div>

            <?php if (count($children) > 0) : ?>
                <?= $this->render('_list', [
                    'permissions' => $children,
                    'parent' => $permission,
                    'rolePermissions' => $rolePermissions,
                ])
                ?>
            <?php endif; ?>
        </li>
    <?php endforeach;
    ?>
</ul>

