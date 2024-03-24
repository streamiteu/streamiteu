<?php
include_once '../config/dbconnect.php';
include_once '../config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/Exception.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['user_id']) && isset($_POST['approved']))
	{
		$user_id=$_POST['user_id'];
		$approved = $_POST['approved'];
		$email= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		
		if($stmt = $conn->prepare('UPDATE users SET approved=? WHERE user_id=?')){
			$stmt->bind_param('ii', $approved, $user_id);
			$stmt->execute();
			if ($stmt->affected_rows > 0) {
				
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
				$mail->Subject = 'Your user account on StreamIT system is updated';
				$activate_link = $site_url . '/signin.php';
				$activation_status = 'deactivated';
				$message = '<p>Your user account on StreamIT system is ' . $activation_status . '.</p>';
				if($approved == 1) {
					$activation_status = 'activated';
					$message = '<p>Your user account on StreamIT system is ' . $activation_status . '.</p><p>Using the Robot StreamIT system you can gain an incredible user experience and activelly learn new things. You can login on the <a href="' . $activate_link . '">following link</a></p>';
				}
					
				 
				$mail->msgHTML($message);
				$mail->send();
				
				http_response_code(200);
				echo json_encode(array("message" => "Update succesful"));
				die();
			}
			else{
				//echo $_POST['id'];
				http_response_code(403);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Update error"));
				die();
			}
			$stmt->close();
		}else{
			//echo $_POST['id'];
			http_response_code(404);
			// return a JSON object with a message property
			echo json_encode(array("message" => "Database connection error"));
			die();
		}
		$stmt->close();
				
		
	}
}else{
	//echo $_POST['id'];
	http_response_code(401);

	// return a JSON object with a message property
	echo json_encode(array("message" => "Session expiered"));
	die();
}

?>