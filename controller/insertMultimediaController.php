<?php
include_once '../config/dbconnect.php';

			
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['multimedia_description']) && isset($_POST['exhibit_id']))
	{

		$exhibit_id = $_POST['exhibit_id'];
		$multimedia_description = $_POST['multimedia_description'];
		$content_type = $_POST['content_type'];
		$multimedia_link = $_POST['multimedia_link'];
		//$file_multimedia = $_POST['file_multimedia'];
		$path = '';
		$active = 1;
		
		if($content_type==0){
			$path = $multimedia_link;
		}else{
			if (!is_dir(dirname(__DIR__).'/uploads/'.$exhibit_id)){
				mkdir(dirname(__DIR__).'/uploads/'.$exhibit_id);
			}
			$tmp_name = $_FILES['file_multimedia']['tmp_name'];
			// basename() may prevent filesystem traversal attacks;
			// further validation/sanitation of the filename may be appropriate
			$name = basename($_FILES['file_multimedia']['name']);
			move_uploaded_file($tmp_name, dirname(__DIR__).'/uploads/'.$exhibit_id.'/'.$name);
			$path = 'uploads/'.$exhibit_id.'/'.$name;
		}
		
		if($stmt = $conn->prepare('INSERT INTO multimedia (description, exhibit_id, content_type, path, active) VALUES (?, ?, ?, ?, ?)')){
			$stmt->bind_param('siisi', $multimedia_description, $exhibit_id, $content_type, $path, $active);
			$stmt->execute();
			$c_id = $stmt->insert_id;
			if ($c_id != 0) {
				http_response_code(200);
				echo json_encode(array("message" => "Multimedia inserted"));
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