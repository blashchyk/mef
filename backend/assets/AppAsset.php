<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fonts/fonts.css',
        'css/flags.css',
        'css/site.css',
        'css/admin.css',
        'css/design.css',
        'css/orange.css',
    ];
    public $js = [
        'library/clipboard.min.js',
        'js/SiteHelper.js',
        'js/DesignHelper.js',
        'js/RoleHelper.js',
        'js/MenuHelper.js',
        'js/ImageHelper.js',
        'js/ListSortHelper.js',
        'js/TableSortHelper.js',
        'js/CatalogHelper.js',
        'js/SnippetHelper.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\jui\JuiAsset',
    ];
}
