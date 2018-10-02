<?php
namespace modules\hierarchicalStructure\assets\backend;

use \yii\web\AssetBundle;

class UploadFormAsset extends AssetBundle
{
    public $sourcePath = '@modules/hierarchicalStructure/web';

    public $css = [
        'css/upload-form.css',
    ];
    public $js = [
        'js/upload-form.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}