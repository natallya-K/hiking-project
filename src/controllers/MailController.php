<?php
declare(strict_types=1);

namespace Controllers;

// Not sure if needed
//require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/mail.config.php';

class MailController
{
    private $mail; // Declare the PHPMailer object as a property

    public function __construct()
    {
        $this->mail = new PHPMailer(true); // Initialize PHPMailer in constructor
    }

    private function configurePhpMailer()
    {
        // Server settings
//        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                  // Enable verbose debug output (optional)
        $this->mail->isSMTP();                                          // Send using SMTP
        $this->mail->Host = 'smtp.mailgun.org';                         // Set the SMTP server to send through
        $this->mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $this->mail->Username = SMTPUSER;                               // SMTP username
        $this->mail->Password = SMTPPASSWORD;
        $this->mail->SMTPSecure = 'tsl';                                // Enable TLS encryption
        $this->mail->Port = 587;                                        // TCP port to connect to; use 587 for STARTTLS
        $this->mail->CharSet = 'UTF-8';                                 // Set the character set to UTF-8

        // Consider moving these to a separate function for setting recipients
        // $this->mail->setFrom('postmaster@sandbox8d03d7f741404fc0bf59038bd3233638.mailgun.org', 'Wanderlust');
    }


    // Consider making several templates
    public static function register($email, $username)
    {
        $mailController = new MailController(); // Create an instance of MailController
        $mailController->configurePhpMailer();   // Configure PHPMailer settings

        $mailController->mail->addAddress($email, $username); // Add a recipient

        // Content
        $mailController->mail->isHTML(true);                                        // Set email format to HTML
        $mailController->mail->Subject = 'Welcome ' . $username;
        $mailController->mail->Body = 'Welcome ' . $username . ' at Wonderlust you had successfully registered';
        $mailController->mail->AltBody = 'Welcome ' . $username . ' at Wonderlust you had successfully registered';

        try {
            if ($mailController->mail->send()) {
                echo 'Message has been sent';
            } else {
                echo 'Error sending message: ' . $mailController->mail->ErrorInfo;
            }
        } catch (Exception $e) {
        }
    }

    public static function forgotPassword($email, $username)
    {
        $mailController = new MailController(); // Create an instance of MailController
        $mailController->configurePhpMailer();   // Configure PHPMailer settings

        $mailController->mail->addAddress($email, $username); // Add a recipient

        // Content
        $mailController->mail->isHTML(true);                                        // Set email format to HTML
        $mailController->mail->Subject = 'Reset your password ' . $username;
        $mailController->mail->Body = 'Click on the link to reset your password';
        $mailController->mail->AltBody = 'Click on the link to reset your password';

        try {
            if ($mailController->mail->send()) {
                echo 'Message has been sent';
            } else {
                echo 'Error sending message: ' . $mailController->mail->ErrorInfo;
            }
        } catch (Exception $e) {
        }
    }
}
