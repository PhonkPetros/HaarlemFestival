<?php

namespace controllers;

use services\ticketservice;

require_once __DIR__ . '/../services/ticketservice.php';

class EmployeeController
{
    private $ticketService;

    public function __construct()
    {
        $this->ticketService = new ticketservice();
    }

    public function showScanner()
    {
        if ($_SESSION['role'] != 'employee') {
            header('Location: /');
            exit();
        }
        require_once __DIR__ . '/../views/employee/employee-view.php';
    }

    public function scanTicket()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $content = file_get_contents("php://input");
            
            $decodedData = json_decode($content, true);
            if (isset($decodedData['qrCodeText'])) {
                $qrCodeText = $decodedData['qrCodeText'];
                
                $qrProcessingResult = $this->ticketService->checkTicket($qrCodeText);
                
                if ($qrProcessingResult['status'] === 'success'){
                    echo json_encode([
                        "success" => true,
                        "message" => "QR Code processed successfully.",
                        "qrCodeText" => $qrCodeText
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "QR Code processing failed.",
                    ]);
                }
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "QR code text missing in the request."
                ]);
            }
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Invalid request method. Only POST requests are allowed."
            ]);
        }
    }
}
