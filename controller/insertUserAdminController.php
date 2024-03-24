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
	
	if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']))
	{
	
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);;
		$user_type= $_POST['user_type'];
		$institution_admin= $_POST['institution_admin'];
		$class_admin= $_POST['class_admin'];
		$approved= $_POST['approved'];
		
		$existing_user_id = '';
		
		//find eventual info if the user is registered as student before
		if($stmt = $conn->prepare('SELECT user_id FROM users WHERE email=?')){
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($existing_user_id);
			$stmt->fetch();
		}
		
		if($existing_user_id != ''){
			//echo $_POST['id'];
			http_response_code(404);

			// return a JSON object with a message property
			echo json_encode(array("message" => "User with the given email address already exists. Please select another one!"));
			die();
			exit();
		}
		
		// Generate Random Password
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
		$password = substr( str_shuffle( $chars ), 0, 10 );	
		$e_password= password_hash($password, PASSWORD_DEFAULT);
		
		if($stmt = $conn->prepare('INSERT INTO users (first_name, last_name, email, user_password, user_type_id, approved) VALUES (?, ?, ?, ?, ?, ?)')){
			$stmt->bind_param('ssssii', $firstname, $lastname, $email, $e_password, $user_type, $approved);
			$stmt->execute();
			$u_id = $stmt->insert_id;
			if ($u_id != 0) {
				if($stmt = $conn->prepare('INSERT INTO userinstitution (user_id, institution_id) VALUES (?, ?)')){
						$stmt->bind_param('ii', $u_id, $institution_admin);
						$stmt->execute();
					}
				if($user_type==6){
					if($stmt = $conn->prepare('INSERT INTO students (user_id, class_id) VALUES (?, ?)')){
						$stmt->bind_param('ii', $u_id, $class_admin);
						$stmt->execute();
						//TODO:
						//here code for sending activation email for each of the inserted users.
						
						
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
						$mail->Subject = 'Your user account is created on StreamIT system';
						$activate_link = $site_url . '/signin.php';
						$message = '<p>Your user account is created on StreamIT system. Using the Robot StreamIT system you can gain an incredible user experience and activelly learn new things. You can login using the following password '. $password . ' on the <a href="' . $activate_link . '">following link</a></p><p>You are kindly advised to change your initial password through your control panel after first login</p>';
						$mail->msgHTML($message);
						$mail->send();
						
						http_response_code(200);
						echo json_encode(array("message" => "New student added"));
						die();
						
					}else{
						//echo $_POST['id'];
						http_response_code(404);
						// return a JSON object with a message property
						echo json_encode(array("message" => "Creating student profile error"));
						die();
					}
					$stmt->close();
				}else{
					//TODO:
					//here code for sending activation email for each of the inserted users.
					
					
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
						$mail->Subject = 'Your user account is created on StreamIT system';
						$activate_link = $site_url . '/signin.php';
						$message = '<p>Your user account is created on StreamIT system. Using the Robot StreamIT system you can gain an incredible user experience and activelly learn new things. You can login using the following password '. $password . ' on the <a href="' . $activate_link . '">following link</a></p><p>You are kindly advised to change your initial password through your control panel after first login</p>';
						$mail->msgHTML($message);
						$mail->send();
						
					http_response_code(200);
					echo json_encode(array("message" => "New user inserted"));
					die();
				}
				
				
				
				
			}
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