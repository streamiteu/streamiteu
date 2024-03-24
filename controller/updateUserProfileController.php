<?php
include_once '../config/dbconnect.php';

session_start();

if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
	
	if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']))
	{
		$user_id=$_POST['user_id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$email= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);;
		$pwd= password_hash($_POST['pwd'], PASSWORD_DEFAULT);
				
		// We need to check if the account with that username exists.
		if ($stmt = $conn->prepare('SELECT * FROM users WHERE email = ? AND user_id != ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
			$stmt->bind_param('si', $email, $user_id);
			$stmt->execute();
			$stmt->store_result();
			// Store the result so we can check if the account exists in the database.
			if ($stmt->num_rows > 0) {
				// Email already exists
				http_response_code(400);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Another user with this email already exists"));
				die();
			} else {
				//check if user whants to change his password
				if($pwd != ''){
					if($stmt = $conn->prepare('UPDATE users SET first_name=?, last_name=?, email=?, user_password =? WHERE user_id=' . $user_id)){
						$stmt->bind_param('ssss', $firstname, $lastname, $email, $pwd);
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
					$stmt->close();
				}else{
					if($stmt = $conn->prepare('UPDATE users SET first_name=?, last_name=?, email=? WHERE user_id=' . $user_id)){
						$stmt->bind_param('sss', $firstname, $lastname, $email);
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
					$stmt->close();
				}
				$stmt->close();
			}
			$stmt->close();
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