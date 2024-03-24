<?php
include_once '../config/dbconnect.php';

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['exhibit_id']) && isset($_POST['exhibit_name']))
	{
		$exhibit_id = $_POST['exhibit_id'];
		$exhibit_name = $_POST['exhibit_name'];
		$exhibit_description = $_POST['exhibit_description'];
		$exhibition_id = $_POST['exhibition_id'];
		$exhibit_location_x = $_POST['exhibit_location_x'];
		$exhibit_location_y = $_POST['exhibit_location_y'];
		$exhibit_location_z = $_POST['exhibit_location_z'];
		$exhibit_heading_x = $_POST['exhibit_heading_x'];
		$exhibit_heading_y = $_POST['exhibit_heading_y'];
		$exhibit_heading_z = $_POST['exhibit_heading_z'];
		$active = $_POST['active'];
		
		if($stmt = $conn->prepare('UPDATE exhibits SET exhibit_name=?, exhibit_description=?, exhibition_id=?, exhibit_location_x=?, exhibit_location_y=?, exhibit_location_z=?, exhibit_heading_x=?, exhibit_heading_y=?, exhibit_heading_z=?, active=? WHERE exhibit_id=?')){
			$stmt->bind_param('ssissssssii', $exhibit_name, $exhibit_description, $exhibition_id, $exhibit_location_x, $exhibit_location_y, $exhibit_location_z, $exhibit_heading_x, $exhibit_heading_y, $exhibit_heading_z, $active, $exhibit_id);
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
	}else{
		//echo $_POST['id'];
		http_response_code(402);
		// return a JSON object with a message property
		echo json_encode(array("message" => "Exhibit not found!"));
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