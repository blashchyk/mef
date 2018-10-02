<?php

namespace modules\order\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use common\behaviors\ReadOnlyBehavior;
use modules\catalog\models\Product;

/**
 * This is the model class for table "{{%order_item}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $amount
 * @property double $item_price
 *
 * @property Product $product
 * @property Order $order
 */
class OrderItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_item}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            ReadOnlyBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'amount', 'item_price'], 'required'],
            [['order_id', 'product_id', 'amount'], 'integer'],
            [['item_price'], 'number'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order'),
            'product_id' => Yii::t('app', 'Product'),
            'amount' => Yii::t('app', 'Amount'),
            'item_price' => Yii::t('app', 'Item Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @param $id
     * @return ActiveDataProvider
     */
    public static function getList($orderId, $pageSize = 10)
    {
        $query = self::find()->where(['order_id' => $orderId])->joinWith(['product'])->limit(10);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $dataProvider->pagination->pageSize = $pageSize;

        $dataProvider->sort->attributes['product_id'] = [
            'asc' => ['{{%ctlg_product}}.name' => SORT_ASC],
            'desc' => ['{{%ctlg_product}}.name' => SORT_DESC],
        ];
        
        return $dataProvider;
    }
}
