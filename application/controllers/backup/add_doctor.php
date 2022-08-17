<?php include 'includes/header.php';?>
<div class="doctor_appo_detail main_div">
	<?php echo form_open('',array("id" => "add_doctor","name" => "add_doctor","onsubmit"=>"return false")); ?>
			<label>Full Name</label><br>
			<input type="text" name="fullname" id="fullname"><br>
			<label>Email</label><br>
			<input type="text" name="email" id="email"><br>
			<label>Qualification</label><br>
			<input type="text" name="qualification" id="qualification"><br>
			<label>Speciality</label><br>
			<input type="text" name="speciality" id="speciality"><br>
			<label>Experience</label><br>
			<input type="text" name="experience" id="experience"><br>
			<label>Gender</label><br>
			<input type="radio" name="gender" id="male" value="male" checked>Male&nbsp
			<input type="radio" name="gender" id="female" value="female">Female<br>
			<label>Consultation Charges</label><br>
			<input type="text" name="consultation_charges" id="consultation_charges"><br>
			<label>Profile Photo</label><br>
			<input type="file" name="profile_image" id="profile_image"><br>

			<label>Appointment Time Slots</label><br>
			<input type="radio" name="appointment_time_slots" value="10" checked> 10 min &nbsp
			<input type="radio" name="appointment_time_slots" value="15"> 15 min &nbsp
			<input type="radio" name="appointment_time_slots" value="20"> 20 min &nbsp<br>
			<input type="radio" name="appointment_time_slots" value="30"> 30 min &nbsp
			<input type="radio" name="appointment_time_slots" value="45"> 45 min &nbsp
			<input type="radio" name="appointment_time_slots" value="60"> 1 hr <br>
		    
		    <label> Consultation Hours</label>
		    <div class="time_sub_heading">The consultation hours you prefer during the day. You can add more than one slots.</div> 
		    
		    <div id="consultation">  
            	<div class="time_selection" >
                <div class="custom_timing" >
                  <select class="select_time" name="from_hour[]">
                     <option value="01">01</option>
                     <option value="02">02</option>
                     <option value="03">03</option>
                     <option value="04">04</option>
                     <option value="05">05</option>
                     <option value="06">06</option>
                     <option value="07">07</option>
                     <option value="08">08</option>
                     <option value="09">09</option>
                     <option value="10">10</option>
                     <option value="11">11</option>
                     <option value="12">12</option>
                  </select>
                  <select class="select_time" name="from_min[]">
                    <option value="00">00</option>
                    <option value="05">05</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                    <option value="35">35</option>
                    <option value="40">40</option>
                    <option value="45">45</option>
                    <option value="50">50</option>
                    <option value="55">55</option>
                    <option value="60">60</option>
                  </select>
                  <select class="select_time" name="from_type[]">
                     <option value="am">AM</option>
                     <option value="pm">PM</option>
                  </select>
              </div>
              To &nbsp&nbsp&nbsp&nbsp&nbsp
              <div class="custom_timing" >
                  <select class="select_time" name="to_hour[]">
                     <option value="01">01</option>
                     <option value="02">02</option>
                     <option value="03">03</option>
                     <option value="04">04</option>
                     <option value="05">05</option>
                     <option value="06">06</option>
                     <option value="07">07</option>
                     <option value="08">08</option>
                     <option value="09">09</option>
                     <option value="10">10</option>
                     <option value="11">11</option>
                     <option value="12">12</option>
                  </select>
                  <select class="select_time" name="to_min[]">
                     <option value="00">00</option>
                     <option value="05">05</option>
                     <option value="10">10</option>
                     <option value="15">15</option>
                     <option value="20">20</option>
                     <option value="25">25</option>
                     <option value="30">30</option>
                     <option value="35">35</option>
                     <option value="40">40</option>
                     <option value="45">45</option>
                     <option value="50">50</option>
                     <option value="55">55</option>
                     <option value="60">60</option>
                  </select>
                  <select class="select_time" name="to_type[]">
                     <option value="am">AM</option>
                     <option value="pm">PM</option>
                  </select>
              </div>
              <a href="javascript:add_slot();" class="add_more">
                  <span>+</span>
              </a><br></div>
            </div>
			
			<label>Weekly off Day(s)</label><br>
			<input type="checkbox" name="mon" id="mon" value="mon"> Mon &nbsp
			<input type="checkbox" name="tue" id="tue" value="tue"> Tue &nbsp
			<input type="checkbox" name="wed" id="wed" value="wed"> Wed &nbsp
			<input type="checkbox" name="thu" id="thu" value="thu"> Thu &nbsp<br>
			<input type="checkbox" name="fri" id="fri" value="fri"> Fri &nbsp
			<input type="checkbox" name="sat" id="sat" value="sat"> Sat &nbsp
			<input type="checkbox" name="sun" id="sun" value="sun"> Sun <br>
		    
			<label>Password</label><br>
			<input type="password" name="password" id="password"><br><br>
			<button type="submit" form="add_doctor" class="btn btn-info" onclick="new_doctor()">Submit</button>
	<?php echo form_close(); ?>
