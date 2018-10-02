<?php

namespace modules\profile\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\CreatorBehavior;
use common\behaviors\ReadOnlyBehavior;
use common\models\User;
use modules\country\models\Country;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $id
 * @property integer $country_id
 * @property string $city
 * @property string $address
 * @property string $phone
 * @property string $zip
 * @property integer $birthday
 * @property integer $gender
 *
 * @property User $user
 * @property Country $country
 * @property string $genderName
 */
class Profile extends ActiveRecord
{

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    public static function getGenders()
    {
        return [
            self::GENDER_MALE => Yii::t('app', 'Male'),
            self::GENDER_FEMALE => Yii::t('app', 'Female'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            CreatorBehavior::className(),
            ReadOnlyBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zip', 'city', 'address', 'phone', 'birthday'], 'trim'],
            [['user_id', 'country_id'], 'integer'],
            [['gender'], 'boolean'],
            [['city', 'address'], 'string', 'max' => 100],
            [['zip'], 'string', 'max' => 10],
            [['phone'], 'string', 'max' => 50],
            [['birthday'], 'date', 'format' => 'php:Y-m-d'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Owner'),
            'country' => Yii::t('app', 'Name'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'phone' => Yii::t('app', 'Phone'),
            'birthday' => Yii::t('app', 'Birthday'),
            'gender' => Yii::t('app', 'Gender'),
            'genderName' => Yii::t('app', 'Gender'),
        ];
    }

    public function afterValidate()
    {
        if (!empty($this->birthday)) {
            $this->birthday = strtotime($this->birthday);
        }
        return parent::afterValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return self::find()->select(['name', 'id'])->indexBy('id')->column();
    }

    /**
     * @return string
     */
    public function getGenderName()
    {
        return self::getGenders()[$this->gender];
    }

}
