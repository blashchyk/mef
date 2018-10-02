<?php
namespace modules\hierarchicalStructure\helpers;

use yii\bootstrap\Alert;

Class AlertHelper
{
    protected static $defaultCssClasses = [
        'token-alert'
    ];

    /**
     * @param array $cssClasses
     * @param string $bodyMessage
     * @param bool $showButton
     * @return string
     */
    public static function showAlertMessage(array $cssClasses, $bodyMessage = '', $showButton = false) {
        $cssClasses = array_merge($cssClasses, self::$defaultCssClasses);

        return  Alert::widget([
          'options' => [
              'class' => implode(' ', $cssClasses)
          ],
          'body' => $bodyMessage,
          'closeButton' => (bool) $showButton
      ]);
    }
}