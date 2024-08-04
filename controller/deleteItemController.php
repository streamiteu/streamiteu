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
	
	if(isset($_POST['item_id']) && isset($_POST['delete_entity']))
	{
		$item_id = $_POST['item_id'];
		$delete_entity = $_POST['delete_entity'];
		$delete_key = $_POST['delete_key'];
		
		
		if($delete_entity == 'lectures'){
			if($stmt = $conn->prepare("SELECT lecture_file_path FROM lectures WHERE lecture_id=?")){
				$stmt->bind_param('i', $item_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($path);
				$stmt->fetch();
				if (is_file(dirname(__DIR__).'/'.$path)) {
					if (!unlink(dirname(__DIR__).'/'.$path)) {
						//echo $_POST['id'];
						http_response_code(405);
						// return a JSON object with a message property
						echo json_encode(array("message" => "File delete error"));
						die();
					}
				}else{
					//echo $_POST['id'];
					http_response_code(404);
					// return a JSON object with a message property
					echo json_encode(array("message" => "File not found"));
					die();
				}
			}else{
				//echo $_POST['id'];
				http_response_code(404);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Database connection error"));
				die();
			}
		}
		
		if($delete_entity == 'multimedia'){
			if($stmt = $conn->prepare("SELECT multimedia_id, exhibit_id, description, content_type, path, active FROM multimedia WHERE multimedia_id=?")){
				$stmt->bind_param('i', $item_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($multimedia_id, $exhibit_id, $description, $content_type, $path, $active);
				$stmt->fetch();
				if($content_type == 1){
					if (is_file(dirname(__DIR__).'/'.$path)) {
						if (!unlink(dirname(__DIR__).'/'.$path)) {
							//echo $_POST['id'];
							http_response_code(405);
							// return a JSON object with a message property
							echo json_encode(array("message" => "File delete error"));
							die();
						}
					}else{
						//echo $_POST['id'];
						http_response_code(404);
						// return a JSON object with a message property
						echo json_encode(array("message" => "File not found"));
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
		}
		
		if($delete_entity == 'tours'){
			if($stmt = $conn->prepare("SELECT tours.tour_id, tours.tour_attendees, tours.tour_guide_id, tours.tour_teacher_id, schedule.schedule_start, schedule.schedule_end, schedule.schedule_type, exhibitions.exhibition_title, institutions.institution_name, institutions.institution_id FROM tours, schedule, institutions, exhibitions WHERE schedule.schedule_id = tours.schedule_id AND schedule.exhibition_id = exhibitions.exhibition_id AND exhibitions.institution_id  = institutions.institution_id AND tours.tour_id=?")){
				$stmt->bind_param('i', $item_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($tour_id, $tour_attendees, $tour_guide_id, $tour_teacher_id, $schedule_start, $schedule_end, $schedule_type, $exhibition_title, $institution_name, $institution_id);
				$stmt->fetch();
				
				//Uncomment this to send emails
				/*
				if($tour_guide_id != 0){
					$tour_attendees = $tour_attendees . ', '. $tour_guide_id;
				}
				if($tour_teacher_id != 0){
					$tour_attendees = $tour_attendees . ', '. $tour_teacher_id;
				}
				
				if($stmt1 = $conn->prepare("SELECT user_id, email FROM users WHERE user_id IN (" . $tour_attendees . ")")){
					$stmt1->execute();
					$stmt1->store_result();
					$stmt1->bind_result($info_user_id, $info_email);
					$stmt1->fetch();
					
					while ($stmt1->fetch()) {
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
						$mail->addAddress($info_email, 'send_to_Name');
						$mail->Subject = 'Tour canceled';
						$message = '<p>The educational museum tour related to the exhibition entitled: ' . $exhibition_title . ', set up at the museum: ' . $institution_name . ' that was scheduled for '. $schedule_start .'  <b>HAS BEEN CANCELED </b>.<br/><br/>You will be informed for further details by the responsible person at your institution.<br/><br/>This is automatic message from the StreamIT system. Please do not respond to it.</p>';
						$mail->msgHTML($message);
						$mail->send();
					}
				}
				*/
				//Uncomment till here to send emails
			}else{
				//echo $_POST['id'];
				http_response_code(404);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Database connection error"));
				die();
			}
		}
				
		if($stmt = $conn->prepare('DELETE FROM '. $delete_entity .' WHERE ' . $delete_key . ' = ?')){
			$stmt->bind_param('i', $item_id);
			$stmt->execute();
			if ($stmt->affected_rows > 0) {
				if($delete_entity == 'users' || $delete_entity == 'classes'){
					if($stmt = $conn->prepare('DELETE FROM userinstitution WHERE ' . $delete_key . ' = ?')){
						$stmt->bind_param('i', $item_id);
						$stmt->execute();
					}
					if($stmt = $conn->prepare('DELETE FROM students WHERE ' . $delete_key . ' = ?')){
						$stmt->bind_param('i', $item_id);
						$stmt->execute();
						http_response_code(200);
						echo json_encode(array("message" => "Item deleted"));
						die();
					}
					else{
						//echo $_POST['id'];
						http_response_code(403);
						// return a JSON object with a message property
						echo json_encode(array("message" => "Delete error"));
						die();
					}
					$stmt->close();
				}else{
					http_response_code(200);
					echo json_encode(array("message" => "Item deleted"));
					die();
				}
				
				
			}
			else{
				//echo $_POST['id'];
				http_response_code(403);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Delete error"));
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
	}else{
		//echo $_POST['id'];
		http_response_code(402);
		// return a JSON object with a message property
		echo json_encode(array("message" => "Invalid item data"));
		die();
	}
}else{
	//echo $_POST['id'];
	http_response_code(401);

	// return a JSON object with a message property
	echo json_encode(array("message" => "Session expiered"));
	die();
}

?>