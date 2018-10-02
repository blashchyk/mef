<?php
namespace modules\profile;

use yii\base\BootstrapInterface;
use common\models\User;
use yii\base\Event;
use yii\db\AfterSaveEvent;
use modules\profile\models\Profile;
use modules\profile\behaviors\ProfileBehavior;

/**
 * page module definition class
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app) {
        // Register event on every user model init
        Event::on(User::className(), User::EVENT_INIT, function(Event $e) {
            // Add profile to user after insert into db
            $e->sender->on(User::EVENT_AFTER_INSERT, function(AfterSaveEvent $insertEvent) {
                $this->ensureProfile($insertEvent);
            });
            // Add profile to user on load if user already has been created before (on active profile module afterwards)
            $e->sender->on(User::EVENT_AFTER_FIND, function(Event $event) {
                if ((Profile::findOne(['user_id' => $event->sender->id])) === null) {
                    $this->ensureProfile($event);
                }
            });

            $e->sender->attachBehavior('prof', ProfileBehavior::className());
        });
    }

    private function ensureProfile(Event $event){
        $profile = new Profile();
        /** @var User $user*/
        $user = $event->sender;
        $profile->loadDefaultValues();
        $profile->link('user', $user);
    }
}
