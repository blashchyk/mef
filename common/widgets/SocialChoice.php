<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\authclient\ClientInterface;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

class SocialChoice extends AuthChoice
{
    public $isAccountOwner = false;

    public $isMinimized = false;

    public $auths = [];

    private $_socialUrls = [
        'google' => 'https://plus.google.com/',
        'facebook' => 'https://www.facebook.com/',
        'twitter' => 'https://twitter.com/',
        'vkontakte' => 'http://vk.com/',
    ];

    public $tableOptions = ['class' => 'table table-striped table-bordered'];
    public $addButtonClass = 'glyphicon glyphicon-plus';
    public $addButtonTitle = 'Link a new Social Account';

    /**
     * Outputs client auth link.
     * @param ClientInterface $client
     * @param null $text
     * @param array $htmlOptions
     */
    public function clientLink($client, $text = null, array $htmlOptions = [])
    {
        $clientUrl = $this->createClientUrl($client);
        $title = $client->getTitle();
        $socialLinks = $this->getSocialLinks($client->getName());
        $icon = Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()]);
        $button = Html::tag('span', '', ['class' => $this->addButtonClass, 'title' => $this->addButtonTitle]);

        if ($this->isAccountOwner) {
            $title = Html::a($title, $clientUrl);
            $icon = Html::a($icon, $clientUrl);
            $button = Html::a($button, $clientUrl);
        }

        $text = '';
        if (!$this->isMinimized) {
            $text .= Html::tag('td', $icon, ['width' => '50']);
            $text .= Html::tag('td', $title);
        } else {
            $text = Html::tag('th', $title);
        }

        $text .= Html::tag('td', implode(', ', $socialLinks));

        if ($this->isAccountOwner) {
            $text .= Html::tag('td', $button, ['width' => '40', 'align' => 'center']);
        }

        echo Html::tag('tr', $text);
    }

    /**
     * @return mixed
     */
    protected function renderHeader()
    {
        echo Html::beginTag('thead');

        $text = Html::tag('th', Yii::t('app', 'Network'), ['colspan' => 2]);
        $text .= Html::tag('th', Yii::t('app', 'Accounts'));

        if ($this->isAccountOwner) {
            $text .= Html::tag('th');
        }

        echo Html::tag('tr', $text);
        echo Html::endTag('thead');
    }

    /**
     * Renders the main content, which includes all external services clients.
     */
    protected function renderMainContent()
    {
        echo Html::beginTag('table', $this->tableOptions);
        if (!$this->isMinimized) {
            $this->renderHeader();
        }
        foreach ($this->getClients() as $externalService) {
            $this->clientLink($externalService);
        }
        echo Html::endTag('table');
    }

    /**
     * @param $source string
     * @return array
     */
    protected function getSocialLinks($source)
    {
        $socialIds = ArrayHelper::map($this->auths, 'source_id', 'screen_name', 'source');
        $socialIds = !empty($socialIds[$source]) ? $socialIds[$source] : [];
        $socialLinks = [];

        foreach ($socialIds as $socialId => $screenName) {
            if (empty($screenName)) {
                $screenName = $socialId;
            }
            if ($this->isMinimized) {
                $screenName = StringHelper::truncate($screenName, 10, '...');
            }
            if (!empty($this->_socialUrls[$source])) {
                $socialLinks[] = Html::a($screenName, $this->_socialUrls[$source] . $screenName, ['target' => '_blank']);
            } else {
                $socialLinks[] = $screenName;
            }
        }

        return $socialLinks;
    }
}
