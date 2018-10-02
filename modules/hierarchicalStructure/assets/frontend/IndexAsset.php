<?php
namespace modules\hierarchicalStructure\assets\frontend;

use \yii\web\AssetBundle;

class IndexAsset extends AssetBundle
{
    public $sourcePath = '@modules/hierarchicalStructure/web';

    public $css = [
        'css/index.css',
    ];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}