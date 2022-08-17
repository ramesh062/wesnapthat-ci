<?php
// echo "<pre>";
// print_r($doctors);exit;
include 'includes/header.php';
?>
<div class="doctor_appo_detail main_div">
	<?php echo form_open('',array("id" => "add_doctor","name" => "add_doctor","onsubmit"=>"return false")); ?>
			<label>Full Name</label><br>
			<input type="text" name="fullname" id="fullname" value="<?php echo $doctors->fullname; ?>"><br>
			<label>Email</label><br>
			<input type="text" name="email" id="email" value="<?php echo $doctors->email; ?>"><br>
			<label>Qualification</label><br>
			<input type="text" name="qualification" id="qualification" value="<?php echo $doctors->qualification; ?>"><br>
			<label>Speciality</label><br>
			<input type="text" name="speciality" id="speciality" value="<?php echo $doctors->speciality; ?>"><br>
			<label>Experience</label><br>
			<input type="text" name="experience" id="experience" value="<?php echo $doctors->experience; ?>"><br>
			<label>Gender</label><br>
			<input type="radio" name="gender" id="male" value="male" <?php if($doctors->gender == "male") echo "checked"; ?> >Male&nbsp
			<input type="radio" name="gender" id="female" value="female" <?php if($doctors->gender == "female") echo "checked"; ?>>Female<br>
			<label>Consultation Charges</label><br>
			<input type="text" name="consultation_charges" id="consultation_charges" value="<?php echo $doctors->consultation_charges; ?>"><br>
			<label>Profile Photo</label><br>
			<input type="file" name="profile_image" id="profile_image"><br>

			<label>Appointment Time Slots</label><br>
			<input type="radio" name="appointment_time_slots" value="10" <?php if($doctors->appointment_time_slots == "10") echo "checked"; ?>> 10 min &nbsp
			<input type="radio" name="appointment_time_slots" value="15" <?php if($doctors->appointment_time_slots == "15") echo "checked"; ?>> 15 min &nbsp
			<input type="radio" name="appointment_time_slots" value="20" <?php if($doctors->appointment_time_slots == "20") echo "checked"; ?>> 20 min &nbsp<br>
			<input type="radio" name="appointment_time_slots" value="30" <?php if($doctors->appointment_time_slots == "30") echo "checked"; ?>> 30 min &nbsp
			<input type="radio" name="appointment_time_slots" value="45" <?php if($doctors->appointment_time_slots == "45") echo "checked"; ?>> 45 min &nbsp
			<input type="radio" name="appointment_time_slots" value="60" <?php if($doctors->appointment_time_slots == "60") echo "checked"; ?>> 1 hr <br>
			    
		    <label> Consultation Hours</label>
		    <div class="time_sub_heading">The consultation hours you prefer during the day. You can add more than one slots.</div> 
            <div id="consultation">
            	<?php
            	    foreach ($consultation_time as $key => $each) { 
            	?>
            	<div class="time_selection" >
            	    <div class="custom_timing" >
            	        <select class="select_time" name="from_hour[]">
            	           <option value="01" <?php if($each['from_hour'] == '01') echo "selected"; ?>>01</option>
            	           <option value="02" <?php if($each['from_hour'] == '02') echo "selected"; ?>>02</option>
            	           <option value="03" <?php if($each['from_hour'] == '03') echo "selected"; ?>>03</option>
            	           <option value="04" <?php if($each['from_hour'] == '04') echo "selected"; ?>>04</option>
            	           <option value="05" <?php if($each['from_hour'] == '05') echo "selected"; ?>>05</option>
            	           <option value="06" <?php if($each['from_hour'] == '06') echo "selected"; ?>>06</option>
            	           <option value="07" <?php if($each['from_hour'] == '07') echo "selected"; ?>>07</option>
            	           <option value="08" <?php if($each['from_hour'] == '08') echo "selected"; ?>>08</option>
            	           <option value="09" <?php if($each['from_hour'] == '09') echo "selected"; ?>>09</option>
            	           <option value="10" <?php if($each['from_hour'] == '10') echo "selected"; ?>>10</option>
            	           <option value="11" <?php if($each['from_hour'] == '11') echo "selected"; ?>>11</option>
            	           <option value="12" <?php if($each['from_hour'] == '12') echo "selected"; ?>>12</option>
            	        </select>
            	        <select class="select_time" name="from_min[]">
            	          <option value="00" <?php if($each['from_min'] == '00') echo "selected"; ?>>00</option>
            	          <option value="05" <?php if($each['from_min'] == '05') echo "selected"; ?>>05</option>
            	          <option value="10" <?php if($each['from_min'] == '10') echo "selected"; ?>>10</option>
            	          <option value="15" <?php if($each['from_min'] == '15') echo "selected"; ?>>15</option>
            	          <option value="20" <?php if($each['from_min'] == '20') echo "selected"; ?>>20</option>
            	          <option value="25" <?php if($each['from_min'] == '25') echo "selected"; ?>>25</option>
            	          <option value="30" <?php if($each['from_min'] == '30') echo "selected"; ?>>30</option>
            	          <option value="35" <?php if($each['from_min'] == '35') echo "selected"; ?>>35</option>
            	          <option value="40" <?php if($each['from_min'] == '40') echo "selected"; ?>>40</option>
            	          <option value="45" <?php if($each['from_min'] == '45') echo "selected"; ?>>45</option>
            	          <option value="50" <?php if($each['from_min'] == '50') echo "selected"; ?>>50</option>
            	          <option value="55" <?php if($each['from_min'] == '55') echo "selected"; ?>>55</option>
            	          <option value="60" <?php if($each['from_min'] == '60') echo "selected"; ?>>60</option>
            	        </select>
            	        <select class="select_time" name="from_type[]">
            	           <option value="am" <?php if($each['from_type'] == 'am') echo "selected"; ?>>AM</option>
            	           <option value="pm" <?php if($each['from_type'] == 'pm') echo "selected"; ?>>PM</option>
            	        </select>
            	    </div>
            	    To &nbsp&nbsp&nbsp&nbsp&nbsp
            	    <div class="custom_timing" >
            	        <select class="select_time" name="to_hour[]">
            	           <option value="01" <?php if($each['to_hour'] == '01') echo "selected"; ?>>01</option>
            	           <option value="02" <?php if($each['to_hour'] == '02') echo "selected"; ?>>02</option>
            	           <option value="03" <?php if($each['to_hour'] == '03') echo "selected"; ?>>03</option>
            	           <option value="04" <?php if($each['to_hour'] == '04') echo "selected"; ?>>04</option>
            	           <option value="05" <?php if($each['to_hour'] == '05') echo "selected"; ?>>05</option>
            	           <option value="06" <?php if($each['to_hour'] == '06') echo "selected"; ?>>06</option>
            	           <option value="07" <?php if($each['to_hour'] == '07') echo "selected"; ?>>07</option>
            	           <option value="08" <?php if($each['to_hour'] == '08') echo "selected"; ?>>08</option>
            	           <option value="09" <?php if($each['to_hour'] == '09') echo "selected"; ?>>09</option>
            	           <option value="10" <?php if($each['to_hour'] == '10') echo "selected"; ?>>10</option>
            	           <option value="11" <?php if($each['to_hour'] == '11') echo "selected"; ?>>11</option>
            	           <option value="12" <?php if($each['to_hour'] == '12') echo "selected"; ?>>12</option>
            	        </select>
            	        <select class="select_time" name="to_min[]">
            	           <option value="00" <?php if($each['to_min'] == '00') echo "selected"; ?>>00</option>
            	          <option value="05" <?php if($each['to_min'] == '05') echo "selected"; ?>>05</option>
            	          <option value="10" <?php if($each['to_min'] == '10') echo "selected"; ?>>10</option>
            	          <option value="15" <?php if($each['to_min'] == '15') echo "selected"; ?>>15</option>
            	          <option value="20" <?php if($each['to_min'] == '20') echo "selected"; ?>>20</option>
            	          <option value="25" <?php if($each['to_min'] == '25') echo "selected"; ?>>25</option>
            	          <option value="30" <?php if($each['to_min'] == '30') echo "selected"; ?>>30</option>
            	          <option value="35" <?php if($each['to_min'] == '35') echo "selected"; ?>>35</option>
            	          <option value="40" <?php if($each['to_min'] == '40') echo "selected"; ?>>40</option>
            	          <option value="45" <?php if($each['to_min'] == '45') echo "selected"; ?>>45</option>
            	          <option value="50" <?php if($each['to_min'] == '50') echo "selected"; ?>>50</option>
            	          <option value="55" <?php if($each['to_min'] == '55') echo "selected"; ?>>55</option>
            	          <option value="60" <?php if($each['to_min'] == '60') echo "selected"; ?>>60</option>
            	        </select>
            	        <select class="select_time" name="to_type[]">
            	           <option value="am" <?php if($each['to_type'] == 'am') echo "selected"; ?>>AM</option>
            	           <option value="pm" <?php if($each['to_type'] == 'pm') echo "selected"; ?>>PM</option>
            	        </select>
            	    </div>
            	    <a href="javascript:add_slot();" class="add_more">
            	        <span>+</span>
            	    </a><br>
            	</div>
            	<?php
            	    } 
            	?>
            </div>
			<?php 
				$mon = "";$tue = "";$wed = "";$thu = "";$fri = "";$sat = "";$sun = "";
				$weekly_off_days = explode(',', $doctors->weekly_off_days);
				foreach ($weekly_off_days as $each) {
					if($each == "mon"){
						$mon = "checked";
					}else if($each == "tue"){
						$tue = "checked";
					}else if($each == "wed"){
						$wed = "checked";
					}else if($each == "thu"){
						$thu = "checked";
					}else if($each == "fri"){
						$fri = "checked";
					}else if($each == "sat"){
						$sat = "checked";
					}else if($each == "sun"){
						$sun = "checked";
					}
				}
			?>
			<label>Weekly off Day(s)</label><br>
			<input type="checkbox" name="mon" id="mon" value="mon" <?php echo $mon; ?>> Mon &nbsp
			<input type="checkbox" name="tue" id="tue" value="tue" <?php echo $tue; ?>> Tue &nbsp
			<input type="checkbox" name="wed" id="wed" value="wed" <?php echo $wed; ?>> Wed &nbsp
			<input type="checkbox" name="thu" id="thu" value="thu" <?php echo $thu; ?>> Thu &nbsp<br>
			<input type="checkbox" name="fri" id="fri" value="fri" <?php echo $fri; ?>> Fri &nbsp
			<input type="checkbox" name="sat" id="sat" value="sat" <?php echo $sat; ?>> Sat &nbsp
			<input type="checkbox" name="sun" id="sun" value="sun" <?php echo $sun; ?>> Sun <br>
		    
			<label>Change Password</label><br>
			<input type="password" name="password" id="password"><br><br>
			<button type="submit" form="add_doctor" class="btn btn-info" onclick="edit_doctor_details(<?php echo $doctors->id; ?>)">Submit</button>
	<?php echo form_close(); ?>
</div>
<script>
	function edit_doctor_details(id){

		var off_days = [];
		var email 	 = $('#email').val();
		var password = $('#password').val();
	
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
		}else{

			var formData = new FormData(eval(document.add_doctor));
			formData.append('weekly_off_days',off_days);
			$.ajax({
				url: '<?php echo base_url('admin/doctors/add_doctor/'); ?>' + id,
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

