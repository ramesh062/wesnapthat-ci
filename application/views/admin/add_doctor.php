<?php include 'includes/header.php';?>

<section class="appoinment_part">
	<div class="new_appoinment">
		<div class="common_text">
			<div class="common_text_form">Add Doctor</div>
			<div class="right_img"><img src="<?php echo SITE_IMAGES ?>building.svg"></div>
		</div>
		<div class="appoinment_form">
			<?php echo form_open('',array("id" => "add_doctor","name" => "add_doctor","onsubmit"=>"return false")); ?>
			<div class="custom_input_main">
				<div class="custom_input_box">
					<label class="input_label">Full Name</label>
					<div class="input_box">
						<input type="text" name="fullname" id="fullname" placeholder="Doctor’s Full Name" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Email</label>
					<div class="input_box">
						<input type="text" name="email" id="email" placeholder="e.g. johnsmith@email.com" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Qualification</label>
					<div class="input_box">
						<input type="text" name="qualification" id="qualification" placeholder="Qualification" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Speciality</label>
					<div class="input_box">
						<input type="text" name="speciality" id="speciality" placeholder="Speciality" class="custom_input">
					</div>
				</div>
			    <div class="custom_input_box">
					<label class="input_label">Experiance (In year)</label>
					<div class="input_box">
						<input type="number" name="experience" id="experience" placeholder="Experiance" class="custom_input" min="1" step="0.5">
					</div>
				</div>
				<div class="custom_input_box ">
					<label class="input_label">Select Gender</label>
					<div class="option_menu">
						<div class="input_box select_option">
							<input type="radio" id="male" name="gender" value="male" checked>
							<label class="radio_main" for="male">
								<div class="input_icon">
									<img src="<?php echo SITE_IMAGES ?>gender_one.svg">
								</div>
								<span class="gender_select">Male</span>
							</label>
						</div>
						<div class="input_box select_option">
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
				<div class="custom_input_box">
					<label class="input_label">Consultation Charges</label>
					<div class="input_box">
						<input type="text" name="consultation_charges" id="consultation_charges" placeholder="Consultation Charges" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box ">
					<label class="input_label">Profile photo</label>
					<div class="input_box remove_space">
						<input type="file" name="profile_image" id="profile_image" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box w_full">
					<label class="input_label">Appoinment Time Slot</label>
					<div class="option_menu timer_select">
						<div class="input_box select_option">
							<input type="radio" id="10_min" name="appointment_time_slots" value="10" checked>
							<label class="radio_main" for="10_min">
								<span class="gender_select">10 min</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="radio" id="15_min" name="appointment_time_slots" value="15">
							<label class="radio_main" for="15_min">
								<span class="gender_select">15 min</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="radio" id="20_min" name="appointment_time_slots" value="20">
							<label class="radio_main" for="20_min">
								<span class="gender_select">20 min</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="radio" id="30_min" name="appointment_time_slots" value="30">
							<label class="radio_main" for="30_min">
								<span class="gender_select">30 min</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="radio" id="45_min" name="appointment_time_slots" value="45">
							<label class="radio_main" for="45_min">
								<span class="gender_select">45 min</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="radio" id="1_hour" name="appointment_time_slots" value="60">
							<label class="radio_main" for="1_hour">
								<span class="gender_select">1 hour</span>
							</label>
						</div>
					</div>
				</div>
					
				<div class="custom_input_box w_full">
					<label class="input_label">Consultation Hours</label>
					<span class="extra_text">The consultation hours you prefer during the day. You can add more than one slots.</span>
					<div id="consultation">
						<div class="d-flex align-items-center justify-content-between" id="div_0">
							<div class="input_box time_input_box">
								<input class="timepicker text-center" name="from_time[]" readonly="true" id="from_0">
							</div>
							<span class="between_word"> To </span> 
							<div class="input_box time_input_box">
								<input class="timepicker text-center" name="to_time[]" readonly="true" id="to_0">
							</div>
							<a href="javascript:add_slot();" class="add_more" id="plus_0">
							    <span>+</span>
							</a>
							<a href="javascript:remove_slot(0);" class="add_more" style="display: none;" id="minus_0">
							   <span>-</span>
							</a>
						</div>
						<span class="extra_text" name="errors[]" style="display: none;">Please select valid start and end time.</span><br>
					</div>
				</div>

				<div class="custom_input_box w_full">
					<label class="input_label">Weekly off Days(s)</label>
					<div class="option_menu week_select">
						<div class="input_box select_option">
							<input type="checkbox" name="mon" id="mon" value="mon" checked>
							<label class="radio_main" for="mon">
								<span class="gender_select">Monday</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="checkbox" name="tue" id="tue" value="tue">
							<label class="radio_main" for="tue">
								<span class="gender_select">Tuesday</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="checkbox" name="wed" id="wed" value="wed">
							<label class="radio_main" for="wed">
								<span class="gender_select">Wednesday</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="checkbox" name="thu" id="thu" value="thu">
							<label class="radio_main" for="thu">
								<span class="gender_select">Thursday</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="checkbox" name="fri" id="fri" value="fri">
							<label class="radio_main" for="fri">
								<span class="gender_select">Friday</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="checkbox" name="sat" id="sat" value="sat">
							<label class="radio_main" for="sat">
								<span class="gender_select">Saturday</span>
							</label>
						</div>
						<div class="input_box select_option">
							<input type="checkbox" name="sun" id="sun" value="sun">
							<label class="radio_main" for="Sunday">
								<span class="gender_select">Sunday</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="custom_input_main">
				<div class="custom_input_box">
					<label class="input_label">Password</label>
					<div class="input_box">
						<input type="password" name="password" id="password" placeholder="Password" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Mobile</label>
					<div class="input_box">
						<input type="hidden" name="countrycode" id="countrycode" value=""/> 
						<input type="text" name="mobile" id="mobile" placeholder="Enter mobile number" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Address 1</label>
					<div class="input_box">
						<input type="text" name="address1" id="address1" placeholder="Enter address 1" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Address 2</label>
					<div class="input_box">
						<input type="text" name="address2" id="address2" placeholder="Enter address 2" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Town</label>
					<div class="input_box">
						<input type="text" name="town" id="town" placeholder="Enter town" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">City</label>
					<div class="input_box">
						<input type="text" name="city" id="city" placeholder="Enter city" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Country</label>
					<div class="input_box">
						<input type="text" name="country" id="country" placeholder="Enter country" class="custom_input">
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
		<div class="btn_book">
		<a href="javascript:new_doctor();" class="common_button">
			<span>Submit</span>
		</a>
		</div>
	</div>
	
