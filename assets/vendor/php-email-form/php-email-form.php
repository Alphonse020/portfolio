<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

class PHP_Email_Form {
  public $to = '';
  public $from_name = '';
  public $from_email = '';
  public $subject = '';
  public $ajax = false;
  public $smtp = false;
  private $messages = [];

  public function add_message($content, $label = '', $length = 0) {
    $this->messages[] = "$label: " . trim($content);
  }

  public function send() {
    $message = implode("\n", $this->messages);

    if ($this->smtp) {
      // Send using SMTP
      $mail = new PHPMailer(true);
      try {
        $mail->isSMTP();
        $mail->Host       = $this->smtp['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $this->smtp['username'];
        $mail->Password   = $this->smtp['password'];
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $this->smtp['port'];

        $mail->setFrom($this->from_email, $this->from_name);
        $mail->addAddress($this->to);
        $mail->Subject = $this->subject;
        $mail->Body    = $message;

        $mail->send();
        return 'OK';
      } catch (Exception $e) {
        return 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
      }
    } else {
      // Fallback to basic mail() — will fail in localhost without SMTP
      $headers = "From: {$this->from_name} <{$this->from_email}>\r\n";
      $headers .= "Reply-To: {$this->from_email}\r\n";
      $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

      if (mail($this->to, $this->subject, $message, $headers)) {
        return 'OK';
      } else {
        return 'Message could not be sent.';
      }
    }
  }
}
