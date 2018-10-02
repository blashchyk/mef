<?php
namespace common\widgets;

use yii\web\AssetBundle;

class GalleryAsset extends AssetBundle
{
    public $sourcePath = '@widgets';

    public $css = [
        //'library/blueimp-gallery.css',
    ];
    public $js = [
        'library/jquery.blueimp-gallery.min.js',
    ];
    public $depends = [
        //'yii\web\JqueryAsset',
        'dosamigos\gallery\GalleryAsset',
    ];
}
