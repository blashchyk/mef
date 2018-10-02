<?php

namespace common\components;

use Yii;
use yii\base\Object;
use common\models\User;
use common\models\Auth;

class AuthSocial extends Object
{
    const ERROR_USER_EXISTS = 0;
    const ERROR_TOKEN_EXISTS = 1;
    const ERROR_TOKEN_LINKED = 1;
    const ERROR_ACCESS_DENY = 3;

    const SUCCESS_TOKEN_LINKED = 4;
    const SUCCESS_USER_MERGED = 5;

    private $allowAdminOnly;

    private $profilePage;
    private $loginPage;

    /**
     * AuthSocial constructor.
     * @param bool $allowAdminOnly
     * @param string $profilePage
     * @param string $loginPage
     * @param null $config
     */
    public function __construct($allowAdminOnly = false, $profilePage = '/', $loginPage = '/', $config = null)
    {
        $this->allowAdminOnly = $allowAdminOnly;
        $this->profilePage = $profilePage;
        $this->loginPage = $loginPage;

        parent::__construct($config);
    }

    /**
     * @param $options
     * @return array
     */
    private static function getMessages($options)
    {
        return [
            self::ERROR_USER_EXISTS => Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it.<br /> Login using email first to link it.", $options),
            self::ERROR_TOKEN_EXISTS => Yii::t('app', 'The {client} account is already linked to a different user.', $options),
            self::ERROR_TOKEN_LINKED => Yii::t('app', 'The {client} account is already linked to your user.', $options),
            self::ERROR_ACCESS_DENY => Yii::t('app', 'You are not allowed to perform this action.<br /> Only registered administrators can login to the Admin Panel.', $options),
            self::SUCCESS_TOKEN_LINKED => Yii::t('app', 'The {client} account is successfully linked to your user.', $options),
            self::SUCCESS_USER_MERGED => Yii::t('app', 'The {client} account is successfully linked to your user.<br /> The data associated with an old user logged with the {client} account before is merged with your user now.', $options),
        ];
    }