</div>
<script>
	function new_doctor(){

		//var valid  	 = true;
		var off_days = [];
		var email 	 = $('#email').val();
		var password = $('#password').val();
		
		// var input1   = document.getElementsByName('from_time[]'); 
		// var input2   = document.getElementsByName('to_time[]'); 
 
        // for (var i = 0; i < input1.length; i++) { 
        //     var a = input1[i]; 
        //     var from_time = a.value;
        //     if(from_time == ''){
        //     	valid = false;break;
        //     }else{
        //     	valid = true;
        //     } 
        // }	

        // for (var i = 0; i < input2.length; i++) { 
        //     var a = input2[i]; 
        //     var to_time = a.value;
        //     if(to_time == ''){
        //     	valid = false;break;
        //     }else{
        //     	valid = true;
        //     } 
        // }	
        
		var days = ['mon','tue','wed','thu','fri','sat','sun'];
		for(i=0;i<days.length;i++){
			if($('#' + days[i]).is(":checked")){
				off_days.push(days[i]);
			}	
		}

		if($('#fullname').val() == ''){
			swal('Full Name required');
		}else if(email == ''){
			swal('Email required');
		}else if($('#qualification').val() == ''){
			swal('Qualification required');
		}else if($('#speciality').val() == ''){
			swal('speciality required');
		}else if($('#consultation_charges').val() == ''){
			swal('Consultation charges required');
		}else if(password == ''){
			swal('Password required');
		}else{

			var formData = new FormData(eval(document.add_doctor));
			formData.append('weekly_off_days',off_days);
			$.ajax({
				url: '<?php echo base_url('admin/doctors/add_doctor'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'JSON',
				processData: false,
				contentType: false,
				success: function(response){
					if(response.status == 1){
						swal(response.message);
						setTimeout(function() {
                       		window.location = '<?php echo base_url('admin/doctors/index');?>';
                     	}, 1000);
					}else{
						swal(response.message);
					}
				}
			});
		}
	}

	function add_slot(){
		var html = `<div class="time_selection" >
                <div class="custom_timing" >
                  <select class="select_time" name="from_hour[]">
                     <option value="01">01</option>
                     <option value="02">02</option>
                     <option value="03">03</option>
                     <option value="04">04</option>
                     <option value="05">05</option>
                     <option value="06">06</option>
                     <option value="07">07</option>
                     <option value="08">08</option>
                     <option value="09">09</option>
                     <option value="10">10</option>
                     <option value="11">11</option>
                     <option value="12">12</option>
                  </select>
                  <select class="select_time" name="from_min[]">
                    <option value="00">00</option>
                    <option value="05">05</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                    <option value="35">35</option>
                    <option value="40">40</option>
                    <option value="45">45</option>
                    <option value="50">50</option>
                    <option value="55">55</option>
                    <option value="60">60</option>
                  </select>
                  <select class="select_time" name="from_type[]">
                     <option value="am">AM</option>
                     <option value="pm">PM</option>
                  </select>
              </div>
              To &nbsp&nbsp&nbsp&nbsp&nbsp
              <div class="custom_timing" >
                  <select class="select_time" name="to_hour[]">
                     <option value="01">01</option>
                     <option value="02">02</option>
                     <option value="03">03</option>
                     <option value="04">04</option>
                     <option value="05">05</option>
                     <option value="06">06</option>
                     <option value="07">07</option>
                     <option value="08">08</option>
                     <option value="09">09</option>
                     <option value="10">10</option>
                     <option value="11">11</option>
                     <option value="12">12</option>
                  </select>
                  <select class="select_time" name="to_min[]">
                     <option value="00">00</option>
                     <option value="05">05</option>
                     <option value="10">10</option>
                     <option value="15">15</option>
                     <option value="20">20</option>
                     <option value="25">25</option>
                     <option value="30">30</option>
                     <option value="35">35</option>
                     <option value="40">40</option>
                     <option value="45">45</option>
                     <option value="50">50</option>
                     <option value="55">55</option>
                     <option value="60">60</option>
                  </select>
                  <select class="select_time" name="to_type[]">
                     <option value="am">AM</option>
                     <option value="pm">PM</option>
                  </select>
              </div>
              <a href="javascript:add_slot();" class="add_more">
                  <span>+</span>
              </a><br></div>`;
        $('#consultation').append(html);
	}

</script>
<?php include 'includes/footer.php';?>

