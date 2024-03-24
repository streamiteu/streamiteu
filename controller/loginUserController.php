<?php
    include_once "../config/dbconnect.php";
			$message="";
			$response_code=200;
			if(isset($_POST['do_login'])){
				$email=$_POST['email'];
				$password=$_POST['u_password'];

				if($stmt = $conn->prepare('SELECT user_id, user_password, user_type_id, institution_id FROM users WHERE email=?')){
					$stmt->bind_param('s', $email);
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows > 0) {
						$stmt->bind_result($id, $pass, $user_type_id, $institution_id);
						$stmt->fetch();
						if (password_verify($password, $pass)) { // Verifying Password
							session_start();
							$_SESSION['loggedin'] = TRUE;
							$_SESSION['email'] = $email;
							$_SESSION['id'] = $id;
							$_SESSION['user_type_id'] = $user_type_id;
							$_SESSION['user_institution_id'] = $institution_id;
							$response_code=200;
							$message='Login successful';
						}
						else {
							$response_code=400;
							$message='Invalid password. Please try again!';
						}
					}
					else{
						$response_code=400;
						$message='Invalid email. Please verify it and try again!';
					}
					$stmt->close();
				}else{
					$response_code=400;
					$message='Database connection error!';
				}
			}
		$conn->close();
		http_response_code(200);
		echo json_encode(array("response_code" => $response_code, "message" => $message));

        
?>