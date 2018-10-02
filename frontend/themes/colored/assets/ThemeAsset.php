<?php
namespace frontend\themes\colored\assets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle
{
    public $sourcePath = '@themes/colored';

    public $css = [
        'css/font-awesome.min.css',
        'css/animate.css',
        'css/hover.css',
        'css/magnific-popup.css',
        'css/jquery.bxslider.css',
        'css/bootstrap-social.css',
        'css/style.css',
        'css/site.css'
    ];
    public $js = [
        // Plugins
        'js/modernizr-2.6.2.min.js',
        'js/imagesloaded.pkgd.min.js',
        'js/isotope.pkgd.min.js',
        'js/jquery.smartmenus.min.js',
        'js/jquery.smartmenus.bootstrap.min.js',
        //'js/scrollReveal.js',
        'js/jquery.magnific-popup.js',
        'js/popup.js',
        // Custom JS
        'js/magnet-main.js',
        'js/carousel-animations.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'frontend\assets\AppAsset',
    ];
}
