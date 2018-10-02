<?php
namespace modules\hierarchicalStructure\assets\backend;

use \yii\web\AssetBundle;

class ImportAsset extends AssetBundle
{
    public $sourcePath = '@modules/hierarchicalStructure/web';

    public $css = [
        'css/import-excel.css',
    ];
    public $js = [
        'js/import-excel.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}