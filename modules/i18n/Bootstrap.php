<?php

namespace modules\i18n;

use yii\base\BootstrapInterface;

/**
 * Class Bootstrap
 * @package modules\i18n
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $app->language = $app->session->get('language', 'pt');
    }
}
