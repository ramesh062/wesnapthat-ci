<?php
	include("includes/header.php");
?>
<section class="appoinment_part">
	<div class="new_appoinment">
		<div class="main_heading_text">
			<div class="common_text_title fbold"><?php echo $admin->hospital_name; ?></div>
			<span class="sub_common_text">Now not to wait at hospital, Book appointment with your doctor at your feasible time!</span>
		</div>
		<div class="common_text">
			<div class="common_text_form">New Appointment</div>
			<div class="right_img"><img src="<?php echo SITE_IMAGES ?>building.svg"></div>
		</div>
		<div class="appoinment_form">
			<div class="custom_input_main">
				<div class="custom_input_box">
					<label class="input_label">Full Name</label>
					<div class="input_box with_icon">
						<!-- <div class="input_icon">
							<img src="<?php echo SITE_IMAGES ?>mail.svg">
						</div> -->
						<input type="text" name="fullname" id="fullname" placeholder="Patient’s Full Name" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Age</label>
					<div class="input_box with_icon">
						<!-- <div class="input_icon">
							<img src="<?php echo SITE_IMAGES ?>mail.svg">
						</div> -->
						<input type="number" name="age" id="age" placeholder="" class="custom_input" min="1">
						<span>Years</span>
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Mobile Number</label>
					<div class="input_box with_icon">
						<!-- <div class="input_icon">
							<img src="<?php echo SITE_IMAGES ?>mail.svg">
						</div> -->
						<input type="tel" id="mobile" class="custom_input" name="mobile" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" placeholder="Enter Mobile Number">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Email Address</label>
					<div class="input_box with_icon">
						<!-- <div class="input_icon">
							<img src="<?php echo SITE_IMAGES ?>mail.svg">
						</div> -->
						<input type="text" name="email" id="email" placeholder="e.g. johnsmith@email.com" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box ">
					<label class="input_label">Select Gender</label>
					<div class="option_menu">
						<div class="input_box with_icon select_option">
							<input type="radio" id="male" name="gender" value="male" checked>
							<label class="radio_main" for="male">
								<div class="input_icon">
									<img src="<?php echo SITE_IMAGES ?>gender_one.svg">
								</div>
								<span class="gender_select">Male</span>
							</label>
						</div>
						<div class="input_box with_icon select_option">
							<input type="radio" id="female" name="gender" value="female">
							<label class="radio_main" for="female">
								<div class="input_icon">
									<img src="<?php echo SITE_IMAGES ?>gender_two.svg">
								</div>
								<span class="gender_select">Female</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="doctor_detail appoinment_form">
			<div class="custom_input_main ">
				<div class="custom_input_box w_full">
					<label class="input_label">Doctor's Name</label>
					<div class="input_box">					
						<select name="doctor_id" id="doctor_id" class="" onchange="get_doctor_date();get_doctor_time();">
						  	  <option value="">- Select Your Doctor -</option>
						  <?php foreach ($doctors as $key => $doctor) { ?>
						  	  <option value="<?php echo $doctor['id']; ?>" <?php if(isset($doctor_id) && $doctor_id != "" && $doctor_id == $doctor['id']) echo "selected"; ?> ><?php echo "Dr. ".$doctor['fullname']; ?></option>
						  <?php } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="custom_input_main ">
				<div class="custom_input_box">
					<label class="input_label">Date</label>
					<div class="input_box with_icon">
						<div class="input_icon">
							<img src="<?php echo SITE_IMAGES ?>calendar_color.svg">
						</div>
						<input type="date" name="date" id="date" min="<?php echo date('Y-m-d'); ?>" placeholder="date" class="custom_input" onchange="get_doctor_date();get_doctor_time();">
					</div>
				</div>
				<div class="custom_input_box">
					<div class="custom_input_main ">
						<div class="custom_input_box w_full space_remove">
							<label class="input_label">Time</label>
							<div class="input_box">	
								<div class="input_icon">
									<img src="<?php echo SITE_IMAGES ?>clock_color.svg">
								</div>
								<select id="time_slots">
								</select>
								<!-- <input id="timerange" type="text" class="text-center ui-timepicker-input" autocomplete="off" > --><!-- 			
								<input class="timepicker text-center" id="time" name="time" readonly="true"> -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="custom_input_main ">
				<div class="custom_input_box w_full">
					<label class="input_label">Note</label>
					<div class="input_box with_icon">
						<textarea placeholder="Write some details about your current health status." class="custom_input" rows="5" style="resize:none" id="note" name="note"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="btn_book">
		<a href="javascript:add_appointment();" class="common_button">
			<span>Book Appoinment</span>
		</a>
		</div>
	</div>
	
</section>

