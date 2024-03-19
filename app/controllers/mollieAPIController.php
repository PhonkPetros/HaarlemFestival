<?
namespace controllers;

require_once __DIR__ . '/../vendor/autoload.php';
use Mollie\Api\MollieApiClient;

class MollieAPIController
{
    private $mollieClient;

    public function __construct()
    {
        $this->mollieClient = new MollieApiClient();
        $this->mollieClient->setApiKey("test_kjmzHm5KuU95Av2gkJDKVRJDCBdyk5");
    }

    public function createPayment($userInfo, $cart)
    {
        // Calculate total price from the cart
        $totalPrice = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['quantity'] * $item['ticketPrice']);
        }, 0);

        // Convert total price to a string format expected by Mollie (e.g., "10.00")
        $totalPriceStr = number_format($totalPrice, 2, '.', '');

        try {
            $payment = $this->mollieClient->payments->create([
                "amount" => [
                    "currency" => "EUR", // Adjust currency if necessary
                    "value" => (string) $totalPriceStr,
                ],
                "description" => "Payment for tickets",
                "redirectUrl" => "http://localhost/payment-success",
                "webhookUrl" => "https://yourdomain.com/webhook", 
                "metadata" => [
                    "order_id" => uniqid(),
                    "user_info" => $userInfo,
                ],
            ]);

            return [
                'status' => 'success',
                'paymentUrl' => $payment->getCheckoutUrl(),
            ];
        } catch (\Mollie\Api\Exceptions\ApiException $e) {
            echo "API call failed: " . htmlspecialchars($e->getMessage());
            return [
                'status' => 'error',
                'message' => "API call failed: " . $e->getMessage(),
            ];
        }
    }
}
