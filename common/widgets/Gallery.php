<?php
namespace common\widgets;

use Yii;
use yii\base\Widget;

class Gallery extends Widget
{
    /**
     * @return null
     */
    public function init()
    {
        parent::init();

        $view = Yii::$app->getView();
        GalleryAsset::register($view);
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('gallery_popup');
    }
}
