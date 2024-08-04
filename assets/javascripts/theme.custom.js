/* Add here all your JS customizations */

//Signup form customization depending on the profile type

(function( $ ) {
/*
	let messages = {
		firstname: "First name is not valid.",
		lastname: "Last name is not valid.",
		email: "Please enter a valid email address.",
		pwd: "Both entered passwords should be the same.",
		confirmationemail: "Confirmation email with an activation link has been sent at your email address. Please click on the activation link to activate your account.",
		dateISO: "Please enter a valid date (ISO).",
		number: "Please enter a valid number.",
		digits: "Please enter only digits.",
		creditcard: "Please enter a valid credit card number.",
		equalTo: "Please enter the same value again."
	}
	*/
	'use strict';
	
	
	
	
	//user approval
	/*
	$(".approved-btn").change(function() {
		alert('bbb');
		var approved = 0;
		if(this.checked) {
			approved = 1;
		}else{
			approved = 0;
		}
		var fd = new FormData();
		fd.append('user_id', $(this).val());
		fd.append('approved', approved);
		
		$.ajax({
			url:"./controller/approveUserController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				alert('User account updated');
				Router('users');
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					alert(result.message);
					Router('users');
				}
			}
		});
	});
	*/
	
	
	/*
	setInterval(function() {
		if(userType == 6){
			
			var fd = new FormData();
			
			
			fd.append('tour_id', tourID);
			
			$.ajax({
				url:"./controller/getCurrentExhibitController.php",
				method:"post",
				data:fd,
				processData: false,
				contentType: false,
				success: function(response){
					
					var result = JSON.parse(response);
					var exhibit_id = result.message;
					
					if(exhibit_id != ''){
						var index = exhibitsA.findIndex(x => x.exhibit_id == exhibit_id);
						$('#exhibit-title').html(exhibitsA[index].exhibit_name);
						var html_content = "";
						Object.keys(multimediaA).forEach(key => {
							if(multimediaA[key].exhibit_id == exhibit_id){
								html_content=html_content+ "<li><a href='#' onclick=ShowMultimedia('" + multimediaA[key].path + "')><i class='fa fa-file' aria-hidden='true'></i><span>" + multimediaA[key].description + "</span></a></li>";
							}
						});
						$('#multimedia-attachments').html(html_content);
					}
				},
				error: function(xhr, status, error) {
				
				}
			});
		}
	}, 2000);
	*/
	
	
	
	
	$('#next-exhibit').on('click', function(e) {
		var currentExhibit = $('#current-exhibit-id').val();
		if($('#current-exhibit-id').val()==''){
			currentExhibit = exhibitsA[0].exhibit_id;
		}else{
			var index = exhibitsA.findIndex(x => x.exhibit_id == $('#current-exhibit-id').val());
			if(index < exhibitsA.length-1)
				currentExhibit = exhibitsA[index+1].exhibit_id;
		}
		if(currentExhibit != ''){
			$('#current-exhibit-id').val(currentExhibit);
			var index = exhibitsA.findIndex(x => x.exhibit_id == $('#current-exhibit-id').val());
			$('#exhibit-title').html(exhibitsA[index].exhibit_name);
			var fd = new FormData();
			fd.append('tour_id', tourID);
			fd.append('current_exhibit_id', currentExhibit);
			
			$.ajax({
				url:"./controller/setCurrentExhibitController.php",
				method:"post",
				data:fd,
				processData: false,
				contentType: false,
				success: function(response){
					/*
					var html_content = "";
						Object.keys(multimediaA).forEach(key => {
							if(multimediaA[key].exhibit_id == currentExhibit)
								html_content=html_content+ "<li><a href='#' onclick=ShowMultimedia('" + multimediaA[key].path + "')><i class='fa fa-file' aria-hidden='true'></i><span>" + multimediaA[key].description + "</span></a></li>";
						});
						$('#multimedia-attachments').html(html_content);
					*/
				},
				error: function(xhr, status, error) {
					
				}
			});
			
		}
		
	});
	
	$('#previous-exhibit').on('click', function(e) {
		var currentExhibit = $('#current-exhibit-id').val();
		if($('#current-exhibit-id').val()!=''){
			var index = exhibitsA.findIndex(x => x.exhibit_id == $('#current-exhibit-id').val());
			if(index > 0)
				currentExhibit = exhibitsA[index-1].exhibit_id;
		}
		if(currentExhibit != ''){
			$('#current-exhibit-id').val(currentExhibit);
			var index = exhibitsA.findIndex(x => x.exhibit_id == $('#current-exhibit-id').val());
			$('#exhibit-title').html(exhibitsA[index].exhibit_name);
			
			var fd = new FormData();
			fd.append('tour_id', tourID);
			fd.append('current_exhibit_id', currentExhibit);
			
			$.ajax({
				url:"./controller/setCurrentExhibitController.php",
				method:"post",
				data:fd,
				processData: false,
				contentType: false,
				success: function(response){
					/*
					var html_content = "";
						Object.keys(multimediaA).forEach(key => {
							if(multimediaA[key].exhibit_id == currentExhibit)
								html_content=html_content+ "<li><a href='#' onclick=ShowMultimedia('" + multimediaA[key].path + "')><i class='fa fa-file' aria-hidden='true'></i><span>" + multimediaA[key].description + "</span></a></li>";
						});
						$('#multimedia-attachments').html(html_content);
					*/
				},
				error: function(xhr, status, error) {
					
				}
			});
		}
	});
	
	
	
	

	//admin panel user type selection
	$("#user_type").change(function() {
		var institution_type = '';
		switch($(this).val()) {
			case "3":
			case "5":
			{
				institution_type = 'school';
				$('#institution-admin').prop('disabled', false);
				$('#class-admin').prop('disabled', true);
				$("#class-admin").val($("#class-admin option:first").val());
				$("#institution-admin").val($("#institution-admin option:first").val());
				$('#institution-admin option').hide();
				$('#institution-admin option[data-institution-type="'+institution_type+'"]').show();
				break;
			}
			case "6":
			{
				institution_type = 'school';
				$('#institution-admin').prop('disabled', false);
				$('#class-admin').prop('disabled', true);
				$("#class-admin").val($("#class-admin option:first").val());
				$("#institution-admin").val($("#institution-admin option:first").val());
				$('#institution-admin option').hide();
				$('#institution-admin option[data-institution-type="'+institution_type+'"]').show();
				break;
			}
			case "2":
			case "4":
			{
				institution_type = 'museum';
				$('#institution-admin').prop('disabled', false);
				$('#class-admin').prop('disabled', true);
				$("#class-admin").val($("#class-admin option:first").val());
				$("#institution-admin").val($("#institution-admin option:first").val());
				$('#institution-admin option').hide();
				$('#institution-admin option[data-institution-type="'+institution_type+'"]').show();
				break;
			}
			default:
			{
				/*
				institution_type = '';
				$('#institution-admin').prop('disabled', true);
				$("#institution-admin").val($("#institution-admin option:first").val());
				$('#class-admin').prop('disabled', true);
				$("#class-admin").val($("#class-admin option:first").val());
				break;
				*/
				
				institution_type = 'system';
				$('#institution-admin').prop('disabled', false);
				$('#class-admin').prop('disabled', true);
				$("#class-admin").val($("#class-admin option:first").val());
				$("#institution-admin").val($("#institution-admin option:first").val());
				$('#institution-admin option').hide();
				$('#institution-admin option[data-institution-type="'+institution_type+'"]').show();
			}
		}
	});
	$("#institution-admin").change(function() {
		
		$('#class-admin option[data-institution-id="0"]').attr('selected','selected');
		if($(this).find(':selected').data('institution-type') == 'school' && $('#user_type').find(":selected").val() == '6'){
			$('#class-admin option').hide();
			$('#class-admin option[data-institution-id="'+$('#institution-admin').find(":selected").val()+'"]').show();
			$('#class-admin').prop('disabled', false);
			$("#class-admin").val($("#class-admin option:first").val());
		}else{
			$('#class-admin').prop('disabled', true);
			$("#class-admin").val($("#class-admin option:first").val());
		}
	});
	
	$(".class-control").change(function() {
		
		var class_id = $(this).find(':selected').val();
		var fd = new FormData();
		fd.append('class_id', class_id);
		
		$.ajax({
			url:"./controller/selectStudentByClassController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var result = JSON.parse(response);
				var data = JSON.parse(result.message);
				$('#inputStudents').empty(0);
				$.each(data, function(index, value) {
					$('#inputStudents').append($('<option>').text(value.name).val(value.user_id));
				});
				
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".editclass-message").css("display", "inline-block");
					$(".editclass-message").css("color", "#ff0000");
					$('.editclass-message').html(result.message);
				}else if(xhr.status==403){
					$(".editclass-message").css("display", "inline-block");
					$(".editclass-message").css("color", "#ff0000");
					$('.editclass-message').html(result.message);
				}else {
					$(".editclass-message").css("display", "inline-block");
					$(".editclass-message").css("color", "#ff0000");
					$('.editclass-message').html(result.message);
				}
			}
		});
		
	});
	
	
	
	$('#addStudents').on('click', function(e) {
		$('#inputStudents').val();
		//alert($('#inputStudents').val());
		
		$("#inputStudents :selected").each(function() {
			if(0 == $('#outputStudents option[value='+this.value+']').length){
				$('#outputStudents').append($('<option>').text(this.text).val(this.value));
			}
        });
		
	});
	$('#removeStudents').on('click', function(e) {
		$("#outputStudents option:selected").remove();	
		
	});
	
	//add or edit tour guide for a tour
	$('.edittg-item-btn').on('click', function(e) {
		$('#tour_id').val($(this).data('itemid'));
		$('#return_route').val($(this).data('returnroute'));
		$('#editTourGuideModalDialog').css("display", "block");
	});
	$('.closetg').on('click', function(e) {
		$('#editTourGuideModalDialog').css("display", "none");
	});
	$('#cancelModalTG').on('click', function(e) {
		$('#editTourGuideModalDialog').css("display", "none");
	});
	
	$(window).click(function(e) {
		if(e.target.id=="editTourGuideModalDialog"){
			$('#editTourGuideModalDialog').css("display", "none");
		}
	});
	
	
	
	// validation summary
	$('.delete-item-btn').on('click', function(e) {
		$('#delete_item_id').val($(this).data('itemid'));
		$('#delete_key').val($(this).data('itemkey'));
		$('#delete_entity').val($(this).data('entity'));
		$('#return_route').val($(this).data('returnroute'));
		$('#deleteModalDialog').css("display", "block");
	});
	$('.close').on('click', function(e) {
		$('#deleteModalDialog').css("display", "none");
	});
	$('#cancelModal').on('click', function(e) {
		$('#deleteModalDialog').css("display", "none");
	});
	
	$(window).click(function(e) {
		if(e.target.id=="deleteModalDialog"){
			$('#deleteModalDialog').css("display", "none");
		}
	});

	$('input[type=radio][name=accounttype]').change(function() {
		var acctype = $("input[name='accounttype']:checked").val();
		var institution_type = $("#institutiontype").val();
		var country_code = $("#country").val();
		var country = $("#country option:selected").text();
		var fd = new FormData();
		fd.append('acctype', acctype);
		fd.append('institution_type', institution_type);
		fd.append('country_code', country_code);
		fd.append('country', country);
		fd.append('list_institutions', 'list_institutions');

		if (this.value == 'personal') {
			$("#data_details").html(messages.personal_details);
			listInstitutions(fd);
		}
		else if (this.value == 'institution') {
			$("#data_details").html(messages.institution_details);
			listInstitutions(fd);
		}
		
	});
	$("#institutiontype").on("change", function() {
		var acctype = $("input[name='accounttype']:checked").val();
		var institution_type = $("#institutiontype").val();
		var country_code = $("#country").val();
		var country = $("#country option:selected").text();

		var fd = new FormData();
		fd.append('acctype', acctype);
		fd.append('institution_type', institution_type);
		fd.append('country_code', country_code);
		fd.append('country', country);
		fd.append('list_institutions', 'list_institutions');
		listInstitutions(fd);
	});
	$("#country").on("change", function() {
		var acctype = $("input[name='accounttype']:checked").val();
		var institution_type = $("#institutiontype").val();
		var country_code = $("#country").val();
		var country = $("#country option:selected").text();
		var fd = new FormData();
		fd.append('acctype', acctype);
		fd.append('institution_type', institution_type);
		fd.append('country_code', country_code);
		fd.append('country', country);
		fd.append('list_institutions', 'list_institutions');
		listInstitutions(fd);
	});
	
	
	$("#museum-schedule").on("change", function() {
		if($('#museum-schedule').find(":selected").val() != ''){
			$('#exhibition-schedule option').hide();
			$("#exhibition-schedule").val("");
			$('#exhibition-schedule option[data-institution-id="'+$('#museum-schedule').find(":selected").val()+'"]').show();
		}else{
			$('#exhibition-schedule option').show();
		}
	});
	$("#exhibition-schedule").on("change", function() {
		Router('scheduler', $('#exhibition-schedule').find(":selected").val());
	});
	
	
	$("#museum-route").on("change", function() {
		if($('#museum-route').find(":selected").val() != ''){
			$('#exhibition-route option').hide();
			$("#exhibition-route").val("");
			$('#exhibition-route option[data-institution-id="'+$('#museum-route').find(":selected").val()+'"]').show();
		}else{
			$('#exhibition-route option').show();
		}
	});
	$("#exhibition-route").on("change", function() {
		Router('newtour', $('#exhibition-route').find(":selected").val());
	});
	
	//exhibit multimedia content page
	$("#multimedia-content-type").on("change", function() {
		
		if($(this).find(':selected').val() == '0'){
			$(".file-group").css("display", "none");
			$(".multimedia-group").css("display", "block");
			$("#multimedia_link").val("");
			$("#multimedia_link").prop('required',true);
			$("#file_multimedia").prop('required',false);
			
			
		}else{
			$(".file-group").css("display", "block");
			$(".multimedia-group").css("display", "none");
			$("#file_multimedia").val("");
			
			$("#multimedia_link").prop('required',false);
			$("#file_multimedia").prop('required',true);
		}
	});

	
	$('form#user_registration').submit(function(e) {
		e.preventDefault();
		$(".validation-message").css("display", "none");
		$(".info-message").css("display", "none");
		var acctype = $("input[name='accounttype']:checked").val();
		var firstname = $("input[name=firstname]").val();
	
		if(!(isFirstNameValidWithUnicodeSupport(firstname) || isFirstNameValidWithUnicodeSupport(firstname, 'LATIN'))){
			$(".validation-message").css("display", "block");
			$('#error_message').html(messages.firstname);
			return false;
		}	
		var lastname = $("input[name=lastname]").val();
		if(!(isFirstNameValidWithUnicodeSupport(lastname) || isFirstNameValidWithUnicodeSupport(lastname, 'LATIN'))){
			$(".validation-message").css("display", "block");
			$('#error_message').html(messages.lastname);
			return false;
		}	
		var email = $("input[name=email]").val();
		var u_password = $("input[name=pwd]").val();
		var passwordconfirm = $("input[name=pwd_confirm]").val();
		if(u_password != passwordconfirm){
			$(".validation-message").css("display", "block");
			$('#error_message').html(messages.pwd);
			return false;
		}
		var institution_type = $("#institutiontype").val();
		var institution = $("input[name=institution]").val();
		
		var country_code = $("#country").val();
		var country = $("#country option:selected").text();

		var fd = new FormData();
		fd.append('acctype', acctype);
		fd.append('f_name', firstname);
		fd.append('l_name', lastname);
		fd.append('email', email);
		fd.append('u_password', u_password);
		fd.append('institution_type', institution_type);
		fd.append('institution', institution);
		fd.append('country_code', country_code);
		fd.append('country', country);
		fd.append('do_register', 'do_register');
		if( $('#institutionlist').length )         // use this if you are using id to check
		{
			var institution_id = $("#institutionlist").val();
			var institution = $("#institutionlist option:selected").text();
			fd.append('institution_id', institution_id);
			fd.append('institution', institution);
		}
		registerUser(fd);
    });
	
	
	
	$('form#user_login').submit(function(e) {
		e.preventDefault();
		$(".validation-message").css("display", "none");
		$(".info-message").css("display", "none");	
		var email = $("input[name=email]").val();
		var u_password = $("input[name=pwd]").val();
		
		var fd = new FormData();
		fd.append('email', email);
		fd.append('u_password', u_password);
		fd.append('do_login', 'do_login');
		loginUser(fd);
    });
	
	$('form#recoverpassword').submit(function(e) {
		e.preventDefault();
		$(".validation-message").css("display", "none");	
		var email = $("input[name=email]").val();
		var fd = new FormData();
		fd.append('email', email);
		fd.append('do_resetpwd', 'do_resetpwd');
		resetPassword(fd);
    });
	
	$('form#change_password').submit(function(e) {
		e.preventDefault();
		$(".validation-message").css("display", "none");	
		var email = $("input[name=email]").val();
		var token = $("input[name=token]").val();
		var pwd = $("input[name=pwd]").val();
		var cpwd = $("input[name=cpwd]").val();
		if(pwd != cpwd){
			$(".validation-message").css("display", "block");
			$('#error_message').html(messages.pwd);
			return false;
		}
		var fd = new FormData();
		fd.append('email', email);
		fd.append('token', token);
		fd.append('pwd', pwd);
		fd.append('cpwd', cpwd);
		fd.append('do_changepwd', 'do_changepwd');
		changePassword(fd);
    });
	
	
	
	//edit tour guide
	$('form#tg-item-form').submit(function(e) {
		e.preventDefault();
		$(".tg-item-message").css("display", "none");	
		var tour_id = $("input[name=tour_id]").val();
		var tour_guide_id = $('#tour_guide_id').find(":selected").val();
		var return_route = $("input[name=return_route]").val();
		var fd = new FormData();
		fd.append('tour_id', tour_id);
		fd.append('tour_guide_id', tour_guide_id);
		fd.append('return_route', return_route);
		
		$.ajax({
			url:"./controller/updateTourGuideController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				//var data = $.parseJSON(response);
				$(".tg-item-message").css("display", "inline-block");
				$(".tg-item-message").css("color", "#2BC82B");
				$(".tg-item-message").html('Tour guide has been successfully added to this tour');
				setTimeout(function() {
					$(".editTourGuideModalDialog").css("display", "none");
					Router(return_route);
				}, 2000);
			},
			error: function(xhr, status, error) {
				//var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					$(".tg-item-message").css("display", "inline-block");
					$(".tg-item-message").css("color", "#ff0000");
					$(".tg-item-message").html(result.message);
				}
			}
		});
    });
	
	//edit class form subimt
	$('form#editclass-form').submit(function(e) {
		e.preventDefault();
		$(".editclass-message").css("display", "none");	
		var classname = $("input[name=classname]").val();
		var school_id = $('#school_id').find(":selected").val();
		var class_id = $("input[name=class_id]").val();
		var fd = new FormData();
		fd.append('classname', classname);
		fd.append('school_id', school_id);
		fd.append('class_id', class_id);
		
		$.ajax({
			url:"./controller/updateClassController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".editclass-message").css("display", "inline-block");
				$(".editclass-message").css("color", "#2BC82B");
				$('.editclass-message').html('Class is updated');
				setTimeout(function() {
					Router('classes');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".editclass-message").css("display", "inline-block");
					$(".editclass-message").css("color", "#ff0000");
					$('.editclass-message').html(result.message);
				}else if(xhr.status==403){
					$(".editclass-message").css("display", "inline-block");
					$(".editclass-message").css("color", "#ff0000");
					$('.editclass-message').html(result.message);
				}else {
					$(".editclass-message").css("display", "inline-block");
					$(".editclass-message").css("color", "#ff0000");
					$('.editclass-message').html(result.message);
				}
			}
		});
    });
	
	//delete item form subimt
	$('form#delete-item-form').submit(function(e) {
		e.preventDefault();
		$(".delete-item-message").css("display", "none");	
		var item_id = $("input[name=delete_item_id]").val();
		var delete_entity = $("input[name=delete_entity]").val();
		var return_route = $("input[name=return_route]").val();
		var delete_key = $("input[name=delete_key]").val();
		var fd = new FormData();
		fd.append('item_id', item_id);
		fd.append('delete_entity', delete_entity);
		fd.append('return_route', return_route);
		fd.append('delete_key', delete_key);
		
		$.ajax({
			url:"./controller/deleteItemController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				//var data = $.parseJSON(response);
				$(".delete-item-message").css("display", "inline-block");
				$(".delete-item-message").css("color", "#2BC82B");
				$(".delete-item-message").html('The item is successfully deleted');
				setTimeout(function() {
					$(".deleteModalDialog").css("display", "none");
					Router(return_route);
				}, 2000);
			},
			error: function(xhr, status, error) {
				//var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					$(".delete-item-message").css("display", "inline-block");
					$(".delete-item-message").css("color", "#ff0000");
					$(".delete-item-message").html(result.message);
				}
			}
		});
    });
	
	
	//delete item form subimt
	$('form#delete-multimedia-form').submit(function(e) {
		e.preventDefault();
		$(".delete-item-message").css("display", "none");	
		var item_id = $("input[name=delete_item_id]").val();
		var delete_entity = $("input[name=delete_entity]").val();
		var return_route = $("input[name=return_route]").val();
		var delete_key = $("input[name=delete_key]").val();
		var exhibit_id = $("input[name=exhibit_id]").val();
		
		var fd = new FormData();
		fd.append('item_id', item_id);
		fd.append('delete_entity', delete_entity);
		fd.append('return_route', return_route);
		fd.append('delete_key', delete_key);
		
		$.ajax({
			url:"./controller/deleteItemController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				
				var data = $.parseJSON(response);
				$(".delete-item-message").css("display", "inline-block");
				$(".delete-item-message").css("color", "#2BC82B");
				$(".delete-item-message").html('The item is successfully deleted');
				setTimeout(function() {
					$(".deleteModalDialog").css("display", "none");
					Router(return_route, exhibit_id);
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					$(".delete-item-message").css("display", "inline-block");
					$(".delete-item-message").css("color", "#ff0000");
					$(".delete-item-message").html(result.message);
				}
			}
		});
    });
	
	
	//delete lecture form subimt
	$('form#delete-lecture-form').submit(function(e) {
		e.preventDefault();
		$(".delete-item-message").css("display", "none");	
		var item_id = $("input[name=delete_item_id]").val();
		var delete_entity = $("input[name=delete_entity]").val();
		var return_route = $("input[name=return_route]").val();
		var delete_key = $("input[name=delete_key]").val();
		var tour_id = $("input[name=tour_id]").val();
		
		var fd = new FormData();
		fd.append('item_id', item_id);
		fd.append('delete_entity', delete_entity);
		fd.append('return_route', return_route);
		fd.append('delete_key', delete_key);
		
		$.ajax({
			url:"./controller/deleteItemController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".delete-item-message").css("display", "inline-block");
				$(".delete-item-message").css("color", "#2BC82B");
				$(".delete-item-message").html('The item is successfully deleted');
				setTimeout(function() {
					$(".deleteModalDialog").css("display", "none");
					Router(return_route, tour_id);
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					$(".delete-item-message").css("display", "inline-block");
					$(".delete-item-message").css("color", "#ff0000");
					$(".delete-item-message").html(result.message);
				}
			}
		});
    });
	
	//insert class form subimt
	$('form#insertclass-form').submit(function(e) {
		e.preventDefault();
		$(".editclass-message").css("display", "none");	
		var class_name = $("input[name=class_name]").val();
		var school_id = $('#school_id').find(":selected").val();
		var fd = new FormData();
		fd.append('class_name', class_name);
		fd.append('school_id', school_id);
		
		$.ajax({
			url:"./controller/insertClassController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".editclass-message").css("display", "inline-block");
				$(".editclass-message").css("color", "#2BC82B");
				$('.editclass-message').html('New class is added');
				setTimeout(function() {
					Router('classes');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".editclass-message").css("display", "inline-block");
					$(".editclass-message").css("color", "#ff0000");
					$('.editclass-message').html(result.message);
				}else if(xhr.status==403){
					$(".editclass-message").css("display", "inline-block");
					$(".editclass-message").css("color", "#ff0000");
					$('.editclass-message').html(result.message);
				}else {
					$(".editclass-message").css("display", "inline-block");
					$(".editclass-message").css("color", "#ff0000");
					$('.editclass-message').html(result.message);
				}
			}
		});
    });
	
	
	//update user profile form subimt
	$('form#profile-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		var user_id = $("#user_id").val();
		var firstname = $("input[name=firstname]").val();
		var lastname = $("input[name=lastname]").val();
		var email = $("input[name=email]").val();
		var pwd = $("input[name=pwd]").val();
		var pwd_confirm = $("input[name=pwd_confirm]").val();
		if((pwd != '' || pwd_confirm != '') && pwd != pwd_confirm){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('Please re-type the same password');

			return false;
		}
		var fd = new FormData();
		fd.append('user_id', user_id);
		fd.append('firstname', firstname);
		fd.append('lastname', lastname);
		fd.append('email', email);
		fd.append('pwd', pwd);
		
		$.ajax({
			url:"./controller/updateUserProfileController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('User profile is updated');
				setTimeout(function() {
					Router('userprofile');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	
	//update user profile admin form subimt
	$('form#user-edit-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		var user_id = $("#user_id").val();
		var firstname = $("input[name=firstname]").val();
		var lastname = $("input[name=lastname]").val();
		var email = $("input[name=email]").val();
		var user_type = $('#user_type').find(":selected").val();
		var institution_admin = $('#institution-admin').find(":selected").val();
		var class_admin = $('#class-admin').find(":selected").val();
		var approved = 0;
		if ($('#approved').is(':checked')) {
			approved = 1;
		}
		
		var institution_type = $('#institution-admin').find(":selected").attr("data-institution-type")
		
		if(user_type == 1 && institution_type != 'system'){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('User type is not corresponding to the selected institution');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		if((user_type == 2 || user_type == 4) && institution_type != 'museum'){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('User type is not corresponding to the selected institution');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		if((user_type == 3 || user_type == 5 || user_type == 6) && institution_type != 'school'){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('User type is not corresponding to the selected institution');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		if(user_type == 6 && class_admin == ''){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('Please select a class for the student');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		

		var fd = new FormData();
		fd.append('user_id', user_id);
		fd.append('firstname', firstname);
		fd.append('lastname', lastname);
		fd.append('email', email);
		fd.append('user_type', user_type);
		fd.append('institution_admin', institution_admin);
		fd.append('class_admin', class_admin);
		fd.append('approved', approved);
		
		$.ajax({
			url:"./controller/updateUserAdminController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('User profile is updated');
				setTimeout(function() {
					Router('users');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	
	//insert user profile admin form subimt
	$('form#user-insert-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		var firstname = $("input[name=firstname]").val();
		var lastname = $("input[name=lastname]").val();
		var email = $("input[name=email]").val();
		var user_type = $('#user_type').find(":selected").val();
		var institution_admin = $('#institution-admin').find(":selected").val();
		var class_admin = $('#class-admin').find(":selected").val();
		var approved = 0;
		if ($('#approved').is(':checked')) {
			approved = 1;
		}
		
		var institution_type = $('#institution-admin').find(":selected").attr("data-institution-type")
		
		if(user_type == 1 && institution_type != 'system'){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('User type is not corresponding to the selected institution');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		if((user_type == 2 || user_type == 4) && institution_type != 'museum'){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('User type is not corresponding to the selected institution');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		if((user_type == 3 || user_type == 5 || user_type == 6) && institution_type != 'school'){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('User type is not corresponding to the selected institution');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		if(user_type == 6 && class_admin == ''){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('Please select a class for the student');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		
		
		var fd = new FormData();
		
		fd.append('firstname', firstname);
		fd.append('lastname', lastname);
		fd.append('email', email);
		fd.append('user_type', user_type);
		fd.append('institution_admin', institution_admin);
		fd.append('class_admin', class_admin);
		fd.append('approved', approved);
		
		$.ajax({
			url:"./controller/insertUserAdminController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('User profile is created');
				setTimeout(function() {
					Router('users');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	//update institution profile
	$('form#institution-edit-form').submit(function(e) {
		e.preventDefault();
		
		$(".return-message").css("display", "none");	
		var institution_id = $("#institution_id").val();
		var institution_name = $("input[name=institution_name]").val();
		var institution_type = $('#institution_type').find(":selected").val();
		var country_code = $('#country').find(":selected").val();
		var country_name = $('#country').find(":selected").text();
		var approved = 0;
		if ($('#approved').is(':checked')) {
			approved = 1;
		}
		
		var fd = new FormData();
		fd.append('institution_id', institution_id);
		fd.append('institution_name', institution_name);
		fd.append('institution_type', institution_type);
		fd.append('country_code', country_code);
		fd.append('country_name', country_name);
		fd.append('approved', approved);
		
		
		
		$.ajax({
			url:"./controller/updateInstitutionController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('Institution profile is updated');
				setTimeout(function() {
					Router('institutions');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	
	//insert institution form subimt
	$('form#insertinstitution-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		var institution_name = $("input[name=institution_name]").val();
		var institution_type = $('#institution-type').find(":selected").val();
		var country_code = $('#country-institution-admin').find(":selected").val();
		var country_name = $('#country-institution-admin').find(":selected").text();
		var approved = 0;
		if ($('#approved').is(':checked')) {
			approved = 1;
		}
		
		var fd = new FormData();
		fd.append('institution_name', institution_name);
		fd.append('institution_type', institution_type);
		fd.append('country_code', country_code);
		fd.append('country_name', country_name);
		fd.append('approved', approved);
		
		
		$.ajax({
			url:"./controller/insertInstitutionController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('New institution is added');
				setTimeout(function() {
					Router('institutions');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
		
    });
	
	//import students form subimt
	$('form#import-students-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		
		var institution_id = $('#school-student-import').find(":selected").val();
		var class_id = $('#class-student-import').find(":selected").val();
		var file_data = $("#file_students").prop("files")[0]; 
		
		
		
		var fd = new FormData();
		fd.append('institution_id', institution_id);
		fd.append('class_id', class_id);
		fd.append('file', file_data);
		
		
		
		
		$.ajax({
			url:"./controller/importStudentsController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html(data.message);
				setTimeout(function() {
					Router('students');
				}, 4000);
			},
			error: function(xhr, status, error) {
				
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
		
    });
	
	//insert student admin form subimt
	$('form#student-insert-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		var firstname = $("input[name=firstname]").val();
		var lastname = $("input[name=lastname]").val();
		var email = $("input[name=email]").val();
		var user_type = 6;
		var institution_id = $('#institution-admin').find(":selected").val();
		var class_id = $('#class-admin').find(":selected").val();
		var approved = 1;
		
		
		var fd = new FormData();
		
		fd.append('firstname', firstname);
		fd.append('lastname', lastname);
		fd.append('email', email);
		fd.append('user_type', user_type);
		fd.append('institution_id', institution_id);
		fd.append('class_id', class_id);
		fd.append('approved', approved);
		
		$.ajax({
			url:"./controller/insertStudentController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('Student account is createed');
				setTimeout(function() {
					Router('students');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
		
    });
	
	//student import form school selection
	$("#school-student-import").change(function() {
		$('#class-student-import option[data-institution-id="0"]').attr('selected','selected');
		var institution_id = $('#school-student-import').find(":selected").val();
		$('#class-student-import option').hide();
		$('#class-student-import option[data-institution-id="'+institution_id+'"]').show();
		$("#class-student-import").val($("#class-student-import option:first").val());
	});
	
	//update student profile admin form subimt
	$('form#student-edit-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		var user_id = $("#user_id").val();
		var firstname = $("input[name=firstname]").val();
		var lastname = $("input[name=lastname]").val();
		var email = $("input[name=email]").val();
		var user_type = $('#user_type').find(":selected").val();
		var institution_admin = $('#institution-admin').find(":selected").val();
		var class_admin = $('#class-admin').find(":selected").val();
		var approved = 0;
		if ($('#approved').is(':checked')) {
			approved = 1;
		}
		
		var institution_type = $('#institution-admin').find(":selected").attr("data-institution-type")
		
		if(user_type == 1 && institution_type != 'system'){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('User type is not corresponding to the selected institution');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		if((user_type == 2 || user_type == 4) && institution_type != 'museum'){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('User type is not corresponding to the selected institution');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		if((user_type == 3 || user_type == 5 || user_type == 6) && institution_type != 'school'){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('User type is not corresponding to the selected institution');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		if(user_type == 6 && class_admin == ''){
			$(".return-message").css("display", "inline-block");
			$(".return-message").css("color", "#ff0000");
			$('.return-message').html('Please select a class for the student');
			setTimeout(function() {
				$(".return-message").css("display", "none");
			}, 4000);
			return false;
		}
		

		var fd = new FormData();
		fd.append('user_id', user_id);
		fd.append('firstname', firstname);
		fd.append('lastname', lastname);
		fd.append('email', email);
		fd.append('user_type', user_type);
		fd.append('institution_admin', institution_admin);
		fd.append('class_admin', class_admin);
		fd.append('approved', approved);
		
		$.ajax({
			url:"./controller/updateUserAdminController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('User profile is updated');
				setTimeout(function() {
					Router('students');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });

	
	//insert Exhibition admin form subimt
	$('form#insertexhibition-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		
		var exhibition_title = $("input[name=exhibition_title]").val();
		var exhibition_description = $("input[name=exhibition_description]").val();
		
		var institution_id = $('#museum').find(":selected").val();
		var exhibition_map = $("input[name=exhibition_map]").val();
		var exhibition_ip = $("input[name=exhibition_ip]").val();
		var exhibition_port = $("input[name=exhibition_port]").val();
		var server_name = $("input[name=server_name]").val();
		var active = 0;
		if ($('#active').is(':checked')) {
			active = 1;
		}

		var fd = new FormData();
		fd.append('exhibition_title', exhibition_title);
		fd.append('exhibition_description', exhibition_description);
		fd.append('institution_id', institution_id);
		fd.append('exhibition_map', exhibition_map);
		fd.append('exhibition_ip', exhibition_ip);
		fd.append('exhibition_port', exhibition_port);
		fd.append('server_name', server_name);
		fd.append('active', active);
		
		$.ajax({
			url:"./controller/insertExhibitionController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('New exhibition inserted');
				setTimeout(function() {
					Router('exhibitions');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	
	//update Exhibition admin form subimt
	$('form#exhibition-edit-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		var exhibition_id = $("input[name=exhibition_id]").val();
		var exhibition_title = $("input[name=exhibition_title]").val();
		var exhibition_description = $("input[name=exhibition_description]").val();
		
		var institution_id = $('#museum').find(":selected").val();
		var exhibition_map = $("input[name=exhibition_map]").val();
		var exhibition_ip = $("input[name=exhibition_ip]").val();
		var exhibition_port = $("input[name=exhibition_port]").val();
		var server_name = $("input[name=server_name]").val();
		var active = 0;
		if ($('#active').is(':checked')) {
			active = 1;
		}

		var fd = new FormData();
		fd.append('exhibition_id', exhibition_id);
		fd.append('exhibition_title', exhibition_title);
		fd.append('exhibition_description', exhibition_description);
		fd.append('institution_id', institution_id);
		fd.append('exhibition_map', exhibition_map);
		fd.append('exhibition_ip', exhibition_ip);
		fd.append('exhibition_port', exhibition_port);
		fd.append('server_name', server_name);
		fd.append('active', active);
		
		$.ajax({
			url:"./controller/updateExhibitionController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('Exhibition data updated');
				setTimeout(function() {
					Router('exhibitions');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	
	//insert Exhibit admin form subimt
	$('form#insertexhibit-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		
		var exhibit_name = $("input[name=exhibit_name]").val();
		var exhibit_description = $("input[name=exhibit_description]").val();
		var exhibition_id = $('#exhibition').find(":selected").val();
		var exhibit_location_x = $("input[name=exhibit_location_x]").val();
		var exhibit_location_y = $("input[name=exhibit_location_y]").val();
		var exhibit_location_z = $("input[name=exhibit_location_z]").val();
		var exhibit_heading_x = $("input[name=exhibit_heading_x]").val();
		var exhibit_heading_y = $("input[name=exhibit_heading_y]").val();
		var exhibit_heading_z = $("input[name=exhibit_heading_z]").val();
		var active = 0;
		if ($('#active').is(':checked')) {
			active = 1;
		}
		
		var fd = new FormData();
		fd.append('exhibit_name', exhibit_name);
		fd.append('exhibit_description', exhibit_description);
		fd.append('exhibition_id', exhibition_id);
		fd.append('exhibit_location_x', exhibit_location_x);
		fd.append('exhibit_location_y', exhibit_location_y);
		fd.append('exhibit_location_z', exhibit_location_z);
		fd.append('exhibit_heading_x', exhibit_heading_x);
		fd.append('exhibit_heading_y', exhibit_heading_y);
		fd.append('exhibit_heading_z', exhibit_heading_z);
		fd.append('active', active);
		
		$.ajax({
			url:"./controller/insertExhibitController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('New exhibit inserted');
				setTimeout(function() {
					Router('exhibits');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	//edit Exhibit admin form subimt
	$('form#editexhibit-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		
		var exhibit_id = $("input[name=exhibit_id]").val();
		var exhibit_name = $("input[name=exhibit_name]").val();
		var exhibit_description = $("input[name=exhibit_description]").val();
		var exhibition_id = $('#exhibition').find(":selected").val();
		var exhibit_location_x = $("input[name=exhibit_location_x]").val();
		var exhibit_location_y = $("input[name=exhibit_location_y]").val();
		var exhibit_location_z = $("input[name=exhibit_location_z]").val();
		var exhibit_heading_x = $("input[name=exhibit_heading_x]").val();
		var exhibit_heading_y = $("input[name=exhibit_heading_y]").val();
		var exhibit_heading_z = $("input[name=exhibit_heading_z]").val();
		var active = 0;
		if ($('#active').is(':checked')) {
			active = 1;
		}
		
		var fd = new FormData();
		fd.append('exhibit_id', exhibit_id);
		fd.append('exhibit_name', exhibit_name);
		fd.append('exhibit_description', exhibit_description);
		fd.append('exhibition_id', exhibition_id);
		fd.append('exhibit_location_x', exhibit_location_x);
		fd.append('exhibit_location_y', exhibit_location_y);
		fd.append('exhibit_location_z', exhibit_location_z);
		fd.append('exhibit_heading_x', exhibit_heading_x);
		fd.append('exhibit_heading_y', exhibit_heading_y);
		fd.append('exhibit_heading_z', exhibit_heading_z);
		fd.append('active', active);
		
		$.ajax({
			url:"./controller/updateExhibitController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('Exhibit updated');
				setTimeout(function() {
					Router('exhibits');
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	
	//Scheduler insert schedule admin form subimt
	$('form#insert-timeslot-form').submit(function(e) {
		e.preventDefault();
		
		$(".return-message").css("display", "none");	
		
		var exhibition_id = $("input[name=exhibition_id]").val();
		var schedule_start = $("input[name=starttime]").val();
		var schedule_end = $("input[name=endtime]").val();
		var schedule_type = $('#tour-type').find(":selected").val();
		
		var fd = new FormData();
		fd.append('exhibition_id', exhibition_id);
		fd.append('schedule_start', schedule_start);
		fd.append('schedule_end', schedule_end);
		fd.append('schedule_type', schedule_type);
		
		$.ajax({
			url:"./controller/insertScheduleController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('Schedule updated');
				setTimeout(function() {
					//$(".modal").css("display", "none");
					$("#calendarModalInsert").modal('hide');
					Router('scheduler', exhibition_id);
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	//Scheduler delete schedule admin form subimt
	$('form#delete-timeslot-form').submit(function(e) {
		e.preventDefault();
		
		$(".return-message").css("display", "none");	
		
		var schedule_id = $("input[name=schedule_id]").val();
		var exhibition_id = $("input[name=exhibition_id]").val();
		
		var fd = new FormData();
				
		fd.append('item_id', schedule_id);
		fd.append('delete_entity', 'schedule');
		fd.append('return_route', 'scheduler');
		fd.append('delete_key', 'schedule_id');

		$.ajax({
			url:"./controller/deleteItemController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('Schedule updated');
				setTimeout(function() {
					//$(".modal").css("display", "none");
					$("#calendarModalDelete").modal('hide');
					Router('scheduler', exhibition_id);
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
    });
	
	//upload multimedia to exhibit form subimt
	$('form#edit-exhibit-multimedia-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		var multimedia_description = $("input[name=multimedia_description]").val();
		var exhibit_id = $("input[name=exhibit_id]").val();
		var content_type = $('#multimedia-content-type').find(":selected").val();
		var file_multimedia = '';
		var multimedia_link = '';
		if(content_type==0){
			multimedia_link = $("input[name=multimedia_link]").val();
		}else{
			file_multimedia = $("#file_multimedia").prop("files")[0];
		}
		//var multimedia_link = $("input[name=multimedia_link]").val();
		//var file_multimedia = $("#file_multimedia").prop("files")[0];
		
		var fd = new FormData();
		fd.append('multimedia_description', multimedia_description);
		fd.append('exhibit_id', exhibit_id);
		fd.append('content_type', content_type);
		fd.append('multimedia_link', multimedia_link);
		fd.append('file_multimedia', file_multimedia);
		
		$.ajax({
			url:"./controller/insertMultimediaController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html(data.message);
				Router('editexhibitmultimedia', exhibit_id);
			},
			error: function(xhr, status, error) {
				
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
		
    });
	
	
	//upload lectures to route form subimt
	$('form#edit-lectures-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		var lecture_title = $("input[name=lecture_title]").val();
		var tour_id = $("input[name=tour_id]").val();
		var	file_multimedia = $("#file_multimedia").prop("files")[0];
		
		var fd = new FormData();
		fd.append('lecture_title', lecture_title);
		fd.append('tour_id', tour_id);
		fd.append('file_multimedia', file_multimedia);
		
		$.ajax({
			url:"./controller/insertLectureController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html(data.message);
				Router('edittourlectures', tour_id);
			},
			error: function(xhr, status, error) {
				
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
		
    });
	
	//insert new tour form subimt
	$('form#new-tour-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		$(".return-message").val('');
		
		var schedule_id = $("input[name=schedule_id]").val();
		var tourname = $("input[name=tourname]").val();
		var vals = $("#outputStudents option").map(function () {
			return this.value;
		}).get();
		var tour_attendees = vals.join(", ")
		var exibitsA = $('#exhibit-list input:checked').map(function () {
			return this.value;
		}).get();
		var tour_exhibits = exibitsA.join(", ")


		var fd = new FormData();
		fd.append('schedule_id', schedule_id);
		fd.append('tour_attendees', tour_attendees);
		fd.append('tour_exhibits', tour_exhibits);
		
		$.ajax({
			url:"./controller/insertTourController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html(data.message);
				setTimeout(function() {
					Router('tours');
				}, 2000);
				
			},
			error: function(xhr, status, error) {
				
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
		
    });
	
	
	//edit new tour form subimt
	$('form#edit-tour-form').submit(function(e) {
		e.preventDefault();
		$(".return-message").css("display", "none");	
		$(".return-message").val('');
		
		var tour_id = $("input[name=tour_id]").val();
		var schedule_id = $("input[name=schedule_id]").val();
		var tourname = $("input[name=tourname]").val();
		var vals = $("#outputStudents option").map(function () {
			return this.value;
		}).get();
		var tour_attendees = vals.join(", ")
		var exibitsA = $('#exhibit-list input:checked').map(function () {
			return this.value;
		}).get();
		var tour_exhibits = exibitsA.join(", ")

		var fd = new FormData();
		fd.append('tour_id', tour_id);
		fd.append('schedule_id', schedule_id);
		fd.append('tour_attendees', tour_attendees);
		fd.append('tour_exhibits', tour_exhibits);
		
		$.ajax({
			url:"./controller/updateTourController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html(data.message);
				setTimeout(function() {
					Router('tours');
				}, 2000);
				
			},
			error: function(xhr, status, error) {
				
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
		
    });
	/* Strong password regex
	//^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$
	//https://stackoverflow.com/questions/5142103/regex-to-validate-password-strength
	^                         Start anchor
	(?=.*[A-Z].*[A-Z])        Ensure string has two uppercase letters.
	(?=.*[!@#$&*])            Ensure string has one special case letter.
	(?=.*[0-9].*[0-9])        Ensure string has two digits.
	(?=.*[a-z].*[a-z].*[a-z]) Ensure string has three lowercase letters.
	.{8}                      Ensure string is of length 8.
	$                         End anchor.
	*/
	
	//funkcija za proverka na validno ime i prezime
	const isFirstNameValidWithUnicodeSupport = (name, culture = 'CYRILLIC') => {
		const cultures = {
		CYRILLIC: /^(?=[\u0410-\u042F\u0430-\u044F\u0400-\u040F\u0450-\u045F ']{2,25}$)(?=(?:\S+\s){0,1}\S*$)(?:[^']*|[^']*?[\u0410-\u042F\u0430-\u044F\u0400-\u040F\u0450-\u045F]'[^']+)$/,
		LATIN: /^(?=[A-Za-z ']{2,25}$)(?=(?:\S+\s){0,1}\S*$)(?:[^']*|[^']*?[A-Za-z]'[^']+)$/,
		};
	return  cultures[culture].test(name);
	
	
	
	
	
	
	
}
	
}).apply( this, [ jQuery ]);


function init_fun() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      initialDate: '2023-11-11',
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: false,
      selectable: true,
      events: [
        {
          title: 'Business Lunch',
          start: '2023-01-03T13:00:00',
          constraint: 'businessHours'
        },
        {
          title: 'Meeting',
          start: '2023-01-13T11:00:00',
          constraint: 'availableForMeeting', // defined below
          color: '#257e4a'
        },
        {
          title: 'Conference',
          start: '2023-01-18',
          end: '2023-01-20'
        },
        {
          title: 'Party',
          start: '2023-01-29T20:00:00'
        },

        // areas where "Meeting" must be dropped
        {
          groupId: 'availableForMeeting',
          start: '2023-01-11T10:00:00',
          end: '2023-01-11T16:00:00',
          display: 'background'
        },
        {
          groupId: 'availableForMeeting',
          start: '2023-01-13T10:00:00',
          end: '2023-01-13T16:00:00',
          display: 'background'
        },

        // red areas where no events can be dropped
        {
          start: '2023-01-24',
          end: '2023-01-28',
          overlap: false,
          display: 'background',
          color: '#ff9f89'
        },
        {
          start: '2023-01-06',
          end: '2023-01-08',
          overlap: false,
          display: 'background',
          color: '#ff9f89'
        }
      ]
    });

    calendar.render();
  };
  
const routes = {
    404: {
        template: "/templates/404.html",
        title: "404",
        description: "Page not found",
    },
    "/": {
        template: "/templates/index.html",
        title: "Home",
        description: "This is the home page",
    },
    "classes": {
        template: "./view/viewClasses.php",
        title: "List of classes",
        description: "This is classes list page",
    },
    "newclass": {
        template: "./view/viewAddClass.php",
        title: "Add new class",
        description: "This is a new class page",
    },
	"editclass": {
        template: "./view/viewEditClass.php",
        title: "Edit class",
        description: "This is a edit class page",
    },
	"students": {
        template: "./view/viewStudents.php",
        title: "List of students",
        description: "This is a students page",
    },
	"newstudent": {
        template: "./view/viewAddStudent.php",
        title: "Add new student",
        description: "This is a new student page",
    },
	"editstudent": {
        template: "./view/viewEditStudent.php",
        title: "Edit student",
        description: "This is an edit student page",
    },
	"importstudents": {
        template: "./view/viewImportStudents.php",
        title: "Import students",
        description: "Import students page",
    },
	"tours": {
        template: "./view/viewTours.php",
        title: "List of tours",
        description: "Tours page",
    },
	"newtour": {
        template: "./view/viewAddTour.php",
        title: "New tour",
        description: "Schedue new tour",
    },
	"edittour": {
        template: "./view/viewEditTour.php",
        title: "Edit tour",
        description: "Edit existing tour",
    },
	"userprofile": {
        template: "./view/viewUserProfile.php",
        title: "User profile",
        description: "Edit user profile",
    },
	"users": {
        template: "./view/viewUsers.php",
        title: "List of users",
        description: "This is a users page",
    },
	"newuser": {
        template: "./view/viewAddUser.php",
        title: "Add new user",
        description: "This is a new user page",
    },
	"edituser": {
        template: "./view/viewEditUser.php",
        title: "Edit user",
        description: "This is an edit user page",
    },
	"institutions": {
        template: "./view/viewInstitutionsAdmin.php",
        title: "List of institutions",
        description: "This is an institutions page",
    },
	"newinstitution": {
        template: "./view/viewAddInstitution.php",
        title: "Add new institution",
        description: "This is a new institution page",
    },
	"editinstitution": {
        template: "./view/viewEditInstitution.php",
        title: "Edit institution",
        description: "This is an edit institution page",
    },
	"exhibitions": {
        template: "./view/viewExhibitions.php",
        title: "List of exhibitions",
        description: "This is an exhibitions page",
    },
	"newexhibition": {
        template: "./view/viewAddExhibition.php",
        title: "Add new exhibition",
        description: "This is a new exhibition page",
    },
	"editexhibition": {
        template: "./view/viewEditExhibition.php",
        title: "Edit exhibition",
        description: "This is an edit exhibition page",
    },
	"mapexhibition": {
        template: "./view/viewMapExhibition.php",
        title: "Map exhibition",
        description: "This is an exhibition mapping page",
    },
	"exhibits": {
        template: "./view/viewExhibits.php",
        title: "List of exhibits",
        description: "This is an exhibits page",
    },
	"newexhibit": {
        template: "./view/viewAddExhibit.php",
        title: "Add new exhibit",
        description: "This is a new exhibit page",
    },
	"editexhibit": {
        template: "./view/viewEditExhibit.php",
        title: "Edit exhibit",
        description: "This is an edit exhibit page",
    },
	"editexhibitmultimedia": {
        template: "./view/viewEditExhibitMultimedia.php",
        title: "Edit exhibit multimedia",
        description: "This is an edit exhibit multimedia page",
    },
	"edittourlectures": {
        template: "./view/viewEditTourLectures.php",
        title: "Edit tour lectures",
        description: "This is the lectures page",
    },
	"scheduler": {
        template: "./view/viewScheduler.php",
        title: "Scheduler",
        description: "This is scheduler page",
    },
	"saveExhibit": {
        template: "./controller/saveExhibit.php",
        title: "Save exhibit",
        description: "Save exhibit page",
    },
};

function Router(inputroute, record_id){

	const route = routes[inputroute] || routes["404"];
    $.ajax({
       url:route.template,
       method:"post",
       data:{record:route, id:record_id},
       success:function(data){
		   $("#contentcontainer").html(data);
		   /*
           $("#datatable-default_filter input").addClass("form-control");
		   $("#datatable-default_filter input").attr("placeholder", "Search...");
		   $("#datatable-default_filter input").css('width','100%');
		   $("#datatable-default_filter label").css('width','100%');
		   */
		   $(".page-header h2").html(route.title);
		   $("#current_section").html(route.title);
		   document.title = route.description;
		   
		   
       },
		error: function(xhr, status, error) {
			if(xhr.status==401){
				window.location.href="signin.php"; //session expired
			}

			//var result = JSON.parse(xhr.responseText);
			//alert(result.message);
		}
   });
   
   $.ajax({
	   
	   url:"./header.php",
	   method:"post",
	   data:"./header.php",
	   success:function(data){
		   $(".header").html(data);
	   },
		error: function(xhr, status, error) {
			if(xhr.status==401){
				window.location.href="signin.php"; //session expired
			}
		}
   });
   
}

function Logout(){
	$.ajax({
	   
	   url:"./logout.php",
	   method:"post",
	   data:"",
	   success:function(data){
		   window.location.href="signin.php";
	   },
		error: function(xhr, status, error) {
			if(xhr.status==401){
				window.location.href="signin.php"; //session expired
			}
		}
   });
}

	//user approval status
	function approveUser(control, userID, email ){
		var approved = 0;
		if(document.getElementById(control).checked) {
			approved = 1;
		}else{
			approved = 0;
		}
		var fd = new FormData();
		fd.append('user_id', userID);
		fd.append('approved', approved);
		fd.append('email', email);
		
		
		
		$.ajax({
			url:"./controller/approveUserController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				alert('User account updated');
				Router('users');
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					alert(result.message);
					Router('users');
				}
			}
		});
	}
	
	
	//student approval status
	function approveStudent(control, userID, email){
		var approved = 0;
		if(document.getElementById(control).checked) {
			approved = 1;
		}else{
			approved = 0;
		}
		var fd = new FormData();
		fd.append('user_id', userID);
		fd.append('approved', approved);
		fd.append('email', email);
		
		
		
		$.ajax({
			url:"./controller/approveUserController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				alert('Student account updated');
				Router('students');
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					alert(result.message);
					Router('users');
				}
			}
		});
	}
	
	//institution approval status
	function approveInstitution(control, institutionID ){
		var approved = 0;
		if(document.getElementById(control).checked) {
			approved = 1;
		}else{
			approved = 0;
		}
		var fd = new FormData();
		fd.append('institution_id', institutionID);
		fd.append('approved', approved);
		
		$.ajax({
			url:"./controller/approveInstitutionController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				alert('Institution status updated');
				Router('institutions');
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					alert(result.message);
					Router('institutions');
				}
			}
		});
	}
	
	
	//exhibition activation status
	function atctivateExhibition(control, institutionID ){
		var active = 0;
		if(document.getElementById(control).checked) {
			active = 1;
		}else{
			active = 0;
		}
		var fd = new FormData();
		fd.append('exhibition_id', institutionID);
		fd.append('active', active);
		
		$.ajax({
			url:"./controller/activateExhibitionController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				alert('Exhibition status updated');
				Router('exhibitions');
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					alert(result.message);
					Router('exhibitions');
				}
			}
		});
	}
	
	
	//exhibit activation status
	function atctivateExhibit(control, exhibitID ){
		var active = 0;
		if(document.getElementById(control).checked) {
			active = 1;
		}else{
			active = 0;
		}
		var fd = new FormData();
		fd.append('exhibit_id', exhibitID);
		fd.append('active', active);
		
		$.ajax({
			url:"./controller/activateExhibitController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				alert('Exhibit status updated');
				Router('exhibits');
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else{
					alert(result.message);
					Router('exhibits');
				}
			}
		});
	}
	
	
	function ShowMultimedia(path){
		var multiContent = "<model-viewer src='" + path + "' camera-controls ar ar-modes='scene-viewer webxr quick-look' style='position:absolute; top: 100px; z-index: 1000; width: 600px; height: 300px;'></model-viewer>";
		$("#multimedia-container").html(multiContent);
		
	}
	
	function saveExhibit(exhibitName,exDescription,exibitionId,xPosVar,yPosVar,zPosVar,xOrVar,yOrVar,zOrVar,wOrVar){
		var fd = new FormData();
		fd.append('exhibit_name', exhibitName);
		fd.append('exhibit_description', exDescription);

		fd.append('exhibition_id', exibitionId);
		fd.append('exhibit_location_x', xPosVar);
		fd.append('exhibit_location_y', yPosVar);
		fd.append('exhibit_location_z', zPosVar);
		fd.append('exhibit_heading_x', xOrVar);
		fd.append('exhibit_heading_y', yOrVar);
		fd.append('exhibit_heading_z', zOrVar);
		fd.append('exhibit_heading_w', wOrVar);	
	

		$.ajax({
			url:"./controller/saveExhibitController.php",
			method:"post",
			data:fd,
			processData: false,
			contentType: false,
			success: function(response){
				var data = $.parseJSON(response);
				$(".return-message").css("display", "inline-block");
				$(".return-message").css("color", "#2BC82B");
				$('.return-message').html('New exhibit inserted');
				setTimeout(function() {
					// Router('exhibits');
					$('.return-message').html("");
					$(".return-message").css("display", "none");
				}, 2000);
			},
			error: function(xhr, status, error) {
				var result = JSON.parse(xhr.responseText);
				if(xhr.status==401){
					window.location.href="signin.php"; //session expired
				}else if(xhr.status==402){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else if(xhr.status==403){
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}else {
					$(".return-message").css("display", "inline-block");
					$(".return-message").css("color", "#ff0000");
					$('.return-message').html(result.message);
				}
			}
		});
	}
	