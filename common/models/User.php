<?php
namespace common\models;

use Yii;
use common\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\behaviors\ImageBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\components\Mailer;

/**
 * User model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $access_token
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar
 * @property integer $verified
 * @property integer $active
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_at
 * @property string $password write-only password
 *
 * @property string $imageUrl
 * @property string $imageThumbnailUrl
 * @property RoleModel $roles
 * @property string $roleName
 */
class User extends AbstractModel implements IdentityInterface
{
    public $password;
    public $confirm_password;
    public $roleName;

    const DEFAULT_ADMIN_ID = 1;

    const DEFAULT_ROLE = 'user';

    const ROLE_ADMIN = 'admin';

    const VERIFIED_NO = 0;
    const VERIFIED_YES = 1;

    const ACTIVE_NO = 0;
    const ACTIVE_YES = 1;

    const SCENARIO_WITH_PASSWORD = 'withPassword';

    public static function getVerifyStatuses()
    {
        return [
            self::VERIFIED_NO => Yii::t('yii', 'No'),
            self::VERIFIED_YES => Yii::t('yii', 'Yes'),
        ];
    }

    public static function getActiveStatuses()
    {
        return [
            self::ACTIVE_NO => Yii::t('yii', 'No'),
            self::ACTIVE_YES => Yii::t('yii', 'Yes'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            ReadOnlyBehavior::className(),
            [
                'class' => ImageBehavior::className(),
                'fieldName' => 'avatar',
            ]
        ];
    }

    /**
     * @inheritdocm
     */
    public function rules()
    {
        return [
            [['username', 'email', 'roleName'], 'required'],
            [['username', 'email', 'first_name', 'last_name', 'roleName'], 'trim'],
            [['verified', 'active'], 'boolean'],
            [['username'], 'string', 'min' => 2],
            [['username', 'password_hash', 'password_reset_token', 'access_token', 'email', 'avatar', 'roleName'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token', 'access_token'], 'unique'],
            [['email'], 'email'],
            [['password_hash'], 'required', 'on' => [self::SCENARIO_WITH_PASSWORD]],
            [['password', 'confirm_password'], 'required',
                'on' => [self::SCENARIO_WITH_PASSWORD],
                'when' => function ($model) { return empty($model->password_hash) && empty($model->password); },
                'whenClient' => 'function (attribute, value) { return !(' . (int) !empty($this->password_hash) . ' || value != "") || $("#user-password").val() != ""; }',
            ],
            [['password', 'confirm_password'], 'string', 'min' => 6],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password'],
            [['avatar'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'access_token' => Yii::t('app', 'Access Token'),
            'email' => Yii::t('app', 'E-mail'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'roleName' => Yii::t('app', 'Role'),
            'avatar' => Yii::t('app', 'Avatar'),
            'verified' => Yii::t('app', 'Verified'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Registered'),
            'updated_at' => Yii::t('app', 'Updated'),
            'last_login_at' => Yii::t('app', 'Last Login'),
            'created' => Yii::t('app', 'Registered'),
            'updated' => Yii::t('app', 'Updated'),
            'password' => Yii::t('app', 'Password'),
            'confirm_password' => Yii::t('app', 'Confirm Password'),
            'genderName' => Yii::t('app', 'Gender'),
            'fullName' => Yii::t('app', 'Full Name'),
            'imageThumbnailUrl' => Yii::t('app', 'Avatar'),
            'lastLogin' => Yii::t('app', 'Last Login'),
        ];
    }

    /**
     * Set attribute roleName
     */
    public function afterFind()
    {
        parent::afterFind();

        $this->roleName = $this->getRoleName();
    }

    /**
     * @param bool $insert
     * @param array $attributes
     */
    public function afterSave($insert, $attributes)
    {
        parent::afterSave($insert, $attributes);

        /**
         * Assign role by user;
         */
        if (empty($this->roleName)) {
            $this->roleName = self::DEFAULT_ROLE;
        }
        Yii::$app->authManager->updateRoleByUser($this->roleName, $this);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        /**
         * Remove assigned role for user
         */
        if (!Yii::$app->authManager->revokeAll($this->id)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'verified' => self::VERIFIED_YES, 'active' => self::ACTIVE_YES]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'verified' => self::VERIFIED_YES, 'active' => self::ACTIVE_YES]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'verified' => self::VERIFIED_YES,
            'active' => self::ACTIVE_YES,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Generates new access token
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes access token
     */
    public function removeAccessToken()
    {
        $this->access_token = null;
    }

    /**
     * @return boolean
     */
    public function beforeValidate()
    {
        if (!empty($this->password)) {
            $this->setPassword($this->password);
            $this->generateAuthKey();

            if (empty($this->roleName)) {
                $this->roleName = self::DEFAULT_ROLE;
            }
        }
        return parent::beforeValidate();
    }

    /**
     * @return boolean
     */
    public function afterValidate()
    {
        if (!empty($this->birthday)) {
            //$this->birthday = Yii::$app->formatter->asDate($this->birthday, 'php:U');
            $this->birthday = strtotime($this->birthday);
            //$this->birthday = $this->birthday / 100;
        }

        return parent::afterValidate();
    }

    /**
     * @return boolean
     */
    public function signup()
    {
        $this->generateAccessToken();
        if ($this->save()) {
            return (new Mailer())->sendSignupEmail($this);
        }
        return false;
    }

    /**
     * @return boolean
     */
    public function confirmSignup()
    {
        $this->verified = self::VERIFIED_YES;
        $this->removeAccessToken();
        return $this->save();
    }

    /**
     * Resets password.
     *
     * @param string $password
     * @return boolean if password was reset.
     */
    public function resetPassword($password)
    {
        $this->setPassword($password);
        $this->removePasswordResetToken();
        return $this->save(false);
    }

    /**
     * @param bool $active
     * @return bool
     */
    public function setActive($active = true)
    {
        $this->active = $active;
        return $this::save(false);
    }

    /**
     * @return boolean
     */
    public function reverseActive()
    {
        if ($this->active) {
            return $this->setActive(false);
        }
        return $this->setActive();
    }

    /**
     * @param $user User
     * @return boolean
     */
    public function mergeUser($user)
    {
        if ($this->id == $user->id) {
            return false;
        }

        // Link social acounts
        foreach ($user->auths as $auth) {
            $auth->user_id = $this->id;
            $auth->save();
        }

        $user->delete();

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoles()
    {
        return $this->hasMany(RoleModel::className(), ['name' => 'item_name'])
            ->viaTable('{{%auth_assignment}}', ['user_id'=>'id']);
    }

    /**
     * Get role name for user (rbac)
     *
     * @return mixed
     */
    public function getRoleName()
    {
        return $this->getRoles()->one()->name;
    }

    /**
     * @return \yii\rbac\Role[]
     */
    public static function getListRoles()
    {
        return Yii::$app->authManager->getRoles();
    }

    /**
     * @return string
     */
    public function getLastLogin()
    {
        return !empty($this->last_login_at) ? Yii::$app->formatter->asDatetime($this->last_login_at) : 'Not Set';
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return self::find()->select(['username', 'id'])->indexBy('id')->column();
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->roleName === self::ROLE_ADMIN;
    }
}
