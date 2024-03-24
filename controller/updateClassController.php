<?php
include_once '../config/dbconnect.php';

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['classname']) && isset($_POST['school_id']) && isset($_POST['class_id']))
	{
		$class_id=$_POST['class_id'];
		$classname = $_POST['classname'];
		$school_id = $_POST['school_id'];
		
		if($stmt = $conn->prepare('UPDATE classes SET class_name=?, institution_id=? WHERE class_id=' . $class_id)){
			$stmt->bind_param('si', $classname, $school_id);
			$stmt->execute();
			if ($stmt->affected_rows > 0) {
				http_response_code(200);
				echo json_encode(array("message" => "Update succesful"));
				die();
			}
			else{
				//echo $_POST['id'];
				http_response_code(403);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Update error"));
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
		echo json_encode(array("message" => "Class not found!"));
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