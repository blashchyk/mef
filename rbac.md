### RBAC Разрешения для модуля
###### Включение поддержки RBAC
Выполните начальную миграцию для rbac
```sh
$ php yii migrate --migrationPath=@yii/rbac/migrations
```
> **NOTE:**
>
> This step should be done once and will throw an error on subsequent executions.
> Also it is mentioned in initial start manual so most likely you shouldn't run it.

Выполните начальную установку правил
```sh
$ php yii rbac/init
```

##### Установка разрешений
Активация разрешений производится автоматически в момент [включения](modules.md) модуля согласно структуры которая описана ниже.

Класс Module в корневой папке каждого модуля должен содержать метод getPermissionStructure(), который возвращает структуру дерева разрешений.
Пример метода:
```php
    public static function getPermissionStructure()
    {
        return [
            [
                'type' => Permission::NODE_TYPE_MODULE,
                'name' => 'page',
                'children' => [
                    [
                        'type' => Permission::NODE_TYPE_ACTION,
                        'name' => 'update',
                    ],
                    [
                        'type' => Permission::NODE_TYPE_ACTION,
                        'name' => 'create',
                    ],
                    [
                        'type' => Permission::NODE_TYPE_SIDE,
                        'name' => 'backend',
                        'children' => [
                            [
                                'type' => Permission::NODE_TYPE_ACTION,
                                'name' => 'update',
                            ],
                            [
                                'type' => Permission::NODE_TYPE_CONTROLLER,
                                'name' => 'default',
                                'children' => [
                                    [
                                        'type' => Permission::NODE_TYPE_ACTION,
                                        'name' => 'create',
                                        'roles' => ['user']
                                    ],
                                    [
                                        'type' => Permission::NODE_TYPE_ACTION,
                                        'name' => 'update',
                                        'roles' => ['user', 'admin']
                                    ],
                                                                        [
                                        'type' => Permission::NODE_TYPE_ACTION,
                                        'name' => 'index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'type' => Permission::NODE_TYPE_ACTION,
                'name' => 'verySpecificPermission',
                'roles' => ['user']
            ],
        ];
    }
```

Каждое разрешение формируется на узле с типом "NODE_TYPE_ACTION" и содержит в своем названии имена всех родителей, перечисленных через точку.

##### Уровни разрешений
Необходимо придерживаться следующей иерархии:
  - action
  - module.action
  - module.side.action
  - module.side.controller.action

При указании любого разрешения, будет поочередно проверяться, существует ли более высокое по уровню. В последнюю очередь будут проверены базовые. Если такое будет найдено, оно будет назначено, как родительское. Поэтому при построении дерева сначала необходимо сначала указывать родительские разрешения.

При инициализации по вышеприведенному дереву, мы получим следующие цепочки зависимостей:
```
- update
	- page.update
		- page.backend.update
			- page.backend.default.update

- create
	- page.create
		- page.backend.default.create

- index
	- page.backend.default.index

- verySpecificPermission
```

##### Доступные опции
Ниже дано описание поддерживаемых опций каждого узла дерева:
 - type: (обязательный параметр) Указывает тип узла. Доступные параметры.
   - Permission::NODE_TYPE_MODULE
   - Permission::NODE_TYPE_SIDE
   - Permission::NODE_TYPE_CONTROLLER
   - Permission::NODE_TYPE_ACTION
 - name: (обязательный параметр) Указывает имя разрешения;
 - children: Задает дочерние узлы;
 - description: Задает описание узла. Имеет приоритет при отображении дерева разрешений в интерфейсе админа
 - roles: Задает перечень ролей, для которых будет применено разрешение. Следует указывать в узлах с типом “NODE_TYPE_ACTION”.

##### Указание разрешений в модуле
Для указания созданных разрешений в конкретном модуле, необходимо в контроллере реализовать метод permissionMapping(). Метод должен возвращать массив пар [action => permission]. Также здесь следует указывать какими разрешениями должен обладать пользователь для вызова нестандартных actions (все, кроме базовых 'create', 'update', 'delete', 'index').
Пример реализации:
```sh
public function permissionMapping()
{
    return [
        // для доступа к нестандартному action 'view'
        // необходимо обладать базовым разрешением 'index';
        'show-list' => 'index',

        // для доступа к action 'update' необходимо обладать
        // специальным разрешением 'page.backend.default.update';
        'update' => 'page.backend.default.update',

        // для доступа к нестандартному action 'delete' необходимо обладать
        // специальным разрешением 'page.delete';
        'delete-list' => 'page.delete'
    ];
}
```

При этом все неописанные actions будут запрашивать одноименное разрешение. Например при попытке доступа к action 'create' будет проверяться базовое разрешение 'create'.

##### Удаление
Удаление производится автоматически при [выключении](modules.md) модуля.
