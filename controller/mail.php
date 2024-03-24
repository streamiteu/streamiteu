<?php
/*
$email = 'koceski@gmail.com';
								$from    = 'contact@innovix.mk';
								$subject = 'Account Activation Required';
								$headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
								// Update the activation variable below
								$activate_link = 'http://yourdomain.com/phplogin/activate.php?email=' . $email;
								$message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
								mail($email , $subject, $message, $headers);

*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/Exception.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'kubrat.ns1.bg';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->Username = 'contact@innovix.mk';
$mail->Password = 'Saso2805!';
$mail->setFrom('contact@innovix.mk', 'StreamIT');
$mail->addAddress('koceski@gmail.com', 'send_to_Name');
$mail->Subject = 'Any_subject_of_your_choice';
$mail->msgHTML('test body'); // remove if you do not want to send HTML email
//$mail->AltBody = 'HTML not supported';
//$mail->addAttachment('docs/brochure.pdf'); //Attachment, can be skipped

$mail->send();
    
echo 'ggg';	
?>