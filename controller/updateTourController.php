<?php
include_once '../config/dbconnect.php';

			
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['schedule_id']))
	{
		$tour_id = $_POST['tour_id'];
		$schedule_id = $_POST['schedule_id'];
		$tour_attendees = $_POST['tour_attendees'];
		$tour_exhibits = $_POST['tour_exhibits'];
		$active = 0;
		
		if($stmt = $conn->prepare('UPDATE tours SET schedule_id = ?, tour_attendees = ?, tour_exhibits = ?, active = ? WHERE tour_id=?')){
			$stmt->bind_param('issii', $schedule_id, $tour_attendees, $tour_exhibits, $active, $tour_id);
			$stmt->execute();
			
			
			http_response_code(200);
			echo json_encode(array("message" => "Tour updated"));
			die();
			
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
		echo json_encode(array("message" => "Invalid tour data"));
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