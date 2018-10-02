IT-Master's CMS written on Yii Framework 2
===============================

There are three applications: front end, back end, and console, each of which
is a separate Yii application.

Back end contains the next units:

- Users
- Roles

> **NOTE:**
> As of 2017-12-11 php minimun requirements updated to PHP5.5 yet there
> are some packages that might require higher version of PHP.
>
> This can lead to error so look composer guide below for solution.

Installation
============

## Setup virtual host(s)
### Virual host root directory is project root directory
Frontend requests routed to `./frontend/web/`

Alias for the admin directory is `./backend/web/`
> **NOTE:** On local machine point your domain in hosts file

## Clone the repository
> **NOTE:**
> Consider [adding ssh key](https://confluence.atlassian.com/bitbucket/set-up-an-ssh-key-728138079.html) for simple repository clone

Navigate to root directory and clone project repository.

Refer [here for clone](https://confluence.atlassian.com/bitbucket/clone-a-repository-223217891.html) instructions.
the main [project page](https://bitbucket.org/itmaster/our-cms/overview) will have all information you may need of.

> **NOTE:** Links provided here suggest you are installing default CMS. If you work with another project please refer to admin for proper repository links

## Requirements
You should perform requirement check on your system, this will show are you good to procced with install and may help you to locate troubles
```
#!sh
$ php requirements.php
```

## Composer
This project support and depends on composer for smoothe installation and update.
You you have no experience with this tool than please consult the [official documentation](https://getcomposer.org/doc/).

You could find instructions for installation [here](https://getcomposer.org/doc/00-intro.md)
> **NOTE:** Install composer globally
### Install plugin
CMS project require additional configuration for NPM/Bower web assets. The next command required to config this assets
`composer global require "fxp/composer-asset-plugin:~1.1.1"`
### Install vendors
`composer install`

> **Note:**
> if you face php versions conflict, but you sure, that your web server use php>=5.6
>
> you can run composer install with parameter: `composer install --ignore-platform-reqs`

> **Note:**
> Some CPanel servers have multiphp feature, this can lead to composer completely misuse php versions. This can be avoided by using full paths to binaries
>
> ex: `/usr/local/bin/ea-php7 /usr/local/bin/composer install`
>
> The path used above just an example and should not be used as-is

## Initialize project
### Run project start command
Execute the init command and select Development as environment
`php init`
### Database
Create database and configurate `common/config/main-local.php` 'db' setting accordingly
### RBAC
Enable out of box roles support

```
#!sh
$ php yii migrate --migrationPath=@yii/rbac/migrations
```

### Apply migrations
```
#!sh
$ php yii migrate
```
### Roles config
Run initial roles configuration
```
#!sh
$ php yii rbac/init
```
For detailed roles manual please refer to [rbac.md](rbac.md)

### Modules config
There is no mandatory modules that required for application work. But there are a lot that will benefit you.

> **NOTE:** You can get list of all modules supplied with your installation using command
> `$ php yii manager/status all`

These are modules that will definitly help you, you can enable then using command
```
#!sh
$ php yii manager/register <modulename>
```

* site
* dashboard
* page
* country
* i18n
* profile
* setting

> **NOTE:** You can enable all modules with command
> `$ php yii manager/register all`

For detailed module manual please refer to [modules.md](modules.md)

Additional settings:
--------------------
### You may require to install next php extencions if you haven't done this already
+ php-intl
+ php-memcache
+ php-apc
+ php-imagick ([help](http://firstwiki.ru/index.php/%D0%A3%D1%81%D1%82%D0%B0%D0%BD%D0%BE%D0%B2%D0%BA%D0%B0_Imagemagick))

> **NOTE:** please refer to your php version for proper install command, the next example provided only as visualisation
>
> e.g. `$ apt-get install php5-intl`

### Using PHP_CodeSniffer
```
#!sh
$ vendor/bin/phpcs <file-name>
```

### Generating documentation with phpDocumentor
```
#!sh
$ vendor/bin/phpdoc -d ./modules -t ./output --template="new-black"
```

## Yii 2 documentation
If you find yourself struggling with Yii2 you should visit [official documentation](http://www.yiiframework.com/doc-2.0/guide-index.html).
> **NOTE:** please keep in mind that many parts of default Yii application was changed for required needs,
> so not all information may be accurate and there may be specific none default implementation in project.

ПРАВИЛА ИСПОЛЬЗОВАНИЯ ГЕНЕРАТОРА КОДА
-------------------

```
После генирации модели:
1) Проверить сгенерированный код.
2) Отредактировать/настроить правила валидации.
3) Добавить модели необходимые поведения.
4) Добавить вычисляемые поля.
5) Отредактировать подписи полей в функции attributeLabels, добавить подписи к вычисляемым полям.
6) Добавить другие методы класса.

После генерации поисковой модели:
1) Проверить сгенерированный код.
2) Настроить правила валидации.
3) Настроить фильтрацию.
4) Настроить постраничное деление.
5) Настроить сортировку по умолчанию и при нажатии на поля таблиц.

После генерации контроллера:
1) Проверить сгенерированный код, разкомментировать нужные участки кода, удалить не нужные.
2) Добавить необходимые акшены.

После генерации видов:
1) Проверить сгенерированный код, разкомментировать нужные участки кода, удалить не нужные.
2) Настроить фильтрацию и способы отображения данных в таблице на индексной странице.
3) Настроить компоненты для редактирования данных в форме.
4) При необходимости разделения компонентов для редактирования данных в форме на вкладке - добавить вкладки.
4) При необходимости редактирования переводов модуля, добавить вкладку Translations.

После генирации модуля:
1) Проверить сгенерированный код.
2) Добавить элементы левого подменю.
```
