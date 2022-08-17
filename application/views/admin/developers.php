<?php include 'includes/header.php';?>
<section class="appoinment_part">
	<div class="new_appoinment">
		<div class="common_text">
			<div class="common_text_form">Developers</div>
			<div class="right_img"><img src="<?php echo SITE_IMAGES ?>building.svg"></div>
		</div>
		<div class="appoinment_form">
			<div class="custom_input_main">
				<div class="custom_input_box">
					<label class="input_label">Patient Onesignal</label>
					<div class="input_box">
						<input type="text" name="patient" id="patient" value="<?php echo $one_signals->patient; ?>" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Doctor Onesignal</label>
					<div class="input_box">
						<input type="text" name="doctor" id="doctor" value="<?php echo $one_signals->doctor; ?>" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Web Onesignal</label>
					<div class="input_box">
						<input type="text" name="web" id="web" value="<?php echo $one_signals->web; ?>" class="custom_input">
					</div>
				</div>
			</div>
		</div>
		<div class="btn_book">
			<a href="javascript:update();" class="common_button">
				<span>Submit</span>
			</a>
		</div>
	</div>
</section>

<?php include 'includes/footer.php';?>
<script>
	function update(){
		var patient  = $('#patient').val();
		var doctor   = $('#doctor').val();
		var web  = $('#web').val();
		
		if(patient == ""){
			swal('Patient Onesignal id required');
		}else if(doctor == ""){
			swal('Doctor Onesignal id required');
		}else if(web == ""){
			swal('Web Onesignal id required');
		}else{
			var sub_data = "";
			sub_data += '&patient=' + patient;
			sub_data += '&doctor=' + doctor;
			sub_data += '&web=' + web;
			
			$.ajax({
				url: '<?php echo base_url('admin/dashboard/update_onesignals'); ?>',
				type: 'POST',
				data: sub_data,
				dataType: 'JSON',
				success: function(response){
					if(response.status == 1){
						swal(response.message);
					}else{
						swal(response.message);
					}
				}
			})
		}

	}
</script>