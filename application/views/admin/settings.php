<?php include 'includes/header.php';?>
<section class="appoinment_part">
	<div class="new_appoinment">
		<div class="common_text">
			<div class="common_text_form">Settings</div>
			<div class="right_img"><img src="<?php echo SITE_IMAGES ?>building.svg"></div>
		</div>
		<div class="appoinment_form">
			<div class="custom_input_main">
				<div class="custom_input_box">
					<label class="input_label">Email</label>
					<div class="input_box">
						<input type="text" name="email" id="email" value="<?php echo $admin->email; ?>" placeholder="e.g. johnsmith@email.com" class="custom_input">
					</div>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Hospital Name</label>
					<div class="input_box">
						<input type="text" name="hospital_name" id="hospital_name" value="<?php echo $admin->hospital_name; ?>" placeholder="Hospital Name" class="custom_input">
					</div>
				</div>
				<div class="custom_input_main ">
					<div class="custom_input_box w_full">
						<label class="input_label">Address</label>
						<div class="input_box">
							<textarea  name="address" id="address" class="custom_input" rows="5" style="resize:none;border: 0;"><?php echo $admin->address; ?></textarea>
						</div>
					</div>
				</div>
				<div class="custom_input_box right_space">
					<div class="custom_input_box w_full">
						<label class="input_label">Hospital Phone Number</label>
						<div class="input_box">
							<input type="text" name="phone" id="phone" value="<?php echo $admin->phone; ?>" placeholder="+1-123-45678" class="custom_input">
						</div>
					</div>
				</div>
				<div class="custom_input_box right_space">
					<label class="input_label">Hospital currency </label>
					<div class="input_box">
						<select name="currency" id="currency">
							<option value=""> - Select option - </option>
							<?php foreach ($currency as $key => $each) { ?>
								<option value="<?php echo $each['id']; ?>" <?php  if($admin->currency == $each['id']) echo "selected";  ?> ><?php echo $each['name']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="custom_input_box right_space">
					<label class="input_label">Change Password</label>
					<div class="input_box">
						<input  type="password" name="password" id="password" placeholder="Leave blank if do not want to change it" class="custom_input">
					</div>
				</div>
			</div>
		</div>
		<div class="btn_book">
			<a href="javascript:update_admin();" class="common_button">
				<span>Submit</span>
			</a>
		</div>
	</div>
</section>
<!-- <div style="margin-left: 300px;margin-top: 100px;">
	<label>Email</label><br>
	<input type="text" name="email" id="email" value="<?php echo $admin->email; ?>"><br>
	<label>Hospital Name</label><br>
	<input type="text" name="hospital_name" id="hospital_name" value="<?php echo $admin->hospital_name; ?>"><br>
	<label>Address</label><br>
	<textarea name="address" id="address"><?php echo $admin->address; ?></textarea><br>
	<label>Change Password</label><br>
	<input type="password" name="password" id="password" placeholder="Leave blank if do not want to change it">	<br><br>
	<button type="submit" form="add_doctor" class="btn btn-info" onclick="update_admin()">Submit</button>
</div> -->
<?php include 'includes/footer.php';?>
<script>
	function update_admin(){
		var email    = $('#email').val();
		var hospital_name = $('#hospital_name').val();
		var address  = $('#address').val();
		var password = $('#password').val();
		var currency = $('#currency').val();
		var phone    = $('#phone').val();
		
		if(email == ""){
			swal('Email required');
		}else if(hospital_name == ""){
			swal('Hospital Name required');
		}else if(address == ""){
			swal('Address required');
		}else{
			var sub_data = "";
			sub_data += '&email=' + email;
			sub_data += '&hospital_name=' + hospital_name;
			sub_data += '&address=' + address;
			sub_data += '&password=' + password;
			sub_data += '&currency=' + currency;
			sub_data += '&phone=' + phone;

			$.ajax({
				url: '<?php echo base_url('admin/dashboard/update_admin'); ?>',
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