<?php
include_once '../config/dbconnect.php';

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['tour_id']))
	{
		$exhibit_id = "";
	
		$tour_id = $_POST['tour_id'];
		
		//find eventual info if the user is registered as student before
		if($stmt = $conn->prepare('SELECT current_exhibit_id FROM tours WHERE tour_id=?')){
			$stmt->bind_param('i', $tour_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($exhibit_id);
			$stmt->fetch();
			/*
			$studentsArray = array();
			while ($stmt->fetch()) {
				$singleStudent = array('user_id'=>$user_id, 'name'=>$user_firstname.' '. $user_lastname);
				array_push($studentsArray, $singleStudent);
			}
			$stmt->close();
			*/
			http_response_code(200);
			echo json_encode(array("message" => $exhibit_id));
			die();
		}
	}
}

?>