</section>

<?php include 'includes/footer.php';?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo SITE_CSS?>intlTelInput.min.css"/>
<script src="<?php echo SITE_JS?>intlTelInput.min.js"></script> 

<script>
  var count = 0;
  var iti="";
  $(document).ready(function(){
    initialize_timepicker();
	var input = document.querySelector("#mobile");
	iti=window.intlTelInput(input, {
		separateDialCode: true,
  		// preferredCountries:["in"],
  		hiddenInput: "full",
  		utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
	});
  });

  function add_slot(){
  	$('#plus_' + count).hide();
  	$('#minus_' + count).show();

  	count += 1;
    var html = `<div class="d-flex align-items-center justify-content-between" id="div_`+ count +`">
					<div class="input_box time_input_box">
						<input class="timepicker text-center" name="from_time[]" readonly="true" id="from_`+ count +`">
					</div>
					<span class="between_word"> To </span> 
					<div class="input_box time_input_box">
						<input class="timepicker text-center" name="to_time[]" readonly="true" id="to_`+ count +`">
					</div>
					<a href="javascript:add_slot();" class="add_more" id="plus_`+ count +`">
					    <span>+</span>
					</a>
					<a href="javascript:remove_slot(`+ count +`);" class="add_more" style="display: none;" id="minus_`+ count +`">
					   <span>-</span>
					</a>
				</div>
				<span class="extra_text" name="errors[]" style="display: none;">Please select valid start and end time.</span><br>`;
    $('#consultation').append(html);
    initialize_timepicker();
  }
  
  function remove_slot(count){
    var from = $("#from_" + count).val();
    var to   = $("#to_" + count).val();

    if(from == "" && to == ""){
      $("#div_" + count).remove();
    }else{
      swal({
            title: "Are you sure?",
            icon: "warning",
            buttons: [
              'No, cancel it!',
              'Yes, I am sure!'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
              $("#div_" + count).remove();
            }
          })
    }
  }

  function initialize_timepicker() {
    $('input.timepicker').timepicker({
      timeFormat: 'hh:mm p',
      defaultTime: '',
      interval: 30,
      dynamic: true,
      dropdown: true,
      scrollbar: false
    });
  }

  function GetFormattedTime(input) {

    var time  = input;
    var hours = Number(time.match(/^(\d+)/)[1]);
    var minutes = Number(time.match(/:(\d+)/)[1]);
    var AMPM = time.match(/\s(.*)$/)[1];
    if(AMPM == "PM" && hours<12) hours = hours+12;
    if(AMPM == "AM" && hours==12) hours = hours-12;
    var sHours = hours.toString();
    var sMinutes = minutes.toString();
    if(hours<10) sHours = "0" + sHours;
    if(minutes<10) sMinutes = "0" + sMinutes;

    return sHours + ":" + sMinutes;
  }

	function new_doctor(){

		var off_days = [];
		var email 	 = $('#email').val();
		var password = $('#password').val();
	    var valid      = true;
	    var input1     = document.getElementsByName('from_time[]'); 
	    var input2     = document.getElementsByName('to_time[]'); 
	    var errors     = document.getElementsByName('errors[]');
	    
	    for (var i = 0; i < input1.length; i++) { 
	        var from = input1[i].value;
	        var to   = input2[i].value;
	        
	        if(from == ''){
	           valid = false;break;
	        }else if(to == ''){
	           valid = false;break;
	        }else{
	           valid = true;
	           var from_time = GetFormattedTime(input1[i].value);
	           var to_time   = GetFormattedTime(input2[i].value);
	         
	           if(i > 0){
	             var last_to_time = GetFormattedTime(input2[i-1].value);
	             if(from_time < last_to_time){
	                errors[i].style.display = "block";return;
	             }  
	           }

	           if(to_time < from_time){
	              errors[i].style.display = "block";return;
	           }else if(to_time == from_time){
	              errors[i].style.display = "block";return;
	           }else{
	              errors[i].style.display = "none";
	           }
	        } 
	    }  

		var days = ['mon','tue','wed','thu','fri','sat','sun'];
		for(i=0;i<days.length;i++){
			if($('#' + days[i]).is(":checked")){
				off_days.push(days[i]);
			}	
		}
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

		if($('#fullname').val() == ''){
			swal('Full Name required');
		}else if(email == ''){
			swal('Email required');
		}else if(reg.test(email) == false){
			swal('Please enter valid email address');
		}else if($('#qualification').val() == ''){
			swal('Qualification required');
		}else if($('#speciality').val() == ''){
			swal('speciality required');
		}else if($('#consultation_charges').val() == ''){
			swal('Consultation charges required');
		}else if(valid == false){
     	    swal("Please Select Consultation Hours..");
    	}else if(password == ''){
			swal('Password required');
		}else if($("#mobile").val()==''){
			swal('Mobile required');
		}
		else if($('#address1').val() == ''){
			swal('Address 1 required');
		}
		else if($('#town').val() == ''){
			swal('Town required');
		}
		else if($('#city').val() == ''){
			swal('City required');
		}
		else if($('#country').val() == ''){
			swal('Country required');
		}
		else{
			var countryCode = iti.getSelectedCountryData();
			if(countryCode.dialCode)
				$("#countrycode").val("+"+countryCode.dialCode);
			
			var formData = new FormData(eval(document.add_doctor));
			formData.append('weekly_off_days',off_days);
			$.ajax({
				url: '<?php echo base_url('admin/doctors/add_doctor'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'JSON',
				processData: false,
				contentType: false,
				beforeSend:function(){
					$(".common_button span").html("Waiting... <div class='spinner-border spinner-border-sm' role='status'><span class='sr-only'>Loading...</span></div>"); 
				},
				success: function(response){
					if(response.status == 1){
						swal(response.message);
						setTimeout(function() {
                       		window.location = '<?php echo base_url('admin/doctors/index');?>';
                     	}, 1000);
					}else{
						swal(response.message);
					}
					$(".common_button span").html("Submit");
				},
				error:function(){
					$(".common_button span").html("Submit");
				}
			});
		}
	}

</script>


