<?php
include_once '../config/dbconnect.php';

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['exhibition_id']) && isset($_POST['active']))
	{
		$exhibition_id=$_POST['exhibition_id'];
		$active = $_POST['active'];
		
		if($stmt = $conn->prepare('UPDATE exhibitions SET active=? WHERE exhibition_id=?')){
			$stmt->bind_param('ii', $active, $exhibition_id);
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
}else{
	//echo $_POST['id'];
	http_response_code(401);

	// return a JSON object with a message property
	echo json_encode(array("message" => "Session expiered"));
	die();
}

?>