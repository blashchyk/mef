<?php
namespace common\widgets;

use yii\web\AssetBundle;

class NestedAsset extends AssetBundle
{
    public $sourcePath = '@widgets';

    public $css = [
        'css/nested.css',
    ];
    public $js = [
        'library/jquery.mjs.nestedSortable.js',
        'js/NestedHelper.js',
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}
