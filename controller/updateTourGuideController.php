<?php
include_once '../config/dbconnect.php';

			
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['tour_id']))
	{
		$tour_id = $_POST['tour_id'];
		$tour_guide_id = $_POST['tour_guide_id'];
		$return_route = $_POST['return_route'];
		
		if($stmt = $conn->prepare('UPDATE tours SET tour_guide_id = ? WHERE tour_id=?')){
			$stmt->bind_param('ii', $tour_guide_id, $tour_id);
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