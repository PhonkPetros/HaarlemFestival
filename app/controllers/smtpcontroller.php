<?php

namespace controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use smtpconfig\smtpconfig;


require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../config/smtpconfig.php';
require_once __DIR__ . '/../vendor/autoload.php';


class SMTPController
{
    private $mailer;
    private $config;


    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $configClass = new smtpconfig(); 
        $this->config = $configClass->getConfiguration();
    }

    public function sendEmail($toEmail, $toName, $subject, $message)
    {
        try { 
            $this->mailer->isSMTP();
            $this->mailer->Host = $this->config['smtp']['host'];
            $this->mailer->SMTPAuth = $this->config['smtp']['auth'];
            $this->mailer->Username = $this->config['smtp']['username'];
            $this->mailer->Password = $this->config['smtp']['password'];
            $this->mailer->SMTPSecure = $this->config['smtp']['secure'];
            $this->mailer->Port = $this->config['smtp']['port'];

            $this->mailer->setFrom('harlemitofestival@gmail.com', 'HaarlemFestival'); 
            $this->mailer->addAddress($toEmail, $toName);

            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $message;
            $this->mailer->AltBody = strip_tags($message);

            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sendInvoice($shoppingCart)
    {
        $subject = "Your Invoice from HaarlemFestival";
        $message = $this->generateInvoiceHtml($shoppingCart['ticketDetails']);
        
        return $this->sendEmail($shoppingCart['userDetails']['email'], $shoppingCart['userDetails']['username'], $subject, $message);
    }

    private function generateInvoiceHtml($items)
    {
        $totalPrice = 0;
        $html = "<h2>Invoice</h2>";
        $html .= "<table border='1' style='width:100%; border-collapse: collapse;'>";
        $html .= "<tr><th>Description</th><th>Quantity</th><th>Price</th><th>VAT</th><th>Total</th></tr>";

        foreach ($items as $item) {
            $itemTotal = $item['quantity'] * $item['price'];
            $itemVat = $itemTotal * ($item['vat'] / 100);
            $itemTotalIncVat = $itemTotal + $itemVat;

            $html .= "<tr>";
            $html .= "<td>" . $item['description'] . "</td>";
            $html .= "<td>" . $item['quantity'] . "</td>";
            $html .= "<td>" . $item['price'] . "</td>";
            $html .= "<td>" . $item['vat'] . "%</td>";
            $html .= "<td>" . number_format($itemTotalIncVat, 2) . "</td>";
            $html .= "</tr>";

            $totalPrice += $itemTotalIncVat;
        }

        $html .= "<tr><td colspan='4' style='text-align: right;'>Grand Total</td><td>" . number_format($totalPrice, 2) . "</td></tr>";
        $html .= "</table>";

        return $html;
    }




    public function sendTicket($toEmail, $toName, $ticketHash)
    {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
        ]);

        $qrcode = (new QRCode($options))->render($ticketHash);

        $subject = "Your Ticket for HaarlemFestival";
        $message = "<h2>Here is your ticket!</h2>"
                 . "<p>Please scan the QR code below to use your ticket.</p>"
                 . "<img src='{$qrcode}' alt='Ticket QR Code' />";

        return $this->sendEmail($toEmail, $toName, $subject, $message);
    }


}
