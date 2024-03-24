<?php
include_once '../config/dbconnect.php';

			
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['institution_name']) && isset($_POST['country_code']))
	{
		$institution_name = $_POST['institution_name'];
		$institution_type = $_POST['institution_type'];
		$country_code = $_POST['country_code'];
		$country_name = $_POST['country_name'];
		$approved = $_POST['approved'];
		
		if($stmt = $conn->prepare('INSERT INTO institutions (institution_type, institution_name, country_code, country_name, approved) VALUES (?, ?, ?, ?, ?)')){
			$stmt->bind_param('ssssi', $institution_type, $institution_name, $country_code, $country_name, $approved);
			$stmt->execute();
			$c_id = $stmt->insert_id;
			if ($c_id != 0) {
				http_response_code(200);
				echo json_encode(array("message" => "Institution inserted"));
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
		echo json_encode(array("message" => "Invalid institution data"));
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