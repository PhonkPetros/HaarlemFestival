<?php

namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';
use Mollie\Api\MollieApiClient;
use Mollie\Api\Exceptions\ApiException;
require_once __DIR__ . '/../config/constant-paths.php';

class MollieAPIController
{
    private $mollieClient;

    public function __construct()
    {
        $this->mollieClient = new MollieApiClient();
        $this->mollieClient->setApiKey(MOLLIE_KEY);
    }

    public function createPayment($userId, $cart, $paymentMethod, $issuer = null)
    {
        $totalPrice = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['ticketPrice']) * 1.21;
        }, 0);

        $totalPriceStr = number_format($totalPrice, 2, '.', '');

        try {
            $paymentData = [
                "amount" => [
                    "currency" => "EUR",
                    "value" => (string) $totalPriceStr,
                ],
                "description" => "Payment for tickets",
                "redirectUrl" => "http://localhost/my-program/payment-success",
                "metadata" => [
                    "order_id" => uniqid(),
                    "user_id" => $userId,
                ],
            ];


            $payment = $this->mollieClient->payments->create($paymentData);
        
            $_SESSION['payment_id'] = $payment->id;

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

    public function getPaymentStatus($paymentId)
    {
        try {
            $payment = $this->mollieClient->payments->get($paymentId);
            return $payment->status;
        } catch (ApiException $e) {
            error_log("API call failed: " . $e->getMessage());
            return null;
        }
    }


}
