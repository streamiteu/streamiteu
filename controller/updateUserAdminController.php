<?php
include_once '../config/dbconnect.php';

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']))
	{
		$user_id=$_POST['user_id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$user_type= $_POST['user_type'];
		$institution_admin= $_POST['institution_admin'];
		$class_admin= $_POST['class_admin'];
		$approved= $_POST['approved'];
		
		//find eventual info if the user is registered as student before
		if($stmt = $conn->prepare('SELECT student_id, class_id FROM students WHERE user_id=?')){
			$stmt->bind_param('i', $user_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($student_id, $class_id);
			$stmt->fetch();
		}
		
		if($stmt = $conn->prepare('UPDATE users SET first_name=?, last_name=?, email=?, user_type_id =?, approved=? WHERE user_id=?')){
			$stmt->bind_param('sssiii', $firstname, $lastname, $email, $user_type, $approved, $user_id);
			$stmt->execute();
			
			if(isset($institution_admin)){
				if($stmt = $conn->prepare('UPDATE userinstitution SET institution_id=? WHERE user_id=?')){
					$stmt->bind_param('ii', $institution_admin, $user_id);
					$stmt->execute();
				}else{
					//echo $_POST['id'];
					http_response_code(404);
					// return a JSON object with a message property
					echo json_encode(array("message" => "Profile update error"));
					die();
				}
			}
			
			if(isset($class_admin) && $user_type==6){
				if($class_id != ''){
					if($class_admin!=$class_id){
						if($stmt = $conn->prepare('UPDATE students SET class_id=? WHERE user_id=?')){
							$stmt->bind_param('ii', $class_admin, $user_id);
							$stmt->execute();
							http_response_code(200);
							echo json_encode(array("message" => "Update succesful"));
							die();
							
						}else{
							//echo $_POST['id'];
							http_response_code(404);
							// return a JSON object with a message property
							echo json_encode(array("message" => "Profile update error"));
							die();
						}
						$stmt->close();
					}
				}else{
					if($stmt = $conn->prepare('INSERT INTO students (user_id, class_id) VALUES (?, ?)')){
						$stmt->bind_param('ii', $user_id, $class_admin);
						$stmt->execute();
						http_response_code(200);
						echo json_encode(array("message" => "Update succesful"));
						die();
						
					}else{
						//echo $_POST['id'];
						http_response_code(404);
						// return a JSON object with a message property
						echo json_encode(array("message" => "Profile update error"));
						die();
					}
					$stmt->close();
				}
				
			}else{
				if($class_id != ''){
					if($stmt = $conn->prepare('DELETE FROM students WHERE user_id=?')){
						$stmt->bind_param('i', $user_id);
						$stmt->execute();
						
						http_response_code(200);
						echo json_encode(array("message" => "Profile update succesful"));
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
			}
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