    /**
     * @param $client
     * @return $this
     */
    public function onAuthSuccess($client)
    {
        $clientId = $client->getId();
        $fields = $client->getUserAttributes();
        $fields = $this->convertFields((object) $fields, $client);

        $auth = Auth::find()->where((['source' => $clientId, 'source_id' => $fields->id]))->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) {
                if (!$this->allowAdminOnly || $auth->user->roleName > User::DEFAULT_ROLE) {
                    Yii::$app->user->login($auth->user);
                    if (!$this->allowAdminOnly) {
                        return Yii::$app->response->redirect($this->profilePage);
                    }
                } else {
                    $this->showMessage(self::ERROR_ACCESS_DENY);
                    return Yii::$app->response->redirect($this->loginPage);
                }
            } else {
                if (isset($fields->email) && User::findOne(['email' => $fields->email])) {
                    $this->showMessage(self::ERROR_USER_EXISTS, ['client' => $client->getTitle()]);
                } else {
                    if (!$this->allowAdminOnly) {
                        $user = $this->registerUser($fields, $clientId);
                        if ($user) {
                            Yii::$app->user->login($user);
                            if (!$this->allowAdminOnly) {
                                return Yii::$app->response->redirect($this->profilePage);
                            }
                        }
                    } else {
                        $this->showMessage(self::ERROR_ACCESS_DENY);
                        return Yii::$app->response->redirect($this->loginPage);
                    }
                }
            }
        } else {
            if (!$auth) {
                if ($this->addAuth(Yii::$app->user->id, $clientId, $fields)) {
                    $this->showMessage(self::SUCCESS_TOKEN_LINKED, ['client' => $client->getTitle()], 'success');
                }
            } else {
                //$this->showMessage(self::ERROR_TOKEN_EXISTS, ['client' => $client->getTitle()]);
                if (Yii::$app->user->getIdentity()->mergeUser($auth->user)) {
                    $this->showMessage(self::SUCCESS_USER_MERGED, ['client' => $client->getTitle()], 'success');
                } else {
                    $this->showMessage(self::ERROR_TOKEN_LINKED, ['client' => $client->getTitle()]);
                }
            }
            return Yii::$app->response->redirect($this->profilePage);
        }
    }

    /**
     * @param $fields
     * @param $clientId
     * @return User|null
     * @throws \yii\db\Exception
     */
    private function registerUser($fields, $clientId)
    {
        $user = new User();
        $user->username = $fields->username;
        $user->email = !empty($fields->email) ? $fields->email : null;
        $user->first_name = !empty($fields->first_name) ? $fields->first_name : '';
        $user->last_name = !empty($fields->last_name) ? $fields->last_name : '';
//        $user->gender = !empty($fields->gender) ? $fields->gender : User::GENDER_MALE;
        $user->password = Yii::$app->security->generateRandomString(6);
        $user->roleName = User::DEFAULT_ROLE;
        $user->verified = User::VERIFIED_YES;
        $user->generateAuthKey();
        //$user->generatePasswordResetToken();

        $transaction = $user->getDb()->beginTransaction();

        if ($user->save(false)) {
            if (!empty($fields->avatar) && Yii::$app->storage->copyImageFromUrl($user, 'avatar', $fields->avatar)) {
                $user->save(false);
            }

            $auth = $this->addAuth($user->id, $clientId, $fields);
            if ($auth) {
                $transaction->commit();
                return $user;
            }
        }

        return null;
    }

    /**
     * @param $fields
     * @param $client
     * @return mixed
     */
    private function convertFields($fields, $client)
    {
        switch ($client->getId()) {
            case 'google':
                $fields->email = $fields->emails[0]['value'];
                $fields->username = $this->getUsernameFromEmail($fields->email);
                $fields->first_name = $fields->name['givenName'];
                $fields->last_name = $fields->name['familyName'];
                $fields->avatar = !empty($fields->image) ? substr($fields->image['url'], 0, strpos($fields->image['url'], '?')) : null;
                break;
            case 'facebook':
                $fields->username = $this->getUsernameFromEmail($fields->email);
                $userInfo = (object) $client->api($fields->id . '?fields=birthday,picture,gender,hometown,first_name,last_name', 'GET');
                $fields->first_name = $userInfo->first_name;
                $fields->last_name = $userInfo->last_name;
//                $fields->gender = !empty($userInfo->gender) && $userInfo->gender == 'female' ? User::GENDER_FEMALE : User::GENDER_MALE;
                $fields->avatar = !empty($userInfo->picture) && !empty($userInfo->picture['data']['url']) ? $userInfo->picture['data']['url'] : null;
                break;
            case 'twitter':
                $fields->username = $fields->screen_name;
                $fields->first_name = substr($fields->name, 0, strpos($fields->name, ' '));
                $fields->last_name = substr($fields->name, strpos($fields->name, ' '));
                $fields->avatar = !empty($fields->profile_image_url) ? str_replace('_normal.', '.', $fields->profile_image_url) : null;
                break;
            case 'vkontakte':
                $fields->username = $fields->screen_name;
//                $fields->gender = $fields->sex;
                $fields->avatar = !empty($fields->photo) ? $fields->photo : null;
                break;
        }

        $fields->username = $this->getUniqueUsername($fields->username);

        return $fields;
    }

    /**
     * @param $userId
     * @param $clientId
     * @param $fields
     * @return Auth|null
     */
    private function addAuth($userId, $clientId, $fields)
    {
        $auth = new Auth();
        $auth->user_id = $userId;
        $auth->source = $clientId;
        $auth->source_id = $fields->id;
        $auth->screen_name = !empty($fields->screen_name) ? $fields->screen_name : null;

        if ($auth->save(false)) {
            return $auth;
        }

        return null;
    }

    /**
     * @param $email
     * @return mixed
     */
    private function getUsernameFromEmail($email)
    {
        return substr($email, 0, strpos($email, '@'));
    }

    /**
     * @param $username
     * @return string
     */
    private function getUniqueUsername($username)
    {
        $suffix = 0;
        $name = $username;
        while (User::findOne(['username' => $name])) {
            $suffix++;
            $name = $username . $suffix;
        }
        return $name;
    }

    /**
     * @param $errorId
     * @param array $options
     * @param string $type
     */
    private function showMessage($errorId, $options = [], $type = 'error')
    {
        Yii::$app->getSession()->setFlash($type, [self::getMessages($options)[$errorId]]);
    }
}
