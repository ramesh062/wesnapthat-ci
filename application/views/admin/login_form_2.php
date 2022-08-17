<?php
	$PageTitle="Website Name :: Webstie";
	$PageName="login";
	include("includes/header.php");
?>
<div class="login_form">
	<div class="background_image_two" style="background-image: url(<?php echo SITE_IMAGES ?>bg_img.png);">
		<div class="login">
			<div class="login_details">
				<div class="heading_text">Dr. John’s General Hospital</div>
				<div class="sub_heading_text">160  Shine Street,  NY 10023</div>
				<div class="custom_input_main">
					<div class="custom_input_box">
						<div class="input_box">
							<div class="input_icon">
								<img src="<?php echo SITE_IMAGES ?>mail.svg">
							</div>
							<input type="text" placeholder="Email Address" class="custom_input">
						</div>
					</div>
					<div class="custom_input_box">
						<div class="input_box">
							<div class="input_icon">
								<img src="<?php echo SITE_IMAGES ?>lock.svg">
							</div>
							<input type="text" placeholder="Passowrd" class="custom_input">
						</div>
					</div>
				</div>
				<div class="device_remember">
					<input type="checkbox" name="checkbox" class="square_box">
					<span class="sub_text">Remember on this device</span>
				</div>
				<a href="javascript:;" class="common_button">
					<span>Login</span>
				</a>
				<a href="javascript" class="forgot_pass">Forgot Password?</a>
			</div>
			<div class="common_bottom">
				<span class="color_change">Powered By</span>
				<div class="common_part">
					<img src="<?php echo SITE_IMAGES ?>bottom_part.svg">
					<span>AppoBook</span>
				</div>
			</div>
		</div>
		
	</div>
</div>

<?php include("includes/footer.php"); ?>