<?php
	$PageTitle="Website Name :: Webstie";
	$PageName="login";
	include("includes/header.php");
?>
<div class="login_form">
	<div class="background_image" style="background-image: url(<?php echo SITE_IMAGES ?>background_image.png);">
		<div class="login">
			<div class="login_details">
				<div class="heading_text">Dr. John’s General Hospital</div>
				<div class="sub_heading_text">160  Shine Street,  NY 10023</div>
				<div id="change_pass" > 
					<div class="custom_input_main">
						<div class="custom_input_box">
							<div class="input_box">
								<div class="input_icon">
									<img src="<?php echo SITE_IMAGES ?>lock.svg">
								</div>
								<input type="text" placeholder="Current Passowrd" class="custom_input">
							</div>
						</div>
						<div class="custom_input_box">
							<div class="input_box">
								<div class="input_icon">
									<img src="<?php echo SITE_IMAGES ?>lock.svg">
								</div>
								<input type="text" placeholder="New Passowrd" class="custom_input">
							</div>
						</div>
						<div class="custom_input_box">
							<div class="input_box">
								<div class="input_icon">
									<img src="<?php echo SITE_IMAGES ?>lock.svg">
								</div>
								<input type="text" placeholder="Confirm New Passowrd" class="custom_input">
							</div>
						</div>
					</div>
					<a href="javascript:;" class="common_button forgot_btn">
						<span>Change Password</span>
					</a>
				</div>
				<div id="otp_verify" style="display: none;">
					<div class="custom_input_main">
						<div class="custom_input_box">
							<div class="input_box">
								<div class="input_icon">
									<img src="<?php echo SITE_IMAGES ?>mail.svg">
								</div>
								<input type="text" placeholder=" Email ID" class="custom_input">
							</div>
						</div>
						<div class="custom_input_box">
							<div class="input_box">
								<div class="input_icon">
									<img src="<?php echo SITE_IMAGES ?>lock.svg">
								</div>
								<input type="text" placeholder="Enter OTP" class="custom_input">
							</div>
						</div>
					</div>
					<a href="javascript:;" class="common_button verify_btn">
						<span>Verify OTP</span>
					</a>	
				</div>	
			</div>
			<!-- <div class="login_details">
				<div class="heading_text">Dr. John’s General Hospital</div>
				<div class="sub_heading_text">160  Shine Street,  NY 10023</div>
				
			</div> -->
			<div class="common_bottom">
				<span>Powered By</span>
				<div class="common_part">
					<img src="<?php echo SITE_IMAGES ?>bottom_part.svg">
					<span>AppoBook</span>
				</div>
			</div>
		</div>
		
	</div>
</div>

<?php include("includes/footer.php"); ?>