<?php

namespace modules\order\models;

use Yii;
use modules\catalog\models\Product;

class Cart
{
    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            throw new \Exception();
        }
    }

    /**
     * @return object
     */
    public function get()
    {
        $items = Yii::$app->session['items'];
        $products = [];
        $cartPrice = 0;
        if (!empty($items)) {
            foreach ($items as $id => $amount) {
                $product = Product::findOne($id);
                if (!empty($product)) {
                    $products[] = (object)[
                        'id' => $product->id,
                        'name' => $product->name,
                        'amount' => $amount,
                        'price' => $product->price,
                    ];
                    $cartPrice += $amount * $product->price;
                }
            }
        }
        return (object) [
            'items' => $products,
            'cartPrice' => $cartPrice,
        ];
    }

    /**
     * @param $id
     */
    public function add($id)
    {
        $items = Yii::$app->session['items'];
        if (empty($items[$id])) {
            $items[$id] = 0;
        }

        $items[$id]++;
        Yii::$app->session['items'] = $items;
    }

    /**
     * @param $id
     */
    public function remove($id)
    {
        $items = Yii::$app->session['items'];
        if (!empty($items[$id])) {
            unset($items[$id]);
        }
        Yii::$app->session['items'] = $items;
    }

    /**
     * @param $id
     * @param $amount
     */
    public function update($id, $amount)
    {
        $items = Yii::$app->session['items'];
        $items[$id] = $amount;
        Yii::$app->session['items'] = $items;
    }

    /**
     * @return null
     */
    public function clear()
    {
        Yii::$app->session['items'] = null;
    }
}
