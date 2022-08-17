<?php
	include("includes/header.php");
?>
<div class="login_form">
	<div class="background_image" style="background-image: url(<?php echo SITE_IMAGES ?>background_image.png);">
		<div class="login">
            <div class="login_details">
    			<div id="login_box">
    				<div class="heading_text"><?php echo $hospital_details->hospital_name; ?></div>
    				<div class="sub_heading_text"><?php echo $hospital_details->address; ?></div>
    				<div class="custom_input_main">
    					<div class="custom_input_box">
    						<div class="input_box">
    							<div class="input_icon">
    								<img src="<?php echo SITE_IMAGES ?>mail.svg">
    							</div>
    							<input type="text" name="email" id="email" placeholder="Email Address" class="custom_input" value="<?php echo isset($_COOKIE['DBS_admin_email']) ? $_COOKIE['DBS_admin_email'] : ""; ?>">
    						</div>
    					</div>
    					<div class="custom_input_box">
    						<div class="input_box">
    							<div class="input_icon">
    								<img src="<?php echo SITE_IMAGES ?>lock.svg">
    							</div>
    							<input type="password" id="password" name="password" placeholder="Passowrd" class="custom_input" value="<?php echo isset($_COOKIE['DBS_admin_password']) ? $_COOKIE['DBS_admin_password'] : ""; ?>">
    						</div>
    					</div>
    				</div>
    				<div class="device_remember">
    					<input type="checkbox" class="square_box" name="remember_me" id="remember_me" <?php echo isset($_COOKIE['DBS_admin_email']) ? "checked" : ""; ?>>
    					<span class="sub_text">Remember on this device</span>
    				</div>
    				<a href="javascript:;" onclick="do_login();" class="common_button">
    					<span>Login</span>
    				</a>
    				<a href="javascript:;" class="forgot_pass" onclick="show_forgotp();">Forgot Password?</a>
    			</div>
                <div id="forgot_box" style="display: none;"> 
                    <div class="heading_text">Forgot Password</div><br>
                    <div class="custom_input_main">
                        <div class="custom_input_box">
                            <div class="input_box">
                                <div class="input_icon">
                                    <img src="<?php echo SITE_IMAGES ?>mail.svg">
                                </div>
                                <input type="text" name="reg_email" id="reg_email" placeholder="Email" class="custom_input">
                            </div>
                        </div>
                    </div>
                    <span class="sub_heading_text">Please enter your registered email address to receive OTP.</span>
                    <a href="javascript:forgot_password();" class="common_button forgot_btn">
                        <span>Reset</span>
                    </a>
                    <a href="<?php echo site_url();?>admin/authentication" class="forgot_pass">Login</a>
                </div>
                <div id="otp_verify" style="display: none;">
                    <div class="heading_text">Verify Email OTP</div><br>
                    <div class="custom_input_main">
                        <div class="custom_input_box">
                            <div class="input_box">
                                <div class="input_icon">
                                    <img src="<?php echo SITE_IMAGES ?>lock.svg">
                                </div>
                                <input type="text" maxlength="4" name="otp" id="otp" placeholder="Enter OTP" class="custom_input">
                            </div>
                        </div>
                    </div>
                    <a href="javascript:verify_otp();" class="common_button verify_btn" style="padding: 15px 138px;">
                        <span>Verify OTP</span>
                    </a>   
                    <a href="<?php echo site_url();?>admin/authentication" class="forgot_pass">Login</a> 
                </div> 
                <div id="change_pass" style="display: none;"> 
                     <div class="heading_text">Set New Password</div><br>
                    <div class="custom_input_main">
                        <div class="custom_input_box">
                            <div class="input_box">
                                <div class="input_icon">
                                    <img src="<?php echo SITE_IMAGES ?>lock.svg">
                                </div>
                                <input type="password" name="n_password" id="n_password" placeholder="New Passowrd" class="custom_input">
                            </div>
                        </div>
                        <div class="custom_input_box">
                            <div class="input_box">
                                <div class="input_icon">
                                    <img src="<?php echo SITE_IMAGES ?>lock.svg">
                                </div>
                                <input type="password" name="r_password" id="r_password" placeholder="Confirm New Passowrd" class="custom_input">
                            </div>
                        </div>
                    </div>
                    <a href="javascript:set_new_password();" class="common_button forgot_btn" style="padding: 15px 113px;">
                        <span>Change Password</span>
                    </a>
                    <a href="<?php echo site_url();?>admin/authentication" class="forgot_pass">Login</a>
                </div>
    			<div class="common_bottom">
    				<span>Powered By</span>
    				<div class="common_part">
    					<img src="<?php echo SITE_IMAGES ?>bottom_part.svg">
    					<span><?php echo $hospital_details->hospital_name; ?></span>
    				</div>
    			</div>
            </div>    
		</div>
		<div class="bottom_logo">
		<img src="<?php echo SITE_IMAGES ?>Logo 1150_200.png">
		</div>
	</div>
