<?php

namespace controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use smtpconfig\smtpconfig;
use services\ticketservice;
use mPDF\mpdf;




require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../config/smtpconfig.php';

require_once __DIR__ . '/../services/ticketservice.php';


class SMTPController
{
    private $mPDF;
    private $mailer;
    private $config;
    private $ticketService;
    private $mpdf;


    public function __construct()
    {
        $mpdf = new \mPDF\mpdf();
        $this->mailer = new PHPMailer(true);
        $configClass = new smtpconfig(); 
        $this->ticketService = new ticketservice();
        $this->config = $configClass->getConfiguration();
    }

    public function sendEmail($toEmail, $toName, $subject, $message, $attachment)
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

            if ($attachment !== null) {
                $this->mailer->addStringAttachment($attachment['data'], $attachment['filename'], 'base64', $attachment['type']);
            }
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

    public function sendInvoice($toEmail, $firstName, $shoppingCart, $orderID)
    {
        $subject = "Your Invoice from HaarlemFestival";
        
        // Generate the PDF invoice and get its file path
        $pdfFilePath = $this->generateInvoicePdf($shoppingCart, $orderID);
        
        if (!$pdfFilePath || !file_exists($pdfFilePath)) {
            return false;
        }
        
        $message = "Dear " . htmlspecialchars($firstName) . ",<br><br>" .
                "Thank you for your purchase at HaarlemFestival. Please find attached your invoice.<br><br>" .
                "Best regards,<br>" .
                "HaarlemFestival Team";
        
        // Prepare the attachment array with the correct path and filename
        $attachment = [
            'path' => $pdfFilePath,
            'name' => 'Invoice_' . $orderID . '.pdf'
        ];
        
        // Call sendEmail with the correct parameters
        return $this->sendEmail($toEmail, $firstName, $subject, $message, $attachment);
    }


    private function generateInvoiceHtml($shoppingCartItems, $orderID)
    {
        $invoiceDate = date('Y-m-d');

        $tableStyle = "style='border-collapse: collapse; width: 100%;'";
        $thStyle = "style='border: 1px solid #dddddd; text-align: left; padding: 8px; background-color: #f2f2f2;'";
        $tdStyle = "style='border: 1px solid #dddddd; text-align: left; padding: 8px;'";
        $summaryStyle = "style='border: 1px solid #dddddd; text-align: right; padding: 8px; font-weight: bold;'";
        $totalStyle = "style='border: 1px solid #dddddd; text-align: right; padding: 8px; background-color: #f9f9f9;'";

        $html = "<h2>Invoice</h2>";

        $totalPriceBeforeVAT = 0;
        $totalVAT = 0;

        if (count($shoppingCartItems) > 0) {
            $firstItem = $shoppingCartItems[0];
            $userInfo = $firstItem['user'];

            $html .= "<p>Invoice Number: <span>" . htmlspecialchars($orderID) . "</span></p>";
            $html .= "<p>Invoice Date: <span>$invoiceDate</span></p>";
            $html .= "<p>Name: <span>" . htmlspecialchars($userInfo['firstName'] . ' ' . $userInfo['lastName']) . "</span></p>";
            $html .= "<p>Phone Number: <span>" . htmlspecialchars($userInfo['phoneNumber']) . "</span></p>";
            $html .= "<p>Address: <span>" . htmlspecialchars($userInfo['address']) . "</span></p>";
            $html .= "<p>Email Address: <span>" . htmlspecialchars($userInfo['email']) . "</span></p>";
        } else {
            return "No items in the cart.";
        }

        $html .= "<table $tableStyle>";
        $html .= "<tr><th $thStyle>Description</th><th $thStyle>Quantity</th><th $thStyle>Price (excl. VAT)</th><th $thStyle>VAT</th><th $thStyle>Total (incl. VAT)</th></tr>";

        foreach ($shoppingCartItems as $item) {
            $quantity = (int) $item['quantity'];
            $pricePerItemBeforeVAT = (float) $item['ticketPrice']; 
            $vatAmountPerItem = $pricePerItemBeforeVAT * (21 / 100);
            $totalPricePerItemWithVAT = ($pricePerItemBeforeVAT + $vatAmountPerItem) * $quantity;

            $totalPriceBeforeVAT += $pricePerItemBeforeVAT * $quantity;
            $totalVAT += $vatAmountPerItem * $quantity;
            $eventName = $this->ticketService->getEventName($item['eventId']);
         

            $description = "Event Name: " .$eventName . " Date: " . $item['ticketDate'] . " Time: " . $item['ticketTime'];

            $html .= "<tr>";
            $html .= "<td $tdStyle>$description</td>";
            $html .= "<td $tdStyle>" . htmlspecialchars($quantity) . "</td>";
            $html .= "<td $tdStyle>$" . htmlspecialchars(number_format($pricePerItemBeforeVAT, 2)) . "</td>";
            $html .= "<td $tdStyle>$" . htmlspecialchars(number_format($vatAmountPerItem, 2)) . " (21%)</td>";
            $html .= "<td $tdStyle>$" . htmlspecialchars(number_format($totalPricePerItemWithVAT, 2)) . "</td>";
            $html .= "</tr>";
        }

        $html .= "<tr><td colspan='4' $summaryStyle>Subtotal</td><td $totalStyle>$" . number_format($totalPriceBeforeVAT, 2) . "</td></tr>";
        $html .= "<tr><td colspan='4' $summaryStyle>Total VAT</td><td $totalStyle>$" . number_format($totalVAT, 2) . "</td></tr>";
        $html .= "<tr><td colspan='4' $summaryStyle><strong>Grand Total (incl. VAT)</strong></td><td $totalStyle><strong>$" . number_format($totalPriceBeforeVAT + $totalVAT, 2) . "</strong></td></tr>";
        $html .= "</table>";

        return $html;
    }

