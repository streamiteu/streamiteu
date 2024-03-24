<?php
include_once '../config/dbconnect.php';
include_once '../config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/Exception.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';

			$return_message="";
			$return_code=200;
			if(isset($_POST['do_resetpwd'])){
				$email=$_POST['email'];
				
				if($stmt = $conn->prepare('SELECT user_id FROM users WHERE approved=1 AND email=?')){
					$stmt->bind_param('s', $email);
					$stmt->execute();
					$stmt->store_result();
					
					if ($stmt->num_rows > 0) {
						$stmt->bind_result($id);
						$stmt->fetch();
						$token = md5($email).rand(10,9999);
						$expFormat = mktime(date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y"));
						$expDate = date("Y-m-d H:i:s",$expFormat);
						if ($stmt = $conn->prepare('INSERT INTO reset_password_tokens (user_id, email, token, exp_date) VALUES (?, ?, ?, ?)')) {
							$stmt->bind_param('isss', $id, $email, $token, $expDate);
							$stmt->execute();
							
							$mail = new PHPMailer;
							$mail->isSMTP();
							//$mail->SMTPDebug = 2;
							$mail->Host = $smtp_host;
							$mail->Port = $smtp_port;
							$mail->SMTPSecure = 'ssl';
							$mail->SMTPAuth = true;
							$mail->Username = $smtp_username;
							$mail->Password = $smtp_password;
							$mail->setFrom($from_email, 'StreamIT');
							$mail->addAddress($email, 'send_to_Name');
							$mail->Subject = 'Reset your password on StreamIT system';
							$activate_link = $site_url . '/reset_password.php?email=' . $email . '&token=' . $token;
							$message = '<p>Please click the following link to reset your password. <a href="' . $activate_link . '">Click To Reset password</a></p>';
							$mail->msgHTML($message);
							$mail->send();

							
							$return_code = 200; 
							$return_message = 'An email with instructions how to reset your password has been sent to your email address.';
						} else {
							// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
							$return_code = 400;
							$return_message = 'Database error occured';
						}
						
					}
					else{
						
						$return_code=400;
						$return_message='Invalid or not approved email. Please verify it and try again!';
					}
					$stmt->close();
				}else{
					$return_code=400;
					$return_message='Database connection error!';
				}
			}
		$conn->close();
		http_response_code(200);
		echo json_encode(array("response_code" => $return_code, "message" => $return_message));

        
?>