<?php include("includes/footer.php"); ?>
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css" integrity="sha512-GgUcFJ5lgRdt/8m5A0d0qEnsoi8cDoF0d6q+RirBPtL423Qsj5cI9OxQ5hWvPi5jjvTLM/YhaaFuIeWCLi6lyQ==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.css" integrity="sha512-GgUcFJ5lgRdt/8m5A0d0qEnsoi8cDoF0d6q+RirBPtL423Qsj5cI9OxQ5hWvPi5jjvTLM/YhaaFuIeWCLi6lyQ==" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.js" integrity="sha512-17lKwKi7MLRVxOz4ttjSYkwp92tbZNNr2iFyEd22hSZpQr/OnPopmgH8ayN4kkSqHlqMmefHmQU43sjeJDWGKg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js" integrity="sha512-WHnaxy6FscGMvbIB5EgmjW71v5BCQyz5kQTcZ5iMxann3HczLlBHH5PQk7030XmmK5siar66qzY+EJxKHZTPEQ==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="<?php echo SITE_CSS?>intlTelInput.min.css"/>
<script src="<?php echo SITE_JS?>intlTelInput.min.js"></script>
<script>
	var iti="";
 	function get_doctor_time(){
     	var doctor_id = $('#doctor_id').val();
     	var date      = $('#date').val();

     	var sub_data = "";
     	sub_data += '&doctor_id=' + doctor_id;
     	sub_data += '&date=' + date;
     	
     	$.ajax({
     		url: '<?php echo base_url('appointment_booking/get_doctor_time'); ?>',
     		type: 'POST',
     		data: sub_data,
     		dataType: 'JSON',
     		success: function(response){
     			if(response.status == 1){
     				$('#time_slots option').remove();
     				var data = response.data;
     				$('#time_slots').append(`<option value=""> - Select Time - </option>`);
     				for(var i = 0; i < data.time.length; i++){
     					$('#time_slots').append(`
     					<option value="`+ data.time[i] +`" >`+ data.time[i] +`</option>
     					`);

     					for(var j = 0; j < data.appntmt.length; j++) {
     						if(data.time[i] == data.appntmt[j]){
     							$("option[value='"+data.time[i]+"']").attr("disabled", "disabled");

     						}
     					}
     				}
     				//initialize_timepicker(data.time);
     			}
     		}
     	})
     }

     function get_doctor_date(){
     	var date      = $('#date').val();
     	var doctor_id = $('#doctor_id').val();

     	var sub_data = "";
     	sub_data += '&date=' + date;
     	sub_data += '&doctor_id=' + doctor_id;
     	
     	$.ajax({
     		url: '<?php echo base_url('appointment_booking/get_doctor_date'); ?>',
     		type: 'POST',
     		data: sub_data,
     		dataType: 'JSON',
     		success: function(response){
     			if(response.status == 0){
     				swal(response.message);
     				setTimeout(function() {
                    		$('#date').val("");
                  	}, 1000);
     			}
     		}
     	})
     }
	 $(".btn_book span").text("Book Appointment");
     function add_appointment(){
     	var fullname = $('#fullname').val();
     	var age      = $('#age').val();
     	var mobile   = $('#mobile').val();
     	var email    = $('#email').val();
     	var gender   = $('input[name="gender"]:checked').val();
     	var doctor_id = $('#doctor_id').val();
     	var time      = $('#time_slots').val();
     	var date      = $('#date').val();
     	var note      = $('#note').val();
     	
     	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

     	if(fullname == ""){
     		swal('Patient’s Full Name Required.');
     	}else if(age == ""){
     		swal('Age Required.');
     	}else if(mobile == ""){
     		swal('Mobile Required.');
     	}else if(email!="" && reg.test(email) == false){
 			swal('Please enter valid email address');
 		}else if(gender == ""){
     		swal('Gender Required.');
     	}else if(doctor_id == ""){
     		swal('Please select doctor.');
     	}else if(date == ""){
     		swal('Please select date.');
     	}else if(time == ""){
     		swal('Please select time.');
     	}else{
     		var sub_data = "";
			countryCode = iti.getSelectedCountryData();
			countryCode=countryCode.dialCode?"+"+countryCode.dialCode:"+1";
     		sub_data += '&fullname=' + fullname;
     		sub_data += '&age=' + age;
     		sub_data += '&mobile=' + mobile;
     		sub_data += '&email=' + email;
     		sub_data += '&gender=' + gender;
     		sub_data += '&doctor_id=' + doctor_id;
     		sub_data += '&time=' + time;
     		sub_data += '&date=' + date;
     		sub_data += '&note=' + note;
			sub_data += '&countrycode='+countryCode;
			
     		$.ajax({
     			url: '<?php echo base_url('appointment_booking/add_new_appointment'); ?>',
     			type: 'POST',
     			data: sub_data,
     			dataType: 'JSON',
				beforeSend:function(){
					$(".btn_book span").html("Waiting... <div class='spinner-border spinner-border-sm' role='status'><span class='sr-only'>Loading...</span></div>");  				},
     			success: function(response){
     				if(response.status == 1){
  						$('#fullname').val("");
  						$('#age').val("");
  						$('#mobile').val("");
  						$('#email').val("");
  						$('#doctor_id').val("");
  						$('#time_slots').val("");
  						$('#date').val("");
  						$('#note').val("");
  						
     					swal(response.message);	
     					setTimeout(function() {
                        		window.location = "<?php echo base_url('appointment_booking/booked_appointment/'); ?>" + response.data;
                      	}, 1000);
     				}else{
     					swal(response.message);
     				}
					 $(".btn_book span").html("Book Appointment");
     			},
				error:function(){
					$(".btn_book span").html("Book Appointment");
				}
     		})
     	}
     }
	 
	 $(document).ready(function(){
		var input = document.querySelector("#mobile");
		iti=window.intlTelInput(input, {
			separateDialCode: true,
			// preferredCountries:["in"],
			hiddenInput: "full",
			utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
		});
		
		 $('#timerange').timepicker({
		 	'timeFormat': 'h:i A',
		 	'disableTextInput': true,
		 	'step': 30,
		 	'listWidth': 1
		 });

	 });
	 
	 $('#timerange').on('change', function (){
	 	get_apptmnt();
	 	get_doctor_consultation_hours();
	 });

	function get_appointments_bydate(){
		var doctor_id = $('#doctor_id').val();
		var date      = $('#date').val();

		var sub_data = "";
		sub_data += '&date=' + date;
		sub_data += '&doctor_id=' + doctor_id;
		
		$.ajax({
			url: '<?php echo base_url('appointment_booking/get_apptmnt_bydate'); ?>',
			type: 'POST',
			data: sub_data,
			dataType: 'JSON',
			success: function(response){
				if(response.status == 1){
        			$("#timerange").timepicker('option', 'disableTimeRanges', response.data);
				}
			}
		})
	 }
	 // $(document).ready(function(){
	 // 	$('input.timepicker').timepicker({
  //         timeFormat: 'hh:mm p',
  //         defaultTime: '',
  //         step: 30,
  //         dynamic: true,
  //         dropdown: true,
  //         scrollbar: false,
  //         change: onchange_timepicker,
  //         // disabledHours: [1,4,9],
  //         disableTimeRanges: [
  //         	['1am', '2am'],
		// 	['3am', '4:01am']
  //         	//['04:30 AM', '05:00 AM'],
  //         	// ['8:30pm', '9:05pm'],
  //         	// ['9:30am', '10:05am'],
  //         	// ['10:00am', '10:35am']
  //         ]
  //       });
	 // });

	// function onchange_timepicker(){
	//  	get_apptmnt();
	//  	get_doctor_consultation_hours();
	// }

 	function get_apptmnt(){
 	 	
  		var time      = $('#timerange').val();
  		var doctor_id = $('#doctor_id').val();
  		var date      = $('#date').val();

  		var sub_data = "";
  		sub_data += '&time=' + time;
  		sub_data += '&date=' + date;
  		sub_data += '&doctor_id=' + doctor_id;
  		
  		$.ajax({
  			url: '<?php echo base_url('appointment_booking/get_apptmnt'); ?>',
  			type: 'POST',
  			data: sub_data,
  			dataType: 'JSON',
  			success: function(response){
  				if(response.status == 0){
  					swal(response.message);
  					setTimeout(function() {
  	               		$('#timerange').val("");
  	             	}, 1000);
  				}
  			}
  		})
 	}

	
	function initialize_timepicker(intrvl){
        var picker = $("#timerange");
        picker.timepicker('option', 'step', intrvl);
    }

    function get_doctor_consultation_hours(){
		var time      = $('#timerange').val();
		var doctor_id = $('#doctor_id').val();

		var sub_data = "";
		sub_data += '&time=' + time;
		sub_data += '&doctor_id=' + doctor_id;
		
		$.ajax({
			url: '<?php echo base_url('appointment_booking/get_doctor_consultation_hours'); ?>',
			type: 'POST',
			data: sub_data,
			dataType: 'JSON',
			success: function(response){
				if(response.status == 0){
					console.log(response.message);
					swal(response.message);
					setTimeout(function() {
	               		$('#timerange').val("");
	             	}, 1000);
				}
			}
		})	
    }


</script>
