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
	
	if(isset($_POST['institution_id']) && isset($_POST['class_id']))
	{
	
		$institution_id = $_POST['institution_id'];
		$class_id = $_POST['class_id'];
		$user_type_id = 6;
		$approved = 1;
		//$file= $_POST['file'];
		//echo $class_id;
		$existing_students = array();
		if($stmt = $conn->prepare('SELECT first_name, last_name, email FROM users WHERE user_type_id=6')){
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($first_name, $last_name, $email);
			while ($stmt->fetch()) {
				
				array_push($existing_students, $email);
			}
		}
		
		$duplicate_students='Students with the following emails already exit in the system and will not be inserted: <br/>';
		$handle = fopen($_FILES['file']['tmp_name'], "r");
		$count_duplicate_students = 0;
		$count_inserted_students = 0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
		{
			
			if(in_array($data[2], $existing_students)){
				$duplicate_students .= $data[2] . '<br/>';
				$count_duplicate_students++;
			}else{
				// Generate Random Password
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
				$password = substr( str_shuffle( $chars ), 0, 10 );	
				$e_password= password_hash($password, PASSWORD_DEFAULT);

				if($stmt = $conn->prepare('INSERT INTO users (first_name, last_name, email, user_password, user_type_id, approved) VALUES (?, ?, ?, ?, ?, ?)')){
					$stmt->bind_param('ssssii', $data[0], $data[1], $data[2], $e_password, $user_type_id, $approved);
					$stmt->execute();
					$u_id = $stmt->insert_id;
					if ($u_id != 0) {
						if($stmt = $conn->prepare('INSERT INTO userinstitution (user_id, institution_id) VALUES (?, ?)')){
							$stmt->bind_param('ii', $u_id, $institution_id);
							$stmt->execute();
						}
						
						if($stmt = $conn->prepare('INSERT INTO students (user_id, class_id) VALUES (?, ?)')){
							$stmt->bind_param('ii', $u_id, $class_id);
							$stmt->execute();
							$count_inserted_students++;
							
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
							$mail->addAddress($data[2], 'send_to_Name');
							$mail->Subject = 'Your user account is created on StreamIT system';
							$activate_link = $site_url . '/signin.php';
							$message = '<p>Your user account is created on StreamIT system. Using the Robot StreamIT system you can gain an incredible user experience and activelly learn new things. You can login using the following password '. $password . ' on the <a href="' . $activate_link . '">following link</a></p><p>You are kindly advised to change your initial password through your control panel after first login</p>';
							$mail->msgHTML($message);
							$mail->send();
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
			
		}
		fclose($handle);

		if($count_duplicate_students == 0){
			$duplicate_students = 'All the ' . $count_inserted_students . ' students were successfully inserted';
			http_response_code(202);
			echo json_encode(array("message" => $duplicate_students));
			die();
		}
		if($count_duplicate_students > 0){
			$duplicate_students = 'The number of successfully inserted students is: ' . $count_inserted_students . '<br/>' . $duplicate_students;
			http_response_code(203);
			echo json_encode(array("message" => $duplicate_students));
			die();
		}

		/*
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
		}
		
		if($stmt = $conn->prepare('INSERT INTO users (first_name, last_name, email, user_type_id, institution_id, approved) VALUES (?, ?, ?, ?, ?, ?)')){
			$stmt->bind_param('ssssii', $firstname, $lastname, $email, $user_type, $institution_admin, $approved);
			$stmt->execute();
			$u_id = $stmt->insert_id;
			if ($u_id != 0) {
				
				if($user_type==6){
					if($stmt = $conn->prepare('INSERT INTO students (user_id, class_id) VALUES (?, ?)')){
						$stmt->bind_param('ii', $u_id, $class_admin);
						$stmt->execute();
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
		
		*/
		
	}
}else{
	//echo $_POST['id'];
	http_response_code(401);

	// return a JSON object with a message property
	echo json_encode(array("message" => "Session expiered"));
	die();
}

?>