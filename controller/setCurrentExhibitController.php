<?php
include_once '../config/dbconnect.php';

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['tour_id']))
	{
	
		$tour_id = $_POST['tour_id'];
		$current_exhibit_id = $_POST['current_exhibit_id'];

		if($stmt = $conn->prepare('UPDATE tours SET current_exhibit_id=? WHERE tour_id=?')){
			$stmt->bind_param('ii', $current_exhibit_id, $tour_id);
			$stmt->execute();
			http_response_code(200);
			echo json_encode(array("message" => "Update succesful"));
			die();

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

?>