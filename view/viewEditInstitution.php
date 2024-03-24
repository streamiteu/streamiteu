<?php
	include_once "../config/dbconnect.php";
	session_start();

	if(isset($_SESSION['loggedin']) && isset($_SESSION['id'])){
		if(isset($_POST['id']))
		{
			$institution_id=$_POST['id'];
			
			if($stmt = $conn->prepare("SELECT institution_id, institution_type, institution_name, country_code, country_name, approved FROM institutions WHERE institution_type != 'system' AND institution_id=?")){
				$stmt->bind_param('i', $institution_id);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($institution_id, $institution_type, $institution_name, $country_code, $country_name, $approved);
				$stmt->fetch();
			}else{
				//echo $_POST['id'];
				http_response_code(402);
				// return a JSON object with a message property
				echo json_encode(array("message" => "Institution not found!"));
				die();
			}
		}else{
			//echo $_POST['id'];
			http_response_code(402);
			// return a JSON object with a message property
			echo json_encode(array("message" => "Institution not found!"));
			die();
		}
	}else{
		//echo $_POST['id'];
		http_response_code(401);

		// return a JSON object with a message property
		echo json_encode(array("message" => "There was an error processing the request"));
		die();
	}

?>
					<div class="row">
						<div class="col-md-12">
							<form id="institution-edit-form" method="post">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="fa fa-caret-down"></a>
											<a href="#" class="fa fa-times"></a>
										</div>

										<h2 class="panel-title">Institution details</h2>
										<p class="panel-subtitle">
											Edit institution profile.
										</p>
									</header>
									<input type="hidden" id="institution_id" name="institution_id" value="<?php echo $institution_id?>">
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-3 control-label">Institution type</label>
											<div class="col-sm-9">
												<select id="institution_type" class="form-control" required>
													<option <?php if($institution_type == 'school') echo 'selected'?> value="school">school</option>
													<option <?php if($institution_type == 'museum') echo 'selected'?> value="museum">museum</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Institution Name <span class="required">*</span></label>
											<div class="col-sm-9">
												<input type="text" name="institution_name" class="form-control" value="<?php echo $institution_name?>" placeholder="eg.: John" required/>
											</div>
										</div>
										<div class="form-group">
											
											<label class="col-sm-3 control-label">Country <span class="required">*</span></label>
											<div class="col-sm-9">
												<select id="country" name="country" class="form-control input-sm mb-md" required>
													<option value="">Choose country</option>
													<option <?php if($country_code == 'AF') echo 'selected' ?> value="AF">Afghanistan</option>
													<option <?php if($country_code == 'AX') echo 'selected' ?> value="AX">Aland Islands</option>
													<option <?php if($country_code == 'AL') echo 'selected' ?> value="AL">Albania</option>
													<option <?php if($country_code == 'DZ') echo 'selected' ?> value="DZ">Algeria</option>
													<option <?php if($country_code == 'AS') echo 'selected' ?> value="AS">American Samoa</option>
													<option <?php if($country_code == 'AD') echo 'selected' ?> value="AD">Andorra</option>
													<option <?php if($country_code == 'AO') echo 'selected' ?> value="AO">Angola</option>
													<option <?php if($country_code == 'AI') echo 'selected' ?> value="AI">Anguilla</option>
													<option <?php if($country_code == 'AQ') echo 'selected' ?> value="AQ">Antarctica</option>
													<option <?php if($country_code == 'AG') echo 'selected' ?> value="AG">Antigua and Barbuda</option>
													<option <?php if($country_code == 'AR') echo 'selected' ?> value="AR">Argentina</option>
													<option <?php if($country_code == 'AM') echo 'selected' ?> value="AM">Armenia</option>
													<option <?php if($country_code == 'AW') echo 'selected' ?> value="AW">Aruba</option>
													<option <?php if($country_code == 'AU') echo 'selected' ?> value="AU">Australia</option>
													<option <?php if($country_code == 'AT') echo 'selected' ?> value="AT">Austria</option>
													<option <?php if($country_code == 'AZ') echo 'selected' ?> value="AZ">Azerbaijan</option>
													<option <?php if($country_code == 'BS') echo 'selected' ?> value="BS">Bahamas</option>
													<option <?php if($country_code == 'BH') echo 'selected' ?> value="BH">Bahrain</option>
													<option <?php if($country_code == 'BD') echo 'selected' ?> value="BD">Bangladesh</option>
													<option <?php if($country_code == 'BB') echo 'selected' ?> value="BB">Barbados</option>
													<option <?php if($country_code == 'BY') echo 'selected' ?> value="BY">Belarus</option>
													<option <?php if($country_code == 'BE') echo 'selected' ?> value="BE">Belgium</option>
													<option <?php if($country_code == 'BZ') echo 'selected' ?> value="BZ">Belize</option>
													<option <?php if($country_code == 'BJ') echo 'selected' ?> value="BJ">Benin</option>
													<option <?php if($country_code == 'BM') echo 'selected' ?> value="BM">Bermuda</option>
													<option <?php if($country_code == 'BT') echo 'selected' ?> value="BT">Bhutan</option>
													<option <?php if($country_code == 'BO') echo 'selected' ?> value="BO">Bolivia</option>
													<option <?php if($country_code == 'BQ') echo 'selected' ?> value="BQ">Bonaire, Sint Eustatius and Saba</option>
													<option <?php if($country_code == 'BA') echo 'selected' ?> value="BA">Bosnia and Herzegovina</option>
													<option <?php if($country_code == 'BW') echo 'selected' ?> value="BW">Botswana</option>
													<option <?php if($country_code == 'BV') echo 'selected' ?> value="BV">Bouvet Island</option>
													<option <?php if($country_code == 'BR') echo 'selected' ?> value="BR">Brazil</option>
													<option <?php if($country_code == 'IO') echo 'selected' ?> value="IO">British Indian Ocean Territory</option>
													<option <?php if($country_code == 'BN') echo 'selected' ?> value="BN">Brunei Darussalam</option>
													<option <?php if($country_code == 'BG') echo 'selected' ?> value="BG">Bulgaria</option>
													<option <?php if($country_code == 'BF') echo 'selected' ?> value="BF">Burkina Faso</option>
													<option <?php if($country_code == 'BI') echo 'selected' ?> value="BI">Burundi</option>
													<option <?php if($country_code == 'KH') echo 'selected' ?> value="KH">Cambodia</option>
													<option <?php if($country_code == 'CM') echo 'selected' ?> value="CM">Cameroon</option>
													<option <?php if($country_code == 'CA') echo 'selected' ?> value="CA">Canada</option>
													<option <?php if($country_code == 'CV') echo 'selected' ?> value="CV">Cape Verde</option>
													<option <?php if($country_code == 'KY') echo 'selected' ?> value="KY">Cayman Islands</option>
													<option <?php if($country_code == 'CF') echo 'selected' ?> value="CF">Central African Republic</option>
													<option <?php if($country_code == 'TD') echo 'selected' ?> value="TD">Chad</option>
													<option <?php if($country_code == 'CL') echo 'selected' ?> value="CL">Chile</option>
													<option <?php if($country_code == 'CN') echo 'selected' ?> value="CN">China</option>
													<option <?php if($country_code == 'CX') echo 'selected' ?> value="CX">Christmas Island</option>
													<option <?php if($country_code == 'CC') echo 'selected' ?> value="CC">Cocos (Keeling) Islands</option>
													<option <?php if($country_code == 'CO') echo 'selected' ?> value="CO">Colombia</option>
													<option <?php if($country_code == 'KM') echo 'selected' ?> value="KM">Comoros</option>
													<option <?php if($country_code == 'CG') echo 'selected' ?> value="CG">Congo</option>
													<option <?php if($country_code == 'CD') echo 'selected' ?> value="CD">Congo, Democratic Republic of the Congo</option>
													<option <?php if($country_code == 'CK') echo 'selected' ?> value="CK">Cook Islands</option>
													<option <?php if($country_code == 'CR') echo 'selected' ?> value="CR">Costa Rica</option>
													<option <?php if($country_code == 'CI') echo 'selected' ?> value="CI">Cote D'Ivoire</option>
													<option <?php if($country_code == 'HR') echo 'selected' ?> value="HR">Croatia</option>
													<option <?php if($country_code == 'CU') echo 'selected' ?> value="CU">Cuba</option>
													<option <?php if($country_code == 'CW') echo 'selected' ?> value="CW">Curacao</option>
													<option <?php if($country_code == 'CY') echo 'selected' ?> value="CY">Cyprus</option>
													<option <?php if($country_code == 'CZ') echo 'selected' ?> value="CZ">Czech Republic</option>
													<option <?php if($country_code == 'DK') echo 'selected' ?> value="DK">Denmark</option>
													<option <?php if($country_code == 'DJ') echo 'selected' ?> value="DJ">Djibouti</option>
													<option <?php if($country_code == 'DM') echo 'selected' ?> value="DM">Dominica</option>
													<option <?php if($country_code == 'DO') echo 'selected' ?> value="DO">Dominican Republic</option>
													<option <?php if($country_code == 'EC') echo 'selected' ?> value="EC">Ecuador</option>
													<option <?php if($country_code == 'EG') echo 'selected' ?> value="EG">Egypt</option>
													<option <?php if($country_code == 'SV') echo 'selected' ?> value="SV">El Salvador</option>
													<option <?php if($country_code == 'GQ') echo 'selected' ?> value="GQ">Equatorial Guinea</option>
													<option <?php if($country_code == 'ER') echo 'selected' ?> value="ER">Eritrea</option>
													<option <?php if($country_code == 'EE') echo 'selected' ?> value="EE">Estonia</option>
													<option <?php if($country_code == 'ET') echo 'selected' ?> value="ET">Ethiopia</option>
													<option <?php if($country_code == 'FK') echo 'selected' ?> value="FK">Falkland Islands (Malvinas)</option>
													<option <?php if($country_code == 'FO') echo 'selected' ?> value="FO">Faroe Islands</option>
													<option <?php if($country_code == 'FJ') echo 'selected' ?> value="FJ">Fiji</option>
													<option <?php if($country_code == 'FI') echo 'selected' ?> value="FI">Finland</option>
													<option <?php if($country_code == 'FR') echo 'selected' ?> value="FR">France</option>
													<option <?php if($country_code == 'GF') echo 'selected' ?> value="GF">French Guiana</option>
													<option <?php if($country_code == 'PF') echo 'selected' ?> value="PF">French Polynesia</option>
													<option <?php if($country_code == 'TF') echo 'selected' ?> value="TF">French Southern Territories</option>
													<option <?php if($country_code == 'GA') echo 'selected' ?> value="GA">Gabon</option>
													<option <?php if($country_code == 'GM') echo 'selected' ?> value="GM">Gambia</option>
													<option <?php if($country_code == 'GE') echo 'selected' ?> value="GE">Georgia</option>
													<option <?php if($country_code == 'DE') echo 'selected' ?> value="DE">Germany</option>
													<option <?php if($country_code == 'GH') echo 'selected' ?> value="GH">Ghana</option>
													<option <?php if($country_code == 'GI') echo 'selected' ?> value="GI">Gibraltar</option>
													<option <?php if($country_code == 'GR') echo 'selected' ?> value="GR">Greece</option>
													<option <?php if($country_code == 'GL') echo 'selected' ?> value="GL">Greenland</option>
													<option <?php if($country_code == 'GD') echo 'selected' ?> value="GD">Grenada</option>
													<option <?php if($country_code == 'GP') echo 'selected' ?> value="GP">Guadeloupe</option>
													<option <?php if($country_code == 'GU') echo 'selected' ?> value="GU">Guam</option>
													<option <?php if($country_code == 'GT') echo 'selected' ?> value="GT">Guatemala</option>
													<option <?php if($country_code == 'GG') echo 'selected' ?> value="GG">Guernsey</option>
													<option <?php if($country_code == 'GN') echo 'selected' ?> value="GN">Guinea</option>
													<option <?php if($country_code == 'GW') echo 'selected' ?> value="GW">Guinea-Bissau</option>
													<option <?php if($country_code == 'GY') echo 'selected' ?> value="GY">Guyana</option>
													<option <?php if($country_code == 'HT') echo 'selected' ?> value="HT">Haiti</option>
													<option <?php if($country_code == 'HM') echo 'selected' ?> value="HM">Heard Island and Mcdonald Islands</option>
													<option <?php if($country_code == 'VA') echo 'selected' ?> value="VA">Holy See (Vatican City State)</option>
													<option <?php if($country_code == 'HN') echo 'selected' ?> value="HN">Honduras</option>
													<option <?php if($country_code == 'HK') echo 'selected' ?> value="HK">Hong Kong</option>
													<option <?php if($country_code == 'HU') echo 'selected' ?> value="HU">Hungary</option>
													<option <?php if($country_code == 'IS') echo 'selected' ?> value="IS">Iceland</option>
													<option <?php if($country_code == 'IN') echo 'selected' ?> value="IN">India</option>
													<option <?php if($country_code == 'ID') echo 'selected' ?> value="ID">Indonesia</option>
													<option <?php if($country_code == 'IR') echo 'selected' ?> value="IR">Iran, Islamic Republic of</option>
													<option <?php if($country_code == 'IQ') echo 'selected' ?> value="IQ">Iraq</option>
													<option <?php if($country_code == 'IE') echo 'selected' ?> value="IE">Ireland</option>
													<option <?php if($country_code == 'IM') echo 'selected' ?> value="IM">Isle of Man</option>
													<option <?php if($country_code == 'IL') echo 'selected' ?> value="IL">Israel</option>
													<option <?php if($country_code == 'IT') echo 'selected' ?> value="IT">Italy</option>
													<option <?php if($country_code == 'JM') echo 'selected' ?> value="JM">Jamaica</option>
													<option <?php if($country_code == 'JP') echo 'selected' ?> value="JP">Japan</option>
													<option <?php if($country_code == 'JE') echo 'selected' ?> value="JE">Jersey</option>
													<option <?php if($country_code == 'JO') echo 'selected' ?> value="JO">Jordan</option>
													<option <?php if($country_code == 'KZ') echo 'selected' ?> value="KZ">Kazakhstan</option>
													<option <?php if($country_code == 'KE') echo 'selected' ?> value="KE">Kenya</option>
													<option <?php if($country_code == 'KI') echo 'selected' ?> value="KI">Kiribati</option>
													<option <?php if($country_code == 'KP') echo 'selected' ?> value="KP">Korea, Democratic People's Republic of</option>
													<option <?php if($country_code == 'KR') echo 'selected' ?> value="KR">Korea, Republic of</option>
													<option <?php if($country_code == 'XK') echo 'selected' ?> value="XK">Kosovo</option>
													<option <?php if($country_code == 'KW') echo 'selected' ?> value="KW">Kuwait</option>
													<option <?php if($country_code == 'KG') echo 'selected' ?> value="KG">Kyrgyzstan</option>
													<option <?php if($country_code == 'LA') echo 'selected' ?> value="LA">Lao People's Democratic Republic</option>
													<option <?php if($country_code == 'LV') echo 'selected' ?> value="LV">Latvia</option>
													<option <?php if($country_code == 'LB') echo 'selected' ?> value="LB">Lebanon</option>
													<option <?php if($country_code == 'LS') echo 'selected' ?> value="LS">Lesotho</option>
													<option <?php if($country_code == 'LR') echo 'selected' ?> value="LR">Liberia</option>
													<option <?php if($country_code == 'LY') echo 'selected' ?> value="LY">Libyan Arab Jamahiriya</option>
													<option <?php if($country_code == 'LI') echo 'selected' ?> value="LI">Liechtenstein</option>
													<option <?php if($country_code == 'LT') echo 'selected' ?> value="LT">Lithuania</option>
													<option <?php if($country_code == 'LU') echo 'selected' ?> value="LU">Luxembourg</option>
													<option <?php if($country_code == 'MO') echo 'selected' ?> value="MO">Macao</option>
													<option <?php if($country_code == 'MG') echo 'selected' ?> value="MG">Madagascar</option>
													<option <?php if($country_code == 'MW') echo 'selected' ?> value="MW">Malawi</option>
													<option <?php if($country_code == 'MY') echo 'selected' ?> value="MY">Malaysia</option>
													<option <?php if($country_code == 'MV') echo 'selected' ?> value="MV">Maldives</option>
													<option <?php if($country_code == 'ML') echo 'selected' ?> value="ML">Mali</option>
													<option <?php if($country_code == 'MT') echo 'selected' ?> value="MT">Malta</option>
													<option <?php if($country_code == 'MH') echo 'selected' ?> value="MH">Marshall Islands</option>
													<option <?php if($country_code == 'MQ') echo 'selected' ?> value="MQ">Martinique</option>
													<option <?php if($country_code == 'MR') echo 'selected' ?> value="MR">Mauritania</option>
													<option <?php if($country_code == 'MU') echo 'selected' ?> value="MU">Mauritius</option>
													<option <?php if($country_code == 'YT') echo 'selected' ?> value="YT">Mayotte</option>
													<option <?php if($country_code == 'MX') echo 'selected' ?> value="MX">Mexico</option>
													<option <?php if($country_code == 'FM') echo 'selected' ?> value="FM">Micronesia, Federated States of</option>
													<option <?php if($country_code == 'MD') echo 'selected' ?> value="MD">Moldova, Republic of</option>
													<option <?php if($country_code == 'MC') echo 'selected' ?> value="MC">Monaco</option>
													<option <?php if($country_code == 'MN') echo 'selected' ?> value="MN">Mongolia</option>
													<option <?php if($country_code == 'ME') echo 'selected' ?> value="ME">Montenegro</option>
													<option <?php if($country_code == 'MS') echo 'selected' ?> value="MS">Montserrat</option>
													<option <?php if($country_code == 'MA') echo 'selected' ?> value="MA">Morocco</option>
													<option <?php if($country_code == 'MZ') echo 'selected' ?> value="MZ">Mozambique</option>
													<option <?php if($country_code == 'MM') echo 'selected' ?> value="MM">Myanmar</option>
													<option <?php if($country_code == 'NA') echo 'selected' ?> value="NA">Namibia</option>
													<option <?php if($country_code == 'NR') echo 'selected' ?> value="NR">Nauru</option>
													<option <?php if($country_code == 'NP') echo 'selected' ?> value="NP">Nepal</option>
													<option <?php if($country_code == 'NL') echo 'selected' ?> value="NL">Netherlands</option>
													<option <?php if($country_code == 'AN') echo 'selected' ?> value="AN">Netherlands Antilles</option>
													<option <?php if($country_code == 'NC') echo 'selected' ?> value="NC">New Caledonia</option>
													<option <?php if($country_code == 'NZ') echo 'selected' ?> value="NZ">New Zealand</option>
													<option <?php if($country_code == 'NI') echo 'selected' ?> value="NI">Nicaragua</option>
													<option <?php if($country_code == 'NE') echo 'selected' ?> value="NE">Niger</option>
													<option <?php if($country_code == 'NG') echo 'selected' ?> value="NG">Nigeria</option>
													<option <?php if($country_code == 'NU') echo 'selected' ?> value="NU">Niue</option>
													<option <?php if($country_code == 'NF') echo 'selected' ?> value="NF">Norfolk Island</option>
													<option <?php if($country_code == 'MK') echo 'selected' ?> value="MK">North Macedonia</option>
													<option <?php if($country_code == 'MP') echo 'selected' ?> value="MP">Northern Mariana Islands</option>
													<option <?php if($country_code == 'NO') echo 'selected' ?> value="NO">Norway</option>
													<option <?php if($country_code == 'OM') echo 'selected' ?> value="OM">Oman</option>
													<option <?php if($country_code == 'PK') echo 'selected' ?> value="PK">Pakistan</option>
													<option <?php if($country_code == 'PW') echo 'selected' ?> value="PW">Palau</option>
													<option <?php if($country_code == 'PS') echo 'selected' ?> value="PS">Palestinian Territory, Occupied</option>
													<option <?php if($country_code == 'PA') echo 'selected' ?> value="PA">Panama</option>
													<option <?php if($country_code == 'PG') echo 'selected' ?> value="PG">Papua New Guinea</option>
													<option <?php if($country_code == 'PY') echo 'selected' ?> value="PY">Paraguay</option>
													<option <?php if($country_code == 'PE') echo 'selected' ?> value="PE">Peru</option>
													<option <?php if($country_code == 'PH') echo 'selected' ?> value="PH">Philippines</option>
													<option <?php if($country_code == 'PN') echo 'selected' ?> value="PN">Pitcairn</option>
													<option <?php if($country_code == 'PL') echo 'selected' ?> value="PL">Poland</option>
													<option <?php if($country_code == 'PT') echo 'selected' ?> value="PT">Portugal</option>
													<option <?php if($country_code == 'PR') echo 'selected' ?> value="PR">Puerto Rico</option>
													<option <?php if($country_code == 'QA') echo 'selected' ?> value="QA">Qatar</option>
													<option <?php if($country_code == 'RE') echo 'selected' ?> value="RE">Reunion</option>
													<option <?php if($country_code == 'RO') echo 'selected' ?> value="RO">Romania</option>
													<option <?php if($country_code == 'RU') echo 'selected' ?> value="RU">Russian Federation</option>
													<option <?php if($country_code == 'RW') echo 'selected' ?> value="RW">Rwanda</option>
													<option <?php if($country_code == 'BL') echo 'selected' ?> value="BL">Saint Barthelemy</option>
													<option <?php if($country_code == 'SH') echo 'selected' ?> value="SH">Saint Helena</option>
													<option <?php if($country_code == 'KN') echo 'selected' ?> value="KN">Saint Kitts and Nevis</option>
													<option <?php if($country_code == 'LC') echo 'selected' ?> value="LC">Saint Lucia</option>
													<option <?php if($country_code == 'MF') echo 'selected' ?> value="MF">Saint Martin</option>
													<option <?php if($country_code == 'PM') echo 'selected' ?> value="PM">Saint Pierre and Miquelon</option>
													<option <?php if($country_code == 'VC') echo 'selected' ?> value="VC">Saint Vincent and the Grenadines</option>
													<option <?php if($country_code == 'WS') echo 'selected' ?> value="WS">Samoa</option>
													<option <?php if($country_code == 'SM') echo 'selected' ?> value="SM">San Marino</option>
													<option <?php if($country_code == 'ST') echo 'selected' ?> value="ST">Sao Tome and Principe</option>
													<option <?php if($country_code == 'SA') echo 'selected' ?> value="SA">Saudi Arabia</option>
													<option <?php if($country_code == 'SN') echo 'selected' ?> value="SN">Senegal</option>
													<option <?php if($country_code == 'RS') echo 'selected' ?> value="RS">Serbia</option>
													<option <?php if($country_code == 'CS') echo 'selected' ?> value="CS">Serbia and Montenegro</option>
													<option <?php if($country_code == 'SC') echo 'selected' ?> value="SC">Seychelles</option>
													<option <?php if($country_code == 'SL') echo 'selected' ?> value="SL">Sierra Leone</option>
													<option <?php if($country_code == 'SG') echo 'selected' ?> value="SG">Singapore</option>
													<option <?php if($country_code == 'SX') echo 'selected' ?> value="SX">Sint Maarten</option>
													<option <?php if($country_code == 'SK') echo 'selected' ?> value="SK">Slovakia</option>
													<option <?php if($country_code == 'SI') echo 'selected' ?> value="SI">Slovenia</option>
													<option <?php if($country_code == 'SB') echo 'selected' ?> value="SB">Solomon Islands</option>
													<option <?php if($country_code == 'SO') echo 'selected' ?> value="SO">Somalia</option>
													<option <?php if($country_code == 'ZA') echo 'selected' ?> value="ZA">South Africa</option>
													<option <?php if($country_code == 'GS') echo 'selected' ?> value="GS">South Georgia and the South Sandwich Islands</option>
													<option <?php if($country_code == 'SS') echo 'selected' ?> value="SS">South Sudan</option>
													<option <?php if($country_code == 'ES') echo 'selected' ?> value="ES">Spain</option>
													<option <?php if($country_code == 'LK') echo 'selected' ?> value="LK">Sri Lanka</option>
													<option <?php if($country_code == 'SD') echo 'selected' ?> value="SD">Sudan</option>
													<option <?php if($country_code == 'SR') echo 'selected' ?> value="SR">Suriname</option>
													<option <?php if($country_code == 'SJ') echo 'selected' ?> value="SJ">Svalbard and Jan Mayen</option>
													<option <?php if($country_code == 'SZ') echo 'selected' ?> value="SZ">Swaziland</option>
													<option <?php if($country_code == 'SE') echo 'selected' ?> value="SE">Sweden</option>
													<option <?php if($country_code == 'CH') echo 'selected' ?> value="CH">Switzerland</option>
													<option <?php if($country_code == 'SY') echo 'selected' ?> value="SY">Syrian Arab Republic</option>
													<option <?php if($country_code == 'TW') echo 'selected' ?> value="TW">Taiwan, Province of China</option>
													<option <?php if($country_code == 'TJ') echo 'selected' ?> value="TJ">Tajikistan</option>
													<option <?php if($country_code == 'TZ') echo 'selected' ?> value="TZ">Tanzania, United Republic of</option>
													<option <?php if($country_code == 'TH') echo 'selected' ?> value="TH">Thailand</option>
													<option <?php if($country_code == 'TL') echo 'selected' ?> value="TL">Timor-Leste</option>
													<option <?php if($country_code == 'TG') echo 'selected' ?> value="TG">Togo</option>
													<option <?php if($country_code == 'TK') echo 'selected' ?> value="TK">Tokelau</option>
													<option <?php if($country_code == 'TO') echo 'selected' ?> value="TO">Tonga</option>
													<option <?php if($country_code == 'TT') echo 'selected' ?> value="TT">Trinidad and Tobago</option>
													<option <?php if($country_code == 'TN') echo 'selected' ?> value="TN">Tunisia</option>
													<option <?php if($country_code == 'TR') echo 'selected' ?> value="TR">Turkey</option>
													<option <?php if($country_code == 'TM') echo 'selected' ?> value="TM">Turkmenistan</option>
													<option <?php if($country_code == 'TC') echo 'selected' ?> value="TC">Turks and Caicos Islands</option>
													<option <?php if($country_code == 'TV') echo 'selected' ?> value="TV">Tuvalu</option>
													<option <?php if($country_code == 'UG') echo 'selected' ?> value="UG">Uganda</option>
													<option <?php if($country_code == 'UA') echo 'selected' ?> value="UA">Ukraine</option>
													<option <?php if($country_code == 'AE') echo 'selected' ?> value="AE">United Arab Emirates</option>
													<option <?php if($country_code == 'GB') echo 'selected' ?> value="GB">United Kingdom</option>
													<option <?php if($country_code == 'US') echo 'selected' ?> value="US">United States</option>
													<option <?php if($country_code == 'UM') echo 'selected' ?> value="UM">United States Minor Outlying Islands</option>
													<option <?php if($country_code == 'UY') echo 'selected' ?> value="UY">Uruguay</option>
													<option <?php if($country_code == 'UZ') echo 'selected' ?> value="UZ">Uzbekistan</option>
													<option <?php if($country_code == 'VU') echo 'selected' ?> value="VU">Vanuatu</option>
													<option <?php if($country_code == 'VE') echo 'selected' ?> value="VE">Venezuela</option>
													<option <?php if($country_code == 'VN') echo 'selected' ?> value="VN">Viet Nam</option>
													<option <?php if($country_code == 'VG') echo 'selected' ?> value="VG">Virgin Islands, British</option>
													<option <?php if($country_code == 'VI') echo 'selected' ?> value="VI">Virgin Islands, U.s.</option>
													<option <?php if($country_code == 'WF') echo 'selected' ?> value="WF">Wallis and Futuna</option>
													<option <?php if($country_code == 'EH') echo 'selected' ?> value="EH">Western Sahara</option>
													<option <?php if($country_code == 'YE') echo 'selected' ?> value="YE">Yemen</option>
													<option <?php if($country_code == 'ZM') echo 'selected' ?> value="ZM">Zambia</option>
													<option <?php if($country_code == 'ZW') echo 'selected' ?> value="ZW">Zimbabwe</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Approved </label>
											<div class="col-sm-9">
												<input type="checkbox" id="approved" name="approved" <?php if ($approved == 1) echo 'checked' ?> value="<?php echo $approved ?>">
											</div>
										</div>
										
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-9 col-sm-offset-3">
												<button class="btn btn-primary">Save</button>
												<button type="reset" class="btn btn-default">Reset</button>
												<label class="error return-message"></label>
											</div>
										</div>
									</footer>
								</section>
							</form>
						</div>
					</div>
							<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
<?php
	$conn->close();
?>	