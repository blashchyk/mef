<?php

namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\bootstrap\Nav;

class LanguageChoice extends Widget
{
    public $languages;

    public $currentLanguage = 'en';

    public $options = ['class' => 'navbar-nav navbar-right'];

    public $classPrefix = 'pull-left flag flag-';

    /**
     * Initializes the widget.
     */
    public function run()
    {
        $items = [];

        foreach ($this->languages as $languageId => $languageName) {
            $items[] = [
                'label' => Html::tag('div', '', ['class' => $this->classPrefix . $languageId]) . '&nbsp; ' . $languageName,
                'url' => ['/site/language/', 'language' => $languageId]
            ];
        }

        return Nav::widget([
            'options' => $this->options,
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => Html::tag('div', '', ['class' => $this->classPrefix . $this->currentLanguage]) . '&nbsp;',
                    'url' => ['/'],
                    'items' => $items
                ]
            ],
        ]);
    }
}
