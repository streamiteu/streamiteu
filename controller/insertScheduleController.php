<?php
include_once '../config/dbconnect.php';

			
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	if(isset($_POST['exhibition_id']))
	{
		$exhibition_id = $_POST['exhibition_id'];
		$schedule_start = $_POST['schedule_start'];
		$schedule_end = $_POST['schedule_end'];
		$schedule_type = $_POST['schedule_type'];
		if($stmt = $conn->prepare('INSERT INTO schedule (schedule_type, exhibition_id, schedule_start, schedule_end) VALUES (?, ?, ? , ?)')){
			$stmt->bind_param('iiss', $schedule_type, $exhibition_id, $schedule_start, $schedule_end);
			$stmt->execute();
			$c_id = $stmt->insert_id;
			if ($c_id != 0) {
				http_response_code(200);
				echo json_encode(array("message" => "Schedule inserted"));
				die();
			}
			else{
				//echo $_POST['id'];
				http_response_code(403);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Insert error"));
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
		echo json_encode(array("message" => "Invalid schedule data"));
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