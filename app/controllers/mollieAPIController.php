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
        $this->mollieClient->setApiKey("test_UDrK5yJUKaPRw2qKNNPtJhrmSx9kG7");
    }

    public function createPayment($userId, $cart, $paymentMethod, $issuer = null)
    {
        $totalPrice = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['ticketPrice']);
        }, 0);

        $totalPriceStr = number_format($totalPrice, 2, '.', '');

        try {
            $paymentData = [
                "amount" => [
                    "currency" => "EUR",
                    "value" => (string) $totalPriceStr, 
                ],
                "description" => "Payment for tickets",
                "redirectUrl" => "http://localhost/payment-success", // Adjust the URL to your needs
                "metadata" => [
                    "order_id" => uniqid(),
                    "user_id" => $userId,
                ],
            ];

            if ($paymentMethod === 'ideal' && $issuer) {
                $paymentData['method'] = $paymentMethod;
                $paymentData['issuer'] = $issuer; 
            } else if ($paymentMethod === 'creditcard') {
                $paymentData['method'] = $paymentMethod;
            }

            $payment = $this->mollieClient->payments->create($paymentData);

            return [
                'status' => 'success',
                'paymentUrl' => $payment->getCheckoutUrl(),
            ];
        } catch (ApiException $e) {
            return [
                'status' => 'error',
                'message' => "API call failed: " . htmlspecialchars($e->getMessage()),
            ];
        }
    }
}