</div>
<script>
    var playerID; 
    async function get_player_id()
    {
        playerID = await OneSignal.getUserId();   
    }
    function show_forgotp(){
        $('#login_box').hide();
        $('#forgot_box').show();
    }

    function forgot_password(){

        var reg_email = $('#reg_email').val();
        if(reg_email == ''){
            swal('Please enter registered email');
        }else{
            var sub_data = "";
            sub_data += '&email=' + reg_email;

            $.ajax({
                url  : '<?php echo site_url();?>admin/authentication/forgot_password',
                type : 'POST',
                data : sub_data,
                dataType : 'JSON',
                success: function(response){
                    if(response.status == 1){
                        $('#forgot_box').hide();
                        $('#otp_verify').show();                   
                    }else{ 
                        swal(response.message);
                    }
                }
            })  
        }
    }

    function verify_otp(){

        var reg_email = $('#reg_email').val();
        var otp       = $("#otp").val();

        if(otp == ''){
            swal('Please enter otp');
        }else{
            var sub_data = "";
            sub_data += '&email=' + reg_email;
            sub_data += '&otp=' + otp;

            $.ajax({
                url  : '<?php echo site_url();?>admin/authentication/verify_otp',
                type : 'POST',
                data : sub_data,
                dataType : 'JSON',
                success: function(response){
                    if(response.status == 1){
                        $('#otp_verify').hide();
                        $('#change_pass').show();                  
                    }else{
                        swal(response.message);
                    }
                }
            })  
        }
        
    }

    function set_new_password(){

        var reg_email  = $('#reg_email').val();
        var n_password = $('#n_password').val();
        var r_password = $('#r_password').val();
        
        if(n_password == '' || r_password == ''){
            swal('All fields required.');
        }else if(n_password != r_password){
            swal('Confirm password does not match');
        }else{
            var sub_data = "";
            sub_data += '&new_password=' + n_password;
            sub_data += '&confirm_password=' + r_password;
            sub_data += '&email=' + reg_email;
           
            $.ajax({
                url  : '<?php echo site_url();?>admin/authentication/set_password',
                type : 'POST',
                data : sub_data,
                dataType : 'JSON',
                success: function(response){
                    if(response.status == 1){
                        swal("Password updated successfully..");
                        setTimeout(function() {
                            window.location = '<?php echo site_url();?>admin/authentication';
                        }, 1000);
                        
                    }else{
                        swal(response.message);
                    }
                }
            })  
        }
    }

    function do_login(){

        var email    = $("#email").val();
        var password = $("#password").val();
        var remember_me = $("#remember_me:checked").val();
        
        if(email == ""){
            swal("Please enter email");
        }else if(password == ""){
            swal("Please enter password");
        }else{
            var sub_data = "";
            sub_data +='&email='+email;
            sub_data +='&password='+password;
            
            if(remember_me != undefined){
                sub_data +='&remember_me='+remember_me;    
            }

            $.ajax({
                url:'<?php echo site_url();?>admin/Authentication/login',
                type:'POST',
                dataType:'JSON',
                data:sub_data,
				beforeSend:function(){
					$(".common_button span").html("Waiting... <div class='spinner-border spinner-border-sm' role='status'><span class='sr-only'>Loading...</span></div>"); 
				},
                success: function(response){
                    if(response.status == 1){
                        
                        get_player_id();
                        setTimeout(function(){ 
                            $.ajax({
                                url:'<?php echo site_url();?>admin/Authentication/set_device_info',
                                type:'POST',
                                dataType:'JSON',
                                data: {player_id: playerID},
                                success: function(response){
                                    window.location = '<?php echo site_url();?>admin/dashboard';            
                                }
                            })
                        }, 500);
                        
                    }else{
                       swal(response.message);
                    }
					$(".common_button span").text("Login"); 
                },
				error:function(){
					$(".common_button span").text("Login");
				}
            });
        }   
    }
</script>
<?php include("includes/footer.php"); ?>
