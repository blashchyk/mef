<?php
namespace modules\hierarchicalStructure\assets\backend;

use \yii\web\AssetBundle;

class TokenAsset extends AssetBundle
{
    public $sourcePath = '@modules/hierarchicalStructure/web';

    public $css = [
        'css/token.css',
    ];
    public $js = [
        'js/token.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}