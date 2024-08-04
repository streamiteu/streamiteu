<?php
    include_once "../config/dbconnect.php";
			$message="";
			$response_code=200;
			if(isset($_POST['do_login'])){
				$email=$_POST['email'];
				$password=$_POST['u_password'];

				if($stmt = $conn->prepare('SELECT users.user_id, users.user_password, users.user_type_id, institutions.institution_id FROM users, userinstitution, institutions WHERE users.user_id = userinstitution.user_id AND userinstitution.institution_id = institutions.institution_id AND email=?')){
					$stmt->bind_param('s', $email);
					$stmt->execute();
					$stmt->store_result();
					if ($stmt->num_rows > 0) {
						$stmt->bind_result($id, $pass, $user_type_id, $institution_id);
						$stmt->fetch();
						$temp = $institution_id . ', ';
						if (password_verify($password, $pass)) { // Verifying Password
							session_start();
							$_SESSION['loggedin'] = TRUE;
							$_SESSION['email'] = $email;
							$_SESSION['id'] = $id;
							$_SESSION['user_type_id'] = $user_type_id;
							if($stmt->num_rows ==1){
								$_SESSION['user_institution_id'] = $institution_id;
							}else{
								
								while ($stmt->fetch()) {
									$temp = $temp . $institution_id . ', ';
								}
								$temp = substr($temp, 0, -2);
								$_SESSION['user_institution_id'] = $temp;
								//$_SESSION['user_institution_id'] = substr($_SESSION['user_institution_id'], 0, -3);
							}
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