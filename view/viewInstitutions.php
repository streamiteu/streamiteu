<?php
    include_once "../config/dbconnect.php";
	
	if(isset($_POST['list_institutions']))
    {
		$acctype= $_POST['acctype'];
		$institution_type = $_POST['institution_type'];
		$country_code= $_POST['country_code'];
		$country= $_POST['country'];
		
		$types = "";
		$where = [];
		$params = [];
		
		$message="";
		$response_code=200;
		
		if($acctype == 'personal'){
			if (!empty($institution_type)) {
				$types .= 's';
				$where[] = 'institution_type = ?';
				$params[] = $institution_type;
			}
			if (!empty($country_code)) {
				$types .= 's';
				$where[] = 'country_code = ?';
				$params[] = $country_code;
			}
			if (count($where)) {
				$where = " AND " . implode(" AND ", $where);
			} else {
				$where = "";
			}
			$sql = 'SELECT * FROM institutions WHERE institution_type != "system" AND approved = 1'. $where;
			
			// We need to check if the account with that username exists.
			if ($stmt = $conn->prepare($sql)) {
				// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
				if(count($params) > 0)
					$stmt->bind_param($types, ...$params);
				$stmt->execute();
				$result = $stmt->get_result();
				// Store the result so we can check if the account exists in the database.
				if ($result->num_rows > 0) {
					if($institution_type == "school"){
						$message .= '<select id="institutionlist" multiple class="form-control input-sm mb-md" size="5" style="min-height:90px" required>';
					}
					else{
						$message .= '<select id="institutionlist" class="form-control input-sm mb-md" size="5" style="min-height:90px" required>';
					}
					// there are registered institutions from the given type and country
					while ($row = $result->fetch_assoc()){
						$message .= '<option value="' . $row['institution_id'] . '">'. $row['institution_name'] . "</option>";
					}
					$message .= '</select>';
					
					
				} else {
					
					$message .= 'There is no registered institution of selected type in the selected country. It should be registered first so you can join.';
					$response_code=400;
				}
				$stmt->close();
			} else {
				// Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
				
					$message .= 'Database error occured.';
					$response_code=400;
				
			}
			$conn->close();

		}else{
			//Institutional account so you shoud register another institution
			
				$message .= '<input name="institution" type="text" class="form-control input-sm mb-md" placeholder="Enter institution name" required/>';
				$response_code=200;
			
		}

        
		
		http_response_code(200);
		echo json_encode(array("response_code" => $response_code, "message" => $message));
       //echo $message;
     
    }
?>