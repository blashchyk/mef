<?php
namespace modules\hierarchicalStructure\assets\backend;

use \yii\web\AssetBundle;

class HsAsset extends AssetBundle
{
    public $sourcePath = '@modules/hierarchicalStructure/web';

    public $css = [
        'css/hs.css',
        'css/node.css'
    ];
    public $js = [
        'js/hs.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}