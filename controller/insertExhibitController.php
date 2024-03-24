<?php
include_once '../config/dbconnect.php';

			
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['exhibit_name']) && isset($_POST['exhibition_id']))
	{

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
		
		if($stmt = $conn->prepare('INSERT INTO exhibits (exhibit_name, exhibit_description, exhibition_id, exhibit_location_x, exhibit_location_y, exhibit_location_z, exhibit_heading_x, exhibit_heading_y, exhibit_heading_z, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')){
			$stmt->bind_param('ssissssssi', $exhibit_name, $exhibit_description, $exhibition_id, $exhibit_location_x, $exhibit_location_y, $exhibit_location_z, $exhibit_heading_x, $exhibit_heading_y, $exhibit_heading_z, $active);
			$stmt->execute();
			$c_id = $stmt->insert_id;
			if ($c_id != 0) {
				http_response_code(200);
				echo json_encode(array("message" => "Exhibit inserted"));
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
		echo json_encode(array("message" => "Invalid exhibit data"));
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