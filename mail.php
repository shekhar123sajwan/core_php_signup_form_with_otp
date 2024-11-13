<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'PHPMAILER-master/src/Exception.php';
require 'PHPMAILER-master/src/PHPMailer.php';
require 'PHPMAILER-master/src/SMTP.php';

class Mail {
    static function sendMail($to, $toName,  $subject, $from, $fromName, $body) {
        try {
            $mail = new PHPMailer(true); 
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'shekharsajwan97@gmail.com';                     //SMTP username
            $mail->Password   = 'ayow kkws nshk oije';                               //SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($from, $fromName);
            $mail->addAddress($to, $toName);     //Add a recipient 
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body; 

            $mail->send();
           
        } catch (Exception $e) {
             
        }

    }

}


