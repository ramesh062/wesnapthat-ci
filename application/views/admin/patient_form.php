<?php include 'includes/header.php';?>

<section class="appoinment_part">
	<div class="new_appoinment">
		<div class="common_text">
			<div class="common_text_form">Add Patient</div>
			<div class="right_img"><img src="<?php echo SITE_IMAGES ?>building.svg"></div>
		</div>
		<div class="appoinment_form">
			<?php echo form_open(base_url('admin/patients/save_patient'),array("id" => "add_patient","name" => "add_doctor")); ?>
			<div class="custom_input_main">
				<div class="custom_input_box">
					<label class="input_label">Full Name</label>
					<div class="input_box">
						<input type="text" name="fullname" id="fullname" placeholder="Patient's Full Name" class="custom_input">
					</div>
					<?php echo form_error('fullname', '<div class="text-danger">', '</div>'); ?>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Mobile</label>
					<div class="input_box">
						<input type="tel" name="mobile" id="mobile" placeholder="9876543210" class="custom_input">
						<input type="hidden" name="countrycode" id="countrycode" value=""/>
					</div>
					<?php echo form_error('mobile', '<div class="text-danger">', '</div>'); ?>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Age</label>
					<div class="input_box">
						<input type="number" name="age" id="age" placeholder="Age" class="custom_input">
					</div>
					<?php echo form_error('age', '<div class="text-danger">', '</div>'); ?>
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
					<label class="input_label">Password</label>
					<div class="input_box">
						<input type="password" name="password" id="password" placeholder="Password" class="custom_input">
					</div>
					<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
				</div>
				<div class="custom_input_box">
					<label class="input_label">Confirm Password</label>
					<div class="input_box">
						<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="custom_input">
					</div>
					<?php echo form_error('confirm_password', '<div class="text-danger">', '</div>'); ?>
				</div>
			</div>
			<div class="btn_book">
				<button type="submit" class="common_button">
					<span>Submit</span>
				</button>
			</div>
			<?php if(!empty($_SESSION['error_message'])){
				echo "<div class='text-danger'>".$_SESSION['error_message']."</div>";
				unset($_SESSION['error_message']);
			}
			?>
			<?php echo form_close(); ?>
		</div>
	</div>
	
</section>

<?php include 'includes/footer.php';?>
<link rel="stylesheet" href="<?php echo SITE_CSS?>intlTelInput.min.css"/>
<script src="<?php echo SITE_JS?>intlTelInput.min.js"></script>
<script>
$(function(){
	var input = document.querySelector("#mobile");
	var iti=window.intlTelInput(input, {
		separateDialCode: true,
  		// preferredCountries:["in"],
  		hiddenInput: "full",
  		utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
	});
	
	$("#add_patient").submit(function(){
		$(".common_button span").html("Waiting... <div class='spinner-border spinner-border-sm' role='status'><span class='sr-only'>Loading...</span></div>"); 
		var countryCode = iti.getSelectedCountryData();
		if(countryCode.dialCode)
			$("#countrycode").val("+"+countryCode.dialCode);	
	});
});
</script>


