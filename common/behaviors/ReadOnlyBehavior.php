<?php

namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\helpers\Url;

class ReadOnlyBehavior extends Behavior
{
    protected $stopEventName = 'stopEvent';

    public $demoUserName = 'demo';

    /**
     * @var array
     */
    public $processedEvents = [
        ActiveRecord::EVENT_BEFORE_INSERT,
        ActiveRecord::EVENT_BEFORE_UPDATE,
        ActiveRecord::EVENT_BEFORE_DELETE,
    ];

    /**
     * @param $config
     */
    public function __construct($config = null)
    {
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function events()
    {
        $events = [];

        foreach ($this->processedEvents as $event) {
            $events[$event] = $this->stopEventName;
        }

        return $events;
    }

    /**
     * @param $event
     * @return boolean
     */
    public function stopEvent($event)
    {
        $user = Yii::$app->user;
        $readOnly = Yii::$app->params['readOnlyMode'];

        if (!$user->isGuest && $user->identity->username == $this->demoUserName || $readOnly) {
            Yii::$app->response->redirect(Url::to(['/site/read-only']))->send();
            exit();
        }

        return true;
    }
}
