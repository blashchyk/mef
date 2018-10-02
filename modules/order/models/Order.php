<?php

namespace modules\order\models;

use Yii;
use yii\db\ActiveRecord;
use common\behaviors\TimestampBehavior;
use common\behaviors\CreatorBehavior;
use common\behaviors\ReadOnlyBehavior;
use modules\country\models\Country;
use common\models\User;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property integer $country_id
 * @property string $zip
 * @property string $city
 * @property string $address
 * @property string $phone
 * @property double $price
 * @property integer $vat_tax
 * @property string $description
 * @property string $payment_id
 * @property string $transaction_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Country $country
 * @property User $user
 * @property OrderItem[] $orderItems
 */
class Order extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_DONE = 1;

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => Yii::t('yii', 'Pending'),
            self::STATUS_DONE => Yii::t('yii', 'Done'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
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
            [['user_id', 'country_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'country_id', 'last_name', 'zip', 'city', 'address', 'phone'], 'required'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['first_name', 'last_name', 'city', 'address'], 'string', 'max' => 100],
            [['zip'], 'string', 'max' => 10],
            [['phone', 'payment_id', 'transaction_id'], 'string', 'max' => 50],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'country_id' => Yii::t('app', 'Country'),
            'zip' => Yii::t('app', 'Zip'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'phone' => Yii::t('app', 'Phone'),
            'price' => Yii::t('app', 'Item Price'),
            'vat_tax' => Yii::t('app', 'Vat Tax'),
            'description' => Yii::t('app', 'Note'),
            'payment_id' => Yii::t('app', 'Payment'),
            'transaction_id' => Yii::t('app', 'Transaction'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'fullName' => Yii::t('app', 'Full Name'),
            'statusName' => Yii::t('app', 'Status'),
            'location' => Yii::t('app', 'Location'),
            'fullAddress' => Yii::t('app', 'Full Address'),
        ];
    }

    public function add()
    {
        $cart = new Cart();
        $cartData = $cart->get();
        if (!empty($cartData->items)) {
            foreach ($cartData->items as $item) {
                $this->price += $item->price * $item->amount;
            }
        }

        if (!empty($this->country)) {
            $country = Country::findOne($this->country_id);
            if (!empty($country)) {
                $this->vat_tax = $country->vat_rate;
            }
        }

        if (!$this->save()) {
            return false;
        }

        if (!empty($cartData->items)) {
            foreach ($cartData->items as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $this->id;
                $orderItem->product_id = $item->id;
                $orderItem->amount = $item->amount;
                $orderItem->item_price = $item->price;
                $orderItem->save();
            }
        }

        $payment = Yii::$app->paypal->getPayment($this->price);
        $this->payment_id = $payment->id;
        $this->save();

        return $payment->getApprovalLink();
    }

    /**
     * return mixed
     */
    public function loadProfileValues()
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->getIdentity();
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->country_id = $user->country_id;
            $this->zip = $user->zip;
            $this->city = $user->city;
            $this->address = $user->address;
            $this->phone = $user->phone;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
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
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return !empty(Order::getStatuses()[$this->status]) ? Order::getStatuses()[$this->status] : null;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return ($this->country ? $this->country->name : '') . ' ' . $this->city . ' ' . $this->zip;
    }

    /**
     * @return string
     */
    public function getFullAddress()
    {
        return $this->location . ' ' . $this->address;
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->price + $this->price * $this->vat_tax / 100;
    }
}
