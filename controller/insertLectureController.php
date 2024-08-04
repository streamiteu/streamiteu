<?php
include_once '../config/dbconnect.php';

			
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['lecture_title']) && isset($_POST['tour_id']))
	{

		$tour_id = $_POST['tour_id'];
		$lecture_title = $_POST['lecture_title'];

		$path = '';
		if (!is_dir(dirname(__DIR__).'/uploads/lectures/'.$tour_id)){
			mkdir(dirname(__DIR__).'/uploads/lectures/'.$tour_id);
		}
		$tmp_name = $_FILES['file_multimedia']['tmp_name'];
		// basename() may prevent filesystem traversal attacks;
		// further validation/sanitation of the filename may be appropriate
		$name = basename($_FILES['file_multimedia']['name']);
		move_uploaded_file($tmp_name, dirname(__DIR__).'/uploads/lectures/'.$tour_id.'/'.$name);
		$path = 'uploads/lectures/'.$tour_id.'/'.$name;
		
		if($stmt = $conn->prepare('INSERT INTO lectures (lecture_title, tour_id, lecture_file_path) VALUES (?, ?, ?)')){
			$stmt->bind_param('sis', $lecture_title, $tour_id, $path);
			$stmt->execute();
			$c_id = $stmt->insert_id;
			if ($c_id != 0) {
				http_response_code(200);
				echo json_encode(array("message" => "Lecture inserted"));
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