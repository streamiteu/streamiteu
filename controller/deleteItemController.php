<?php
include_once '../config/dbconnect.php';

			
session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['item_id']) && isset($_POST['delete_entity']))
	{
		$item_id = $_POST['item_id'];
		$delete_entity = $_POST['delete_entity'];
		$delete_key = $_POST['delete_key'];
		
		if($delete_entity == 'multimedia'){
			if($stmt = $conn->prepare("SELECT multimedia_id, exhibit_id, description, content_type, path, active FROM multimedia WHERE multimedia_id=?")){
				$stmt->bind_param('i', $item_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($multimedia_id, $exhibit_id, $description, $content_type, $path, $active);
				$stmt->fetch();
				if($content_type == 1){
					if (is_file(dirname(__DIR__).'/'.$path)) {
						if (!unlink(dirname(__DIR__).'/'.$path)) {
							//echo $_POST['id'];
							http_response_code(405);
							// return a JSON object with a message property
							echo json_encode(array("message" => "File delete error"));
							die();
						}
					}else{
						//echo $_POST['id'];
						http_response_code(404);
						// return a JSON object with a message property
						echo json_encode(array("message" => "File not found"));
						die();
					}
				}
			}else{
				//echo $_POST['id'];
				http_response_code(404);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Database connection error"));
				die();
			}
		}
				
		if($stmt = $conn->prepare('DELETE FROM '. $delete_entity .' WHERE ' . $delete_key . ' = ?')){
			$stmt->bind_param('i', $item_id);
			$stmt->execute();
			if ($stmt->affected_rows > 0) {
				if($delete_entity == 'users' || $delete_entity == 'classes'){
					if($stmt = $conn->prepare('DELETE FROM userinstitution WHERE ' . $delete_key . ' = ?')){
						$stmt->bind_param('i', $item_id);
						$stmt->execute();
					}
					if($stmt = $conn->prepare('DELETE FROM students WHERE ' . $delete_key . ' = ?')){
						$stmt->bind_param('i', $item_id);
						$stmt->execute();
						http_response_code(200);
						echo json_encode(array("message" => "Item deleted"));
						die();
					}
					else{
						//echo $_POST['id'];
						http_response_code(403);
						// return a JSON object with a message property
						echo json_encode(array("message" => "Delete error"));
						die();
					}
					$stmt->close();
				}else{
					http_response_code(200);
					echo json_encode(array("message" => "Item deleted"));
					die();
				}
				
				
			}
			else{
				//echo $_POST['id'];
				http_response_code(403);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Delete error"));
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
		echo json_encode(array("message" => "Invalid item data"));
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