<?php
include_once '../config/dbconnect.php';
include_once '../config/config.php';


			$return_message="";
			$return_code=200;
			if(isset($_POST['do_changepwd'])){
				$token=$_POST['token'];
				$email= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);;
				$pwd= password_hash($_POST['pwd'], PASSWORD_DEFAULT);
				
				if($stmt = $conn->prepare('SELECT user_id, exp_date FROM reset_password_tokens WHERE token=? AND email=?')){
					$stmt->bind_param('ss', $token, $email);
					$stmt->execute();
					$stmt->store_result();
					
					if ($stmt->num_rows > 0) {
						$stmt->bind_result($user_id, $exp_date);
						$stmt->fetch();
						$curDate = date("Y-m-d H:i:s");
						if($exp_date >= $curDate){
							if ($stmt = $conn->prepare('UPDATE users SET user_password=? WHERE user_id=?')){
								$stmt->bind_param('si', $pwd, $user_id);
								$stmt->execute();
								if ($stmt = $conn->prepare('DELETE FROM reset_password_tokens WHERE token=?')){
									$stmt->bind_param('s', $token);
									$stmt->execute();
									$return_code = 200; 
									$return_message = 'The password has been changed successfully. Please try to sign in with your new password.';
								}else{
									$return_code = 400;
									$return_message = 'Database error occured';
								}
							} else {
								// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
								$return_code = 400;
								$return_message = 'Database error occured';
							}
						}else{
							$return_code=400;
							$return_message='Session expired. Please try again!';
						}
					}
					else{
						
						$return_code=400;
						$return_message='Invalid request or session expired. Please try again!';
					}
					$stmt->close();
				}else{
					$return_code=400;
					$return_message='Database connection error!';
				}
			}else{
				$return_code=400;
				$return_message='Illegal access detected!';
			}
		
		$conn->close();
		http_response_code(200);
		echo json_encode(array("response_code" => $return_code, "message" => $return_message));

        
?>