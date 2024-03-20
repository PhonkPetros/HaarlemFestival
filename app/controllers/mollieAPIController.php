<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';
use Mollie\Api\MollieApiClient;
use Mollie\Api\Exceptions\ApiException;

class MollieAPIController
{
    private $mollieClient;

    public function __construct()
    {
        $this->mollieClient = new MollieApiClient();
        $this->mollieClient->setApiKey("test_2h39fKdqarwsuAwkFwhGsDFh5eppSH");
    }

    public function createPayment($userId, $cart, $paymentMethod, $issuer = null)
    {
        $totalPrice = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['ticketPrice'])*1.21;
        }, 0);

        $totalPriceStr = number_format($totalPrice, 2, '.', '');

        try {
            $paymentData = [
                "amount" => [
                    "currency" => "EUR",
                    "value" => (string)$totalPriceStr,
                ],
                "description" => "Payment for tickets",
                "redirectUrl" => "http://localhost/my-program/payment-success", 
                "metadata" => [
                    "order_id" => uniqid(),
                    "user_id" => $userId,
                ],
            ];

            
            $payment = $this->mollieClient->payments->create($paymentData);
            //use payement id to retrieve the id of a payment and then create a check inside the payment success to check
            // the status of the payment if its anything else thats not paid then display payment failure page
            $payment->id;
            return [
                'status' => 'success',
                'paymentUrl' => $payment->getCheckoutUrl(),
            ];
        } catch (ApiException $e) {
            error_log("API call failed: " . $e->getMessage()); 
            return [
                'status' => 'error',
                'message' => "API call failed: " . htmlspecialchars($e->getMessage()),
            ];
        }
        
    }

}
