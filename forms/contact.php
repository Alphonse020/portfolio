<?php

// Your receiving email
$receiving_email_address = 'alphoneskiprotich03@gmail.com';

// Path to the PHP Email Form library
$php_email_form = '../assets/vendor/php-email-form/php-email-form.php';

if (file_exists($php_email_form)) {
  include($php_email_form);
} else {
  die('Error: Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = $_POST['name'] ?? '';
$contact->from_email = $_POST['email'] ?? '';
$contact->subject = $_POST['subject'] ?? 'Website Contact Form';

 // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  
  $contact->smtp = array(
    'host' => 'smtp.gmail.com',
    'username' => 'alphoneskiprotich03@gmail.com',
    'password' => 'ztxl geek gvjy fstt',
    'port' => '587'
  );
  

$contact->add_message($_POST['name'], 'From');
$contact->add_message($_POST['email'], 'Email');
$contact->add_message($_POST['message'], 'Message', 10);

echo $contact->send();
?>
