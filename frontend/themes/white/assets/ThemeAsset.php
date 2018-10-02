<?php
namespace frontend\themes\white\assets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@themes/white';
    
    public $css = [
        'css/style.css',
        'css/magnific-popup.css',
        'css/font-awesome.min.css',
        'css/animate.css',
        'css/site.css',
    ];
    public $js = [
        'js/scrolltopcontrol.js',
        'js/jquery.magnific-popup.js',
        'js/quote.js',
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'frontend\assets\AppAsset',
    ];
}
