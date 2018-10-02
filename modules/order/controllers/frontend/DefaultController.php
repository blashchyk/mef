<?php
namespace modules\order\controllers\frontend;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use frontend\controllers\FrontController;
use modules\order\models\Order;
use modules\order\models\Cart;
use modules\country\models\Country;
use common\models\User;

/**
 * Site controller
 */
class DefaultController extends FrontController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        // Waiting for thank you for action fix
        if (Yii::$app->user->isGuest) {
            return Yii::$app->user->loginRequired();
        }
        $user = Yii::$app->user->getIdentity();

        $dataProvider = new ActiveDataProvider([
            'query' => Order::find()->where(['user_id' => $user->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionCart()
    {
        $cart = new Cart();
        $cartData = $cart->get();

        return $this->render('cart', [
            'items' => $cartData->items,
            'cartPrice' => $cartData->cartPrice,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCheckout()
    {
        $cart = new Cart();
        $cartData = $cart->get();

        $model = new Order();
        $model->loadProfileValues();

        $vatTax = 0;
        $totalPrice = $cartData->cartPrice;
        if (!empty($model->country)) {
            $vatTax = (int) $model->country->vat_rate;
            $totalPrice = $cartData->cartPrice + $cartData->cartPrice * $vatTax / 100;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect($model->add());
        }

        return $this->render('checkout', [
            'items' => $cartData->items,
            'cartPrice' => $cartData->cartPrice,
            'vatTax' => $vatTax,
            'totalPrice' => $totalPrice,
            'model' => $model,
        ]);
    }

    public function actionPrice()
    {
        $countryId = (int) Yii::$app->request->post('country_id');
        $vatTax = 0;
        $success = false;

        if (!empty($countryId)) {
            $country = Country::findOne($countryId);
            $vatTax = (int) $country->vat_rate;
            $success = true;
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'success' => $success,
            'vatTax' => $vatTax,
        ];
    }

    /**
     * @return string
     */
    public function actionPay()
    {
        $get = Yii::$app->request->get();

        $paymentId = $get['paymentId'];
        $payerId = $get['PayerID'];

        $transactionId = Yii::$app->paypal->executePay($paymentId, $payerId);

        if (empty($transactionId)) {
            return $this->redirect(['cancel']);
        }

        $order = Order::findOne(['payment_id' => $paymentId]);
        if (!empty($order)) {
            //$order->pp_response = \yii\helpers\Json::encode($_GET);
            $order->transaction_id = $transactionId;
            $order->status = Order::STATUS_DONE;
            $order->save();
        }

        return $this->redirect(['thank']);
    }

    /**
     * @return null
     */
    public function actionSeccall()
    {
        if ($_POST) {
            $post_data = $_POST;
            if ($post_data['payment_status'] == 'Completed') {
                $order = Order::findOne(['txn_id' => $post_data['txn_id']]);
                if (!empty($order)) {
                    $order->status = 1;
                    $order->save();
                }
            }
//        Yii::info('success123', 'info');

            /*
            By default the IpnListener object is going  going to post the data back to PayPal
            using cURL over a secure SSL connection. This is the recommended way to post
            the data back, however, some people may have connections problems using this
            method.

            To post over standard HTTP connection, use:
            $listener->use_ssl = false;

            To post using the fsockopen() function rather than cURL, use:
            $listener->use_curl = false;
            */
            /*
            The processIpn() method will encode the POST variables sent by PayPal and then
            POST them back to the PayPal server. An exception will be thrown if there is
            a fatal error (cannot connect, your server is not configured properly, etc.).
            Use a try/catch block to catch these fatal errors and log to the ipn_errors.log
            file we setup at the top of this file.

            The processIpn() method will send the raw data on 'php://input' to PayPal. You
            can optionally pass the data to processIpn() yourself:
            $verified = $listener->processIpn($my_post_data);
            */
            try {
                $verified = Yii::$app->ipnlistener->processIpn($post_data);
            } catch (\Exception $e) {
//                Yii::info('errors from IpnListener', 'info');
                error_log($e->getMessage());
                exit(0);
            }

            /*
            The processIpn() method returned true if the IPN was "VERIFIED" and false if it
            was "INVALID".
            */
            if ($verified) {
                /*
                Once you have a verified IPN you need to do a few more checks on the POST
                fields--typically against data you stored in your database during when the
                end user made a purchase (such as in the "success" page on a web payments
                standard button). The fields PayPal recommends checking are:

                    1. Check the $_POST['payment_status'] is "Completed"
                    2. Check that $_POST['txn_id'] has not been previously processed
                    3. Check that $_POST['receiver_email'] is your Primary PayPal email
                    4. Check that $_POST['payment_amount'] and $_POST['payment_currency']
                       are correct

                Since implementations on this varies, I will leave these checks out of this
                example and just send an email using the getTextReport() method to get all
                of the details about the IPN.
                */
                Yii::info(Yii::$app->ipnlistener->getTextReport(), 'paypal_dev');
                //mail('YOUR EMAIL ADDRESS', 'Verified IPN', $listener->getTextReport());
            } else {
                /*
                An Invalid IPN *may* be caused by a fraudulent transaction attempt. It's
                a good idea to have a developer or sys admin manually investigate any
                invalid IPN.
                */
                Yii::info(Yii::$app->ipnlistener->getTextReport(), 'paypal_dev');
                //mail('YOUR EMAIL ADDRESS', 'Invalid IPN', $listener->getTextReport());
            }
        }
    }

    /**
     * @return string
     */
    public function actionThank()
    {
        $cart = new Cart();
        $cart->clear();

        return $this->render('thank');
    }

    /**
     * @return string
     */
    public function actionCancel()
    {
        $cart = new Cart();
        $cart->clear();

        return $this->render('cancel');
    }

    /**
     * Add a product to cart
     *
     * @param $id
     * @return \yii\web\Response
     */
    public function actionAdd($id)
    {
        $cart = new Cart();
        $cart->add($id);
        return $this->redirect(['cart']);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionRemove($id)
    {
        $cart = new Cart();
        $cart->remove($id);
        return $this->redirect(['cart']);
    }

    /**
     * @param $id
     * @return Response
     */
    public function actionUpdate($id)
    {
        $amount = (int) Yii::$app->request->post('amount');
        $cart = new Cart();
        $cart->update($id, $amount);
        return $this->redirect(['cart']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUser()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
        }

        $id = Yii::$app->user->id;
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
