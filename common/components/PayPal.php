<?php
namespace common\components;

use Yii;
use yii\helpers\Url;
use yii\base\Component;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

class PayPal extends Component
{
    public $clientId;
    public $clientSecret;
    
    private $apiContext;

    /**
     * @return null
     */
    function init()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential($this->clientId, $this->clientSecret)
        );
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->apiContext;
    }

    /**
     * @param $price
     * @return bool|Payment
     */
    public function getPayment($price)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency(Yii::$app->formatter->currencyCode)
            ->setTotal($price);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription('CMS Shop: Online Order');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(Url::to(['/order/pay'], true))
            ->setCancelUrl(Url::to(['/order/cancel'], true));

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->getContext());
        } catch (\Exception $ex) {
            return false;
        }

        return $payment;
    }

    /**
     * @param $paymentId
     * @param $payerId
     * @return null
     */
    public function executePay($paymentId, $payerId)
    {
        if (empty($paymentId) || empty($payerId)) {
            return null;
        }

        $transactionId = null;

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->apiContext);
            $transactionId = explode('"', explode('/sale/', $result)[1])[0];
            $payment = Payment::get($paymentId, $this->apiContext);
        } catch (\Exception $ex) {
            return null;
        }

        return $transactionId;
    }
}