    public function sendTickets($toEmail, $toName, $ticketHashes)
    {
        $subject = "Your Tickets for HaarlemFestival";
        $message = "<h2>Here are your tickets!</h2>
                <p>Thank you for your purchase! Below, you can find your tickets as attachments.</p>
                <p>Please scan the QR codes below to use your tickets.</p>";

        foreach ($ticketHashes as $ticketHash) {
            $ticketHashString = (string) $ticketHash;

            $qrCode = QrCode::create($ticketHashString)
                ->setSize(300)
                ->setMargin(10);
            $writer = new PngWriter();

            ob_start();
            $writer->write($qrCode)->saveToFile('php://output');
            $imageData = ob_get_contents();
            ob_end_clean();

            $base64Image = base64_encode($imageData);
            $dataUri = 'data:image/png;base64,' . $base64Image;


            $attachment = [
                'data' => $imageData,
                'filename' => "ticket_$ticketHashString.png",
                'type' => 'image/png'
            ];

            $this->sendEmail($toEmail, $toName, $subject, $message, $attachment);
        }

        return true;
    }


    private function generateInvoicePdf($shoppingCartItems, $orderID)
    {
        // Generate the invoice HTML as before
        $htmlContent = $this->generateInvoiceHtml($shoppingCartItems, $orderID);
        
        // Include the mPDF library
        require_once __DIR__ . '/../vendor/autoload.php';
        
        // Create an instance of mPDF
        $mpdf = new \mPDF\Mpdf([
            'tempDir' => __DIR__ . '/../tmp', // Specify a temporary directory if needed
            'mode' => 'utf-8', 
            'format' => 'A4', 
            'orientation' => 'P'
        ]);
        
        // Write the HTML content to the PDF
        $mpdf->WriteHTML($htmlContent);
        
        // Define the PDF file path
        $pdfFilePath = __DIR__ . '/invoices/invoice_' . $orderID . '.pdf';
        
        // Save the PDF to a file
        $mpdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);
        
        // Return the path to the generated PDF for attaching to email
        return $pdfFilePath;
    }


}
