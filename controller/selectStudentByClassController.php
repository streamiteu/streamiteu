<?php
include_once '../config/dbconnect.php';

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['class_id']))
	{
	
		$class_id = $_POST['class_id'];
		//find eventual info if the user is registered as student before
		if($stmt = $conn->prepare('SELECT users.user_id, users.first_name, users.last_name FROM users, students WHERE users.user_id=students.user_id AND students.class_id =?')){
			$stmt->bind_param('i', $class_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($user_id, $user_firstname, $user_lastname);
			$studentsArray = array();
			while ($stmt->fetch()) {
				$singleStudent = array('user_id'=>$user_id, 'name'=>$user_firstname.' '. $user_lastname);
				array_push($studentsArray, $singleStudent);
			}
			$stmt->close();
			http_response_code(200);
			echo json_encode(array("message" => json_encode($studentsArray)));
			die();
		}
	}
}

?>