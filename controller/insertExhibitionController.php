<?php
include_once '../config/dbconnect.php';

			
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['exhibition_title']))
	{

		$exhibition_title = $_POST['exhibition_title'];
		$exhibition_description = $_POST['exhibition_description'];
		$institution_id = $_POST['institution_id'];
		$exhibition_map = $_POST['exhibition_map'];
		$exhibition_ip = $_POST['exhibition_ip'];
		$exhibition_port = $_POST['exhibition_port'];
		$server_name = $_POST['server_name'];
		$active = $_POST['active'];
		
		if($stmt = $conn->prepare('INSERT INTO exhibitions (exhibition_title, exhibition_description, institution_id, exhibition_map, exhibition_ip, exhibition_port, server_name, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')){
			$stmt->bind_param('ssissssi', $exhibition_title, $exhibition_description, $institution_id, $exhibition_map, $exhibition_ip, $exhibition_port, $server_name, $active);
			$stmt->execute();
			$c_id = $stmt->insert_id;
			if ($c_id != 0) {
				http_response_code(200);
				echo json_encode(array("message" => "Exhibition inserted"));
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
		echo json_encode(array("message" => "Invalid exhibition data"));
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