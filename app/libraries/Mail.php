<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    protected $mail;

    public function __construct()
    {
        // Load Composer's autoloader
        require_once '../vendor/autoload.php';

        $this->mail = new PHPMailer(true);

        // Server settings
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER; // Set to false in production
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'winmyatphyo5@gmail.com'; // Your Gmail address
        $this->mail->Password   = 'qwizkdexrwkpaopx'; // Your App Password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;
    }

    public function verifyMail($recipient_mail, $recipient_name, $token)
    {
        try {
            // Recipients
            $this->mail->setFrom('winmyatphyo5@gmail.com', 'restaurant_invoice');
            $this->mail->addAddress($recipient_mail, $recipient_name);

            // Content
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Verify Mail';
            $this->mail->Body    = "<b> Dear customer,\n\nThank you for registering with us.<a href='$token' target='_blank'> Please click on the link below to verify your registration </a>If you have any questions, feel free to contact us.\n\nBest regards,\nITVisionHub</b>.";
            $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }

    public function resetPasswordMail($recipient_mail, $recipient_name, $resetLink)
    {
        // Clear all previous addresses and attachments
        $this->mail->clearAllRecipients();
        $this->mail->clearAttachments();

        try {
            // Recipients
            $this->mail->setFrom('winmyatphyo5@gmail.com', 'restaurant_invoice');
            $this->mail->addAddress($recipient_mail, $recipient_name);

            // Content
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Password Reset Request';
            $this->mail->Body    = "
                <html>
                <body>
                <h1>Hello, {$recipient_name}</h1>
                <p>We received a request to reset your password. Click the link below to set a new one:</p>
                <p><a href='{$resetLink}'>Reset Password</a></p>
                <p>This link will expire in one hour. If you did not request a password reset, please ignore this email.</p>
                </body>
                </html>
            ";
            $this->mail->AltBody = 'To reset your password, copy and paste this link into your browser: ' . $resetLink;

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Password reset email could not be sent. Mailer Error: {$this->mail->ErrorInfo}");
            return false;
        }
    }
}