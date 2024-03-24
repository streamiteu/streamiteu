<?php
    include_once "../config/dbconnect.php";
    
    if(isset($_POST['do_register']))
    {
		$acctype = $_POST['acctype'];
        $f_name = $_POST['f_name'];
        $l_name= $_POST['l_name'];
		$email= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);;
		$u_password= password_hash($_POST['u_password'], PASSWORD_DEFAULT);
		$institution_type = $_POST['institution_type'];
		$institution= $_POST['institution'];
		$country_code= $_POST['country_code'];
		$country= $_POST['country'];
		$success = false; 
		$return_message = '';
		$return_code = 200;
		$user_type_id  = 1;
		
		$institution_id = 0;
		if(isset($_POST['institution_id'])){
			$institution_id = $_POST['institution_id'];
		}
					
        // We need to check if the account with that username exists.
		if ($stmt = $conn->prepare('SELECT * FROM users WHERE email = ?')) {
			// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();
			// Store the result so we can check if the account exists in the database.
			if ($stmt->num_rows > 0) {
				// Email already exists
				$return_code = 400;
				$return_message = 'Email exists, please choose another!';
			} else {
					// Insert new account
					if($acctype == 'institution'){
						if($institution_type == 'school'){
							$user_type_id  = 3;
						}else{
							$user_type_id  = 2;
						}
						//Check if selected institution name exists
						if ($stmt = $conn->prepare('SELECT * FROM institutions WHERE approved = 1 AND institution_name = ?')) {
							// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
							$stmt->bind_param('s', $institution);
							$stmt->execute();
							$stmt->store_result();
							// Store the result so we can check if the account exists in the database.
							if ($stmt->num_rows > 0) {
								// institution already exists
								$return_code = 400;
								$return_message = 'Intitution already exists. Register other institution. Just one responsible person per institution is allowed!';
							}else{
								// Institution doesn't exists, register the institution first and get its id
								if ($stmt = $conn->prepare('INSERT INTO institutions (institution_type,	institution_name, country_code, country_name) VALUES (?, ?, ?, ?)')) {
									$stmt->bind_param('ssss', $institution_type, $institution, $country_code, $country);
									$stmt->execute();
									$institution_id = $stmt->insert_id;
									$uniqid = uniqid();
									// Username doesn't exists, insert new account
									if ($stmt = $conn->prepare('INSERT INTO users (first_name, last_name, email, user_password, user_type_id, institution_id, activation_code) VALUES (?, ?, ?, ?, ?, ?, ?)')) {
										$stmt->bind_param('ssssiis', $f_name, $l_name, $email, $u_password, $user_type_id, $institution_id, $uniqid);
										$stmt->execute();
										$return_code = 200; 
										
										$new_user_id = $conn->insert_id;
							
										$stmt_ui = $conn->prepare("INSERT INTO userinstitution (user_id, institution_id) VALUES (?, ?)");
										$stmt_ui->bind_param('ii', $new_user_id, $institution_id);
										$stmt_ui->execute();
										
										$return_message = 'Thank you for registering! Please wait for approval of your account by authorized person, so you can login.';
									} else {
										// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
										$return_code = 400;
										$return_message = 'Database error occured';
									}
									
								} else {
									// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
									$return_code = 400;
									$return_message = 'Database error occured';
								}
								
							}
						}
					}else{
						if($institution_type == 'school'){
							$user_type_id  = 5;
						}else{
							$user_type_id  = 4;
						}
						$uniqid = uniqid();
						// Username doesn't exists, insert new account
						//if ($stmt = $conn->prepare('INSERT INTO users (first_name, last_name, country_code, country_name, email, user_password, user_type_id, institution_id, activation_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)')) {
						if ($stmt = $conn->prepare('INSERT INTO users (first_name, last_name, email, user_password, user_type_id, activation_code) VALUES (?, ?, ?, ?, ?, ?)')) {
							$stmt->bind_param('ssssis', $f_name, $l_name, $email, $u_password, $user_type_id, $uniqid);
							$stmt->execute();
							
							$new_user_id = $conn->insert_id;
							
							$stmt_ui = $conn->prepare("INSERT INTO userinstitution (user_id, institution_id) VALUES (?, ?)");
							$institutions_array = explode(",",$institution_id);
							foreach ($institutions_array as $institut) {
								$stmt_ui->bind_param('ii', $new_user_id, $institut);
								$stmt_ui->execute();
							}
							
							$return_code = 200; 
							$return_message = 'Thank you for registering! Please wait for approval of your account by authorized person, so you can login.';
						} else {
							// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
							$return_code = 400;
							$return_message = 'Database error occured';
						}
					}
					
					
				
			}
			
		} else {
			// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
			$return_message = 'Database error occured';
		}
		
		$conn->close();
		http_response_code(200);
		echo json_encode(array("response_code" => $return_code, "message" => $return_message));
       
     
    }
        
?>