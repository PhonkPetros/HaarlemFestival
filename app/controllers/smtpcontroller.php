<?php

namespace controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../PHPMailer-master/src/SMTP.php';

class SMTPController
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
    }

    public function sendEmail($toEmail, $toName, $subject, $message)
    {
        try {
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'protata93@gmail.com';
            $this->mailer->Password = 'xhno spiv iump ltna';
            $this->mailer->SMTPSecure = 'ssl';
            $this->mailer->Port = 465;

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
}
