<?php
	error_reporting(0);
	
	class API extends CI_Controller
	{
		public $status;
		public $data;
		public $message;

		public function __construct()
		{	
			parent::__construct();
			$this->load->model('api_model', 'model');
			
			$this->status 	= 0;
			$this->data 	= array();
			$this->message 	= "";

			//for postman
		    if(!isset($_POST) || count($_POST) < 1){
		        $_POST=json_decode(file_get_contents("php://input"), true);
		    }
		}

		public function response()
		{
			$response = array();

			$response['status'] 	= $this->status;
			$response['data']		= $this->data;
			$response['message'] 	= $this->message;

			echo json_encode($response);
			exit;
		}

		public function login()
		{
			$data = $this->input->post();

			//if($data['email'] == "" || $data['password'] == ""){
				
				//$this->status 	= 0;
				//$this->message 	= "Email address and Password Both Required.";
			//}else{
				
			if($data['type'] == "doctor"){
				if($data['email'] == "" || $data['password'] == ""){
					$this->status 	= 0;
					$this->message 	=  EMAIL_ADDRESS_PASSWORD_BOTH_REQUIRED ;  //"Email address and Password Both Required.";
				}else {

					$isValidUser = $this->model->validate('doctors', array('email'=>$data['email'], 'password'=>md5($data['password'])));
					
					if($isValidUser){

						$uId = $this->model->get('doctors', 'id', array('email'=>$data['email'], 'password'=>md5($data['password'])));
						$user = $this->model->get_user('doctors' , $uId);

						$device_info = array(
							'user' 			=> $uId,
							'type'			=> isset($data['type']) ? $data['type'] : '',
							'udid' 			=> isset($data['udid']) ? $data['udid'] : '',
							'device_type' 	=> isset($data['device_type']) ? $data['device_type'] : '',
							'os_version' 	=> isset($data['os_version']) ? $data['os_version'] : '',
							'handset' 		=> isset($data['handset']) ? $data['handset'] : '',
							'ip_address' 	=> isset($data['ip_address']) ? $data['ip_address'] : '',
							'time_zone'		=> isset($data['time_zone']) ? $data['time_zone'] : ''
						);
						$this->model->set_user_device($device_info);

						if($user['profile_photo'] != ""){
							$user['profile_photo'] = DOCTOR_PIC_URL.$user['profile_photo'];
						}
						
						$settings = $this->db->select('admin.hospital_name,admin.address,admin.phone,currency_table.name as currency_name,currency_table.sign as currency_sign')
											 ->from('admin')
											 ->join('currency_table' ,'admin.currency = currency_table.id')
											 ->get()->row();
						$settings =  array('info'=>$settings ,'booking_url'=> base_url('appointment_booking/new_appointment'));
						//print_r($settings);

						$this->status 	= 1;
						$this->data 	= array('doctor'=>$user ,'settings'=>$settings);
					}else{

						$this->status 	= 0;
						$this->message 	= INVALID_EMMAIL_OR_PASSWORD;
					}
				}
			}else if($data['type'] == "patient"){

				if($data['mobile'] == "" || $data['password'] == "" || $data['countrycode'] == "" ){
					$this->status 	= 0;
					$this->message 	= MOBILE_NUMBER_AND_PASSWORD_BOTH_REQUIRED;  //"mobile number and Password Both Required.";
				}else {
					
					$isValidUser = $this->model->validate('patients', array('mobile'=>$data['mobile'], 'countrycode'=>$data['countrycode'], 'password'=>md5($data['password'])));
					
					if($isValidUser){
						// Get user details
						$uId = $this->model->get('patients', 'id', array('mobile'=>$data['mobile'] , 'countrycode'=>$data['countrycode'] , 'password'=>md5($data['password'])));
						$user = $this->model->get_user('patients',$uId);

						// Set user device info
						$device_info = array(
							'user' 			=> $uId,
							'type'			=> isset($data['type']) ? $data['type'] : '',
							'udid' 			=> isset($data['udid']) ? $data['udid'] : '',
							'device_type' 	=> isset($data['device_type']) ? $data['device_type'] : '',
							'os_version' 	=> isset($data['os_version']) ? $data['os_version'] : '',
							'handset' 		=> isset($data['handset']) ? $data['handset'] : '',
							'ip_address' 	=> isset($data['ip_address']) ? $data['ip_address'] : '',
							'time_zone'		=> isset($data['time_zone']) ? $data['time_zone'] : ''
						);
						$this->model->set_user_device($device_info);

						if($user['profile_photo'] != ""){
							$user['profile_photo'] = PATIENT_PIC_URL.$user['profile_photo'];
						}

						$settings = $this->db->select('admin.hospital_name,admin.address,admin.phone,currency_table.name as currency_name,currency_table.sign as currency_sign')
											 ->from('admin')
											 ->join('currency_table' ,'admin.currency = currency_table.id')
											 ->get()->row();
						
						$settings =  array('info'=>$settings ,'booking_url'=> base_url('appointment_booking/new_appointment'));
						

						$this->status 	= 1;
						$this->data 	= array('patient'=>$user ,'settings'=>$settings);
					}else{

						$this->status 	= 0;
						$this->message 	= "invalid_mobile_or_password";
					}
				}
			}else{
				$this->status 	= 0;
				$this->message 	=  PLEASE_ENTER_TYPE;	
			}
				
			//}

			if($this->status != 1){
				$this->data = new stdClass();
			}
			$this->response();
		}

		public function signup()
		{
			$data = $this->input->post();
			
			if($data['fullname'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_FULLNAME;
			}else if($data['mobile'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_MOBILE_NUMBER;
			}else if($data['age'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_AGE;
			}else if($data['gender'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_SELECT_GENDER;
			}else if($data['password'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_PASSWORD;
			}else{
			    
			    $data1['fullname'] = $data['fullname'];
				//$data1['email']    = $data['email'];
				$data1['email']    = isset($data['email']) ? $data['email'] : '';
				$data1['mobile']   = $data['mobile'];
				$data1['age']      = $data['age'];
				$data1['gender']   = $data['gender'];
				$data1['password'] = $data['password'];
				$data1['countrycode'] = $data['countrycode'];
				
				
				$id = $this->model->patient_signup($data1);
				if($id == false){

					$this->status  = 0;
					$this->message = MOBILE_ALREADY_EXIST;
				}else{
					
					$user = $this->model->get_user('patients',$id);
					if($user['profile_photo'] != ""){
						$user['profile_photo'] = PATIENT_PIC_URL.$user['profile_photo'];
					}
					//DO CODE HERE
					$isOTPSent =  $this->model->otp_mobile('send', $data['mobile'] , $data['countrycode']);
					$user['otp'] = "";

					if($isOTPSent){
						$OTPData = $this->model->get('otp', "otp" , array('mobile'=>$data['mobile'] , 'countrycode'=>$data['countrycode']));
						if($OTPData) {
							$user['otp'] = $OTPData;							
						}
					}
					
					$device_info = array(
						'user' 			=> $id,
						'type'			=> 'patient',
						'udid' 			=> isset($data['udid']) ? $data['udid'] : '',
						'device_type' 	=> isset($data['device_type']) ? $data['device_type'] : '',
						'os_version' 	=> isset($data['os_version']) ? $data['os_version'] : '',
						'handset' 		=> isset($data['handset']) ? $data['handset'] : '',
						'ip_address' 	=> isset($data['ip_address']) ? $data['ip_address'] : '',
						'time_zone'		=> isset($data['time_zone']) ? $data['time_zone'] : ''
					);
					$this->model->set_user_device($device_info);
					
					$settings = $this->db->select('admin.hospital_name,admin.address,admin.phone,currency_table.name as currency_name,currency_table.sign as currency_sign')
										 ->from('admin')
										 ->join('currency_table' ,'admin.currency = currency_table.id')
										 ->get()->row();

					$settings =  array('info'=>$settings ,'booking_url'=> base_url('appointment_booking/new_appointment'));

					$this->status 	= 1;
					$this->data 	= array('patient'=>$user ,'settings'=>$settings);
					$this->message = PATIENT_REGISTERD_SUCCESSFULLY;
				}
			}	

			if($this->status != 1){
				$this->data = new stdClass();
			}
			$this->response();
		}
		public function varify_signup_otp(){

			$data = $this->input->post();
			
			if($data['id'] == ""){
				$this->status  = 0;
				$this->message = USER_ID_REQUIRED;
			}else if($data['otp'] == ""){
				$this->status  = 0;
				$this->message = OTP_REQUIRED;
			}else if($data['mobile'] == ""){
				$this->status  = 0;
				$this->message = MOBILE_REQUIRED;
			}else if($data['countrycode'] == ""){
				$this->status  = 0;
				$this->message = COUNTRY_CODE_REQUIRED;
			}else{

				$isValidOTP = $this->model->validate('otp', array('mobile'=>$data['mobile'], 'countrycode'=>$data['countrycode'] , 'otp'=>$data['otp'] ));
				if($isValidOTP){

					$data["otp_varified"] = 1;
					$id = $this->model->update_patient_user_status('patients',$data);
					if($id){

						$user = $this->model->get_user('patients',$data['id']);
						if($user['profile_photo'] != ""){
							$user['profile_photo'] = PATIENT_PIC_URL.$user['profile_photo'];
						}

						$settings = $this->db->select('admin.hospital_name,admin.address,admin.phone,currency_table.name as currency_name,currency_table.sign as currency_sign')
										 ->from('admin')
										 ->join('currency_table' ,'admin.currency = currency_table.id')
										 ->get()->row();
						$settings =  array('info'=>$settings ,'booking_url'=> base_url('appointment_booking/new_appointment'));

        				$this->status  = 1;
        				$this->data 	= array('patient'=>$user ,'settings'=>$settings);
        				$this->message = OTP_VERIFIED_SUCCESSFULLY;
        			}else{
        				$this->status  = 0;
        				$this->message = SOMETHING_WENT_WRONG;
        			}
        		}else{
        			$this->status  = 0;
        			$this->message = OTP_NOT_VARIFIED_PLEASE_TRY_AGAIN;
        		}
			}
			if($this->status != 1){
				$this->data = new stdClass();
			}
			$this->response();
		}
        
        public function do_logout()
		{
			$data = $this->input->post();
			
			if($data['id'] == ""){
				$this->status  = 0;
				$this->message = ID_REQUIRED;
			}else if($data['type'] == ""){
				$this->status  = 0;
				$this->message = TYPE_REQUIRED;
			}else{

				$this->db->set('udid' , '')
						 ->where('user' , $data['id'])
						 ->where('type' , $data['type'])
						 ->update('user_devices');
				
				// if($this->db->affected_rows() > 0){
				$this->status = 1;
				// }else{
				// 	$this->status  = 0;
				// 	$this->message = 'Somthing went wrong.';
				// }
			} 

			$this->response();
		}
		
		public function settings()
		{
			$settings = $this->db->select('admin.hospital_name,admin.address,admin.phone,currency_table.name as currency_name,currency_table.sign as currency_sign')
								 ->from('admin')
								 ->join('currency_table' ,'admin.currency = currency_table.id')
								 ->get()->row();
			$this->status 	= 1;
			$this->data 	= array('settings'=>$settings , 'booking_url'=> base_url('appointment_booking/new_appointment'));

			$this->response();
		}

		public function change_email_varification()
		{
			$data = $this->input->post();	


			if($data['email'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_NEW_EMAIL_ADDRESS;
			}else{
				// Send OTP 
					$isOTPSent = $this->model->otp('send', $data['email']);

					if(!$isOTPSent){
						$this->status 	= 0;
						$this->message 	= SORRY_WE_ARE_UNABLE_TO_SEND_YOU_OTP_PLEASE_TRY_AGAIN_OR_CONTACT_SUPPORT;

					}else{
						$this->status 	= 1;
						$this->message 	= WE_HAVE_SENT_AN_OTP_TO_YOUR_EMAIL_ADDRESS_KINDLY_CONFIRM;
					}
			}
			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

		public function verify_and_change_email()
		{
			$data = $this->input->post();
			$email 	= $this->input->post('email');
			$otp 	= $this->input->post('otp');
			$doctor_id 	= $this->input->post('id');

			if(empty($email) || empty($otp)){
				$this->status 	= 0;
				$this->message 	= EMAIL_OR_OTP_MISSING;
			}else if(empty($doctor_id)){
				$this->status 	= 0;
				$this->message 	= ENTER_DOCTOR_ID;
			}else{
				// Validate email and otp
				$isValidOTP = $this->model->validate('otp', array('email'=>$email, 'otp'=>$otp));

				if($isValidOTP){
					// OTP VERIFTY SUCCESSFULY 
					$id = $this->model->update_email('doctors',$data);
					if($id){

						$myData["email"] =  $email;

						$this->status  = 1;
						$this->data =  $myData;
						$this->message = EMAIL_UPDATED;
					}else{
						$this->status  = 0;
						$this->message = SOMETHING_WENT_WRONG;
					}
				
				}else{
					$this->status 	= 0;
					$this->message 	= EMAIL_VERIFICATION_FAILD;
				}
			}
			if($this->status != 1){
				$this->data = new stdClass();
			}
			$this->response();
		}

		public function change_email()
		{
			$data = $this->input->post();

			if($data['id'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_ID;
			}else if($data['type'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_TYPE;
			}else if($data['email'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_EMAIL_ADDRESS;
			}else{
				if($data['type'] == "doctor"){
					$id = $this->model->update_email('doctors',$data);
				}else{
					$id = $this->model->update_email('patients',$data);
				}

				if($id){
					$this->status  = 1;
					$this->message = EMAIL_UPDATED;
				}else{
					$this->status  = 0;
					$this->message = SOMETHING_WENT_WRONG;
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

// 		public function change_password()
// 		{
// 			$data = $this->input->post();

// 			if($data['id'] == ""){
// 				$this->status  = 0;
// 				$this->message = "Please enter id.";
// 			}else if($data['type'] == ""){
// 				$this->status  = 0;
// 				$this->message = "Please enter type.";
// 			}else if($data['password'] == ""){
// 				$this->status  = 0;
// 				$this->message = "Please enter password.";
// 			}else{
// 				if($data['type'] == "doctor"){
// 					$id = $this->model->update_password('doctors',$data);
// 				}else{
// 					$id = $this->model->update_password('patients',$data);
// 				}

// 				if($id){
// 					$this->status  = 1;
// 					$this->message = "Password updated.";
// 				}else{
// 					$this->status  = 0;
// 					$this->message = "Somthing went wrong";
// 				}
// 			}

// 			if($this->status != 1){
// 				$this->data = new stdClass();
// 			}

// 			$this->response();
// 		}
        
        
		public function change_password()
		{
			$data = $this->input->post();
            
			if($data['id'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_ID;
			}else if($data['type'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_TYPE;
			}else if($data['current_password'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_CURRENT_PASSWORD;
			}else if($data['new_password'] == ""){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_NEW_PASSWORD;
			}else{
                
				if($data['type'] == "doctor"){
					
					$isValid = $this->model->validate('doctors', array('id'=>$data['id'], 'password'=>md5($data['current_password'])));
                    
					if(!$isValid){
						$this->status 	= 0;
						$this->message 	= INVALID_CURRENT_PASSWORD;
					}else{
						$id = $this->model->update_password('doctors',$data);
						
						if($id){
        					$this->status  = 1;
        					$this->message = PASSWORD_UPDATED;
        				}else{
        					$this->status  = 0;
        					$this->message = SOMETHING_WENT_WRONG;
        				}
					}

				}else{

					$isValid = $this->model->validate('patients', array('id'=>$data['id'], 'password'=>md5($data['current_password'])));
					
					if(!$isValid){
						$this->status 	= 0;
						$this->message 	= INVALID_CURRENT_PASSWORD;
					}else{						
						$id = $this->model->update_password('patients',$data);
						
						if($id){
        					$this->status  = 1;
        					$this->message = PASSWORD_UPDATED;
        				}else{
        					$this->status  = 0;
        					$this->message = SOMETHING_WENT_WRONG;
        				}
					}
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

		
		public function forgot_password()
		{
			$data = $this->input->post();
			
			if(empty($data['email'])){
				$this->status 	= 0;
				$this->message 	= PLEASE_ENTER_YOUR_EMAIL_ADDRESS;
			
			}else if(empty($data['type'])){
				$this->status 	= 0;
 				$this->message 	= PLEASE_ENTER_TYPE;

			}else{
				
				if($data['type'] == 'doctor'){
					$isValidUser = $this->model->validate('doctors', array('email'=>$data['email']));
				
				}else if($data['type'] == 'patient'){
					$isValidUser = $this->model->validate('patients', array('email'=>$data['email']));
				
				}

				if(!$isValidUser){
					$this->status 	= 0;
					$this->message 	= INVALID_USER;
				
				}else{
					// Send OTP 
					$isOTPSent = $this->model->otp('send', $data['email']);

					if(!$isOTPSent){
						$this->status 	= 0;
						$this->message 	= SORRY_WE_ARE_UNABLE_TO_SEND_YOU_OTP_PLEASE_TRY_AGAIN_OR_CONTACT_SUPPORT;

					}else{
						$this->status 	= 1;
						$this->message 	= WE_HAVE_SENT_AN_OTP_TO_YOUR_EMAIL_ADDRESS_KINDLY_CONFIRM;
					}
				}
			}

			$this->response();
		}
		public function forgot_mobile_password()
		{

			$data = $this->input->post();
			
			if(empty($data['mobile'])){
				$this->status 	= 0;
				$this->message 	= PLEASE_ENTER_YOUR_MOBILE_NUMBER;
			
			}else if(empty($data['countrycode'])){
				$this->status 	= 0;
 				$this->message 	= PLEASE_ENTER_COUNTRY_CODE;

			}else{
				
				$isValidUser = $this->model->validate('patients', array('mobile'=>$data['mobile'], 'countrycode'=>$data['countrycode']));

				if(!$isValidUser){
					$this->status 	= 0;
					$this->message 	= INVALID_USER;
				
				}else{
					// Send MOBILE OTP HERE
					$isOTPSent =  $this->model->otp_mobile('send', $data['mobile'] , $data['countrycode'] ) ;

					if(!$isOTPSent){
						$this->status 	= 0;
						$this->message 	= SORRY_WE_ARE_UNABLE_TO_SEND_YOU_OTP_PLEASE_TRY_AGAIN_OR_CONTACT_SUPPORT;

					}else{
						$this->status 	= 1;
						$this->message 	= WE_HAVE_SENT_AN_OTP_TO_YOUR_EMAIL_ADDRESS_KINDLY_CONFIRM;
					}
				}
			}

			$this->response();
		}

		public function resend_mobile_otp()
		{
			//$patient_id 	= $this->input->post('id');
			//$mobile 	    = $this->input->post('mobile');
			//$countryCode 	= $this->input->post('countrycode');
			$data = $this->input->post();


			if(empty($data['mobile'])){
				$this->status 	= 0;
				$this->message 	= PLEASE_ENTER_YOUR_MOBILE_NUMBER;
			
			}if(empty($data['countrycode'])){
				$this->status 	= 0;
 				$this->message 	= PLEASE_ENTER_COUNTRY_CODE;
			}else {
					// Send MOBILE OTP HERE 
				$isOTPSent = $this->model->otp_mobile('send', $data['mobile'], $data['countrycode']);

				if($isOTPSent){
					$this->status 	= 1;
					$this->message 	= OTP_SENT_SUCCESSFULLY;
				}else{
					$this->status 	= 0;
					$this->message 	= FAIL_TO_SENT_OTP;
				}
			}
			if($this->status != 1){
				$this->data = new stdClass();
			}
			$this->response();

		}

		public function verify_otp()
		{
			$email 	= $this->input->post('email');
			$otp 	= $this->input->post('otp');
			$type 	= $this->input->post('type');
			$mobile 	= $this->input->post('mobile');
			$countrycode 	= $this->input->post('countrycode');

			if(empty($type)){
				$this->status 	= 0;
				$this->message 	= PLEASE_ENTER_TYPE;
			}else{

				if($type == 'doctor'){
						
					if(empty($email) || empty($otp)){
						$this->status 	= 0;
						$this->message 	= EMAIL_OR_OTP_MISSING;
					}else{
						// Validate email and otp
						$isValidOTP = $this->model->validate('otp', array('email'=>$email, 'otp'=>$otp));

						if($isValidOTP){
							$this->status 	= 1;
							$this->message 	= OTP_VERIFIED_SUCCESSFULLY;
						}else{
							$this->status 	= 0;
							$this->message 	= VERIFICATION_FAILED;
						}
					}

				}else if($type == 'patient'){
					// VALIDATE AND SEND OTP TO MOBILE NUMBER 
					// Send MOBILE OTP HERE
					$isOTPSent = $this->model->otp_mobile('send', $mobile, $countrycode );  // 1;

					if(!$isOTPSent){
						$this->status 	= 0;
						$this->message 	= VERIFICATION_FAILED;

					}else{
						$this->status 	= 1;
						$this->message 	= OTP_VERIFIED_SUCCESSFULLY;
					}
				}else{
					$this->status 	= 0;
					$this->message 	= INVALID_USER_TYPE;
				}
			}
			$this->response();
		}

		public function set_password()
		{
			$isPwdChanged = false;
			$data 	= $this->input->post();
			
			// Validate passwords
			if(empty($data['new_password']) || empty($data['type']) ){
				$this->status 	= 0;
				$this->message 	= ALL_FIELDS_REQUIRED;

			}else{
				if($data['type'] == 'doctor'){
					$isPwdChanged = $this->model->set_password('doctors', $data['new_password'], array('email'=>$data['email'])); 

				}else if($data['type'] == 'patient'){


					$isPwdChanged = $this->model->set_password('patients', $data['new_password'], array('mobile'=>$data['mobile'])); 
				
				}	
				
				if($isPwdChanged){
					// Delete OTP
					$this->model->del('otp', array('email'=>$data['email']));

					$this->status 	= 1;
					$this->message 	= PASSWORD_HAS_BEEN_CHANGED_SUCCESSFULLY;
				}else{
					$this->status 	= 0;
					$this->message 	= SORRY_WE_COULD_NOT_CHANGE_YOUR_PASSWORD_TRY_AGAIN_OR_CONTACT_SUPPORT;
				}
			}
			
			$this->response();
		}

		public function update_doctor()
		{
			$valid = true;
			$data = $this->input->post();

			if(empty($data['fullname'])){
				$this->status 	= 0;
				$this->message 	= FULLNAME_REQUIRED;
			}else if(empty($data['qualification'])){
				$this->status 	= 0;
				$this->message 	= QUALIFICATION_REQUIRED;
			}else if(empty($data['speciality'])){
				$this->status 	= 0;
				$this->message 	= SPECIALITY_REQUIRED;
			}else if(empty($data['experience'])){
				$this->status 	= 0;
				$this->message 	= EXPERIENCE_REQUIRED;
			}else if(empty($data['gender'])){
				$this->status 	= 0;
				$this->message 	= GENDER_REQUIRED;
			}else if(empty($data['consultation_charges'])){
				$this->status 	= 0;
				$this->message 	= CONSULTATION_CHARGE_REQUIRED;
			}else if(empty($data['address1'])){
                $this->status     = 0;
                $this->message     = "Address 1 require";
            }else if(empty($data['address2'])){
                $this->status     = 0;
                $this->message     = "Addres 2 require";
            }else if(empty($data['town'])){
                $this->status     = 0;
                $this->message     = "Town require";
            }else if(empty($data['city'])){
                $this->status     = 0;
                $this->message     = "city require";
            }else if(empty($data['country'])){
                $this->status     = 0;
                $this->message     = "country require";
            }else if(empty($data['mobile'])){
                $this->status     = 0;
                $this->message     = "mobile number require";
            }else if(empty($data['countrycode'])){
                $this->status     = 0;
                $this->message     = "country code require";
            }else{
				$id  = isset($data['doctor_id']) ? $data['doctor_id'] : "";
				if($id == ""){
					$this->status 	= 0;
					$this->message 	= DOCTOR_ID_REQUIRED;	
				}else{
					$result = $this->model->update_doctor_details($data , $id);

					if($result){
						if(isset($_FILES['profile_image']) && $_FILES['profile_image']['name']){
						    $image_path = './uploads/doctors_profile_images/';
						  
						    $path       = $_FILES['profile_image']['tmp_name'];
						    
						    $extension          = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
						    $allowed_extensions = [
						        'jpg',
						        'png',
						        'ogg',
						        'webm'
						    ];
						    if (!in_array($extension, $allowed_extensions)) {    
						        $valid = false;
						    }
						    
						    $filename  = date('dmyHis').'_'.$_FILES['profile_image']['name'];
						    $file = $image_path . $filename;

						    copy($path, $file);

						    $this->db->where('id' , $id);
						    $this->db->set('profile_photo' , $filename);
						    $this->db->update('doctors');
						}
						
						if($valid == false){
					        $this->status  = 0;
							$this->message = THIS_TYPE_OF_FILE_NOT_ALLOWED;
						}else{

							$doctor = $this->model->get_doctor_details($id);

							if($doctor->profile_photo != ""){
								$doctor->profile_photo = DOCTOR_PIC_URL.$doctor->profile_photo;
							}
							
							$this->status  = 1;
							$this->data    = $doctor;
							$this->message = DOCTOR_DETAILS_UPDATED_SUCCESSFULLY;
						}
						
					}else{
						$this->status  = 0;
						$this->message = SOMETHING_WENT_WRONG;
					}	
				}
			} 

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

		public function get_doctor_appointments()
		{
			$data = $this->input->post();

			if(empty($data['doctor_id'])){
				$this->status  = 0;
				$this->message = DOCTOR_ID_REQUIRED; 
			}else if(empty($data['type'])){
				$this->status  = 0;
				$this->message = TYPE_REQUIRED;
			}else{
				if($data['type'] == "date"){
					
					if(empty($data['date'])){
						$this->status  = 0;
						$this->message = DATE_REQUIRED;	
					}else{ 
						$result = $this->model->get_doctor_apptmnt($data);

						$this->data   = $result;
						$this->status = 1;
					}

				}else{
					$result = $this->model->get_doctor_apptmnt($data);

					if($result){
						$this->data   = $result;
						$this->status = 1;	
					}else{
						$this->status  = 1;
						$this->message = NO_DATA_FOUND;
					}
					
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

		public function manage_doctor_time()
		{
			$data = $this->input->post();
			
			if(empty($data['doctor_id'])){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_DOCTOR_ID; 
			}else if(empty($data['appointment_time_slot'])){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_APPOINTMENT_TIME_SLOT; 
			}else if(empty($data['from_time']) || empty($data['to_time'])){
				$this->status  = 0;
				$this->message = PLEASE_SELECT_CONSULTATION_HOURS;  
			}else{
				$result  = $this->model->update_doctor_time($data);
				
				if($result){
					$this->status  = 1;
					$this->message = SUCCESS;	
				}else{
					$this->status  = 0;
					$this->message = SOMETHING_WENT_WRONG;
				}	
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

		public function view_appointment()
		{
			$data = $this->input->post();
			
			if(empty($data['appt_id'])){
				$this->status  = 0;
				$this->message = APPOINTMENT_ID_REQUIRED; 
			}if(empty($data['type'])){
				$this->status  = 0;
				$this->message = TYPE_REQUIRED; 
			}else{
				$result = $this->model->view_apptmnt($data['appt_id'], $data['type'] );

				if(!empty($result)){

					if($result->profile_photo != ""){	
						if ($data['type'] == "doctor" ){
							$result->profile_photo = PATIENT_PIC_URL.$result->profile_photo;
						}else{
							$result->profile_photo = DOCTOR_PIC_URL.$result->profile_photo;
						}
					}

					$this->status = 1;
					$this->data   = $result;
				}else{
					$this->status = 0;
					$this->data   = SOMETHING_WENT_WRONG;
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

// 		public function cancel_appointment()
// 		{
// 			$data = $this->input->post();
			
// 			if(empty($data['appt_id'])){
// 				$this->status  = 0;
// 				$this->message = "Appointment id required."; 
// 			}else if(empty($data['type'])){
// 				$this->status  = 0;
// 				$this->message = "Type required.";
// 			}else{

// 				$app = $this->db->select('date,time,patient_id,doctor_id')
// 								->where('id' , $data['appt_id'])
// 						        ->get('appointments')->row();
			    
// 			    if($data['type'] == "doctor"){
// 			       $tz = $this->db->select('time_zone')
// 	    						  ->where('user' , $app->doctor_id)
// 	    						  ->where('type' , 'doctor')
// 	    						  ->get('user_devices')->row();

// 			    }else if($data['type'] == "patient"){
// 			       $tz = $this->db->select('time_zone')
// 	    						  ->where('user' , $app->patient_id)
// 	    						  ->where('type' , 'patient')
// 	    						  ->get('user_devices')->row();

// 			    }

// 			    date_default_timezone_set($tz->time_zone);

// 				$timestamp = strtotime($app->date ." ". $app->time);

// 				$time = $timestamp - (12 * 60 * 60);

// 				$datetime = date("Y-m-d H:i:s", $time);

// 				$now = strtotime(date('Y-m-d H:i:s'));

// 				if($now < strtotime($datetime)){
// 					$this->db->where('id' , $data['appt_id'])
// 							 ->update('appointments' , ['status' => 'cancel']);
					
// 					if($this->db->affected_rows() > 0){

// 						$data1['topic']   = 'cancel appointment';
// 						$data1['message'] = 'Appointment Canceled.';
						
// 						if($data['type'] == "doctor"){
// 						   $data1['user'] = $app->patient_id;
// 						   $data1['type'] = 'patient';
							
// 						   $data3['message'] = "Appointment Cancel by doctor.";
// 			 			   $data3['title']   = "Appointment.";
                           
//                           $isNotify = $this->model->get_notify('patients' , $app->patient_id);
                           
// 					    }else if($data['type'] == "patient"){
// 					       $data1['user'] = $app->doctor_id;
// 						   $data1['type'] = 'doctor';
							
// 						   $data3['message'] = "Appointment Cancel by patient.";
// 			 			   $data3['title']   = "Appointment.";
			 			   
// 			 			   $isNotify = $this->model->get_notify('doctors' , $app->doctor_id);
// 					    }
                        
//                         if($isNotify){
//     						$isSet = $this->model->set_notification($data1);
    
//     						if($isSet){
//     							if($data['type'] == "doctor"){
//     							   $data2['user'] = $app->patient_id;
//     							   $data2['type'] = 'patient';
//     							   $data2['reference_id'] = $app->doctor_id;
    
//     						    }else if($data['type'] == "patient"){
//     							   $data2['user'] = $app->doctor_id;
//     							   $data2['type'] = 'doctor';
//     							   $data2['reference_id'] = $app->patient_id;
//     						    }
//     							$data2['message'] = 'Appointment Canceled.';
//     							$data2['title']   = 'cancel appointment';
    							
//     							$this->model->send_push_notification($data2);
//     						}
//                         }
// 					    $data3['user'] = 1;
// 						$data3['type'] = "admin";
// 			            $data3['url']  = base_url('admin/appointments/get_appt/all');
// 						$this->model->send_push_notification($data3);

// 						$this->status  = 1;
// 						$this->message = "Appointment Canceled.";	
// 					}else{
// 						$this->status  = 0;
// 						$this->message = "Somthing went wrong!!";
// 					}	
										
// 				}else{

// 					$this->status  = 0;
// 					$this->message = "Can't cancel appointment.";
// 				}
// 			}

// 			if($this->status != 1){
// 				$this->data = new stdClass();
// 			}

// 			$this->response();
// 		}

        public function cancel_appointment()
		{
			$data = $this->input->post();
			
			if(empty($data['appt_id'])){
				$this->status  = 0;
				$this->message = APPOINTMENT_ID_REQUIRED; 
			}else if(empty($data['type'])){
				$this->status  = 0;
				$this->message = TYPE_REQUIRED;
			}else{

				$app = $this->db->select('date,time,patient_id,doctor_id')
								->where('id' , $data['appt_id'])
						        ->get('appointments')->row();

			    if($data['type'] == "doctor"){
			       $tz = $this->db->select('time_zone')
	    						  ->where('user' , $app->doctor_id)
	    						  ->where('type' , 'doctor')
	    						  ->get('user_devices')->row();

			    }else if($data['type'] == "patient"){
			       $tz = $this->db->select('time_zone')
	    						  ->where('user' , $app->patient_id)
	    						  ->where('type' , 'patient')
	    						  ->get('user_devices')->row();

			    }

			    date_default_timezone_set($tz->time_zone);

				$timestamp = strtotime($app->date ." ". $app->time);

				$time = $timestamp - (12 * 60 * 60);

				$datetime = date("Y-m-d H:i:s", $time);

				$now = strtotime(date('Y-m-d H:i:s'));

				if($now < strtotime($datetime)){
					$this->db->where('id' , $data['appt_id'])
							 ->update('appointments' , ['status' => 'cancel']);
					
					if($this->db->affected_rows() > 0){

						$data1['topic']   = 'cancel appointment';
						$data1['message'] = APPOINTMENT_CANCELED;
						
						if($data['type'] == "doctor"){
						   $data1['user'] = $app->patient_id;
						   $data1['type'] = 'patient';
						   $data1['reference_id'] = $app->doctor_id;
						   $data1['appt_id'] = $data['appt_id'];
						   
						   $data3['message'] = APPOINTMENT_CANCEL_BY_DOCTOR;
			 			   $data3['title']   = "Appointment.";

			 			   $isNotify = $this->model->get_notify('patients' , $app->patient_id);

					    }else if($data['type'] == "patient"){
					       $data1['user'] = $app->doctor_id;
						   $data1['type'] = 'doctor';
						   $data1['reference_id'] = $data['appt_id'];
						   $data1['appt_id'] = $data['appt_id'];
						   
						   $data3['message'] = APPOINTMENT_CANCEL_BY_PATIENT;
			 			   $data3['title']   = "Appointment.";

			 			   $isNotify = $this->model->get_notify('doctors' , $app->doctor_id);
					    }
					     
					    if($isNotify){
					    	$isSet = $this->model->set_notification($data1);

					    	if($isSet){
					    		if($data['type'] == "doctor"){
					    		   $data2['user'] = $app->patient_id;
					    		   $data2['type'] = 'patient';
					    		   $data2['reference_id'] = $app->doctor_id;
					    		   $data2['message'] = APPOINTMENT_CANCEL_BY_DOCTOR;
					    	    }else if($data['type'] == "patient"){
					    		   $data2['user'] = $app->doctor_id;
					    		   $data2['type'] = 'doctor';
					    		   $data2['reference_id'] = $app->patient_id;
					    		   $data2['message'] = APPOINTMENT_CANCEL_BY_PATIENT;
					    	    }
					    		
					    		$data2['title']   = 'cancel appointment';
					    		$data2['status']  = 'cancel';
					    		$this->model->send_push_notification($data2);
					    	}
					    }
					   
					    $data3['user'] = 1;
						$data3['type'] = "admin";
						$data3['status']  = 'cancel';
			            $data3['url']  = base_url('admin/appointments/get_appt/all');
						$this->model->send_push_notification($data3);

						$this->status  = 1;
						$this->message = APPOINTMENT_CANCELED;	
					}else{
						$this->status  = 0;
						$this->message = SOMETHING_WENT_WRONG;
					}	
										
				}else{

					$this->status  = 0;
					$this->message = CANT_CANCEL_APPOINTMENT;
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}


		public function notify()
		{
			$data = $this->input->post();
			if(empty($data['id'])){
				$this->status  = 0;
				$this->message = ID_REQUIRED;
			}else if(empty($data['type'])){
				$this->status  = 0;
				$this->message = TYPE_REQUIRED;
			}else if($data['notify'] == ""){
				$this->status  = 0;
				$this->message = NOTIFY_REQUIRED;
			}else{
				if($data['type'] == "doctor"){
					$table = "doctors";
				}else if($data['type'] == "patient"){
					$table = "patients";
				}

				$result = $this->model->change_notify($table , $data);

				if($result){
					$this->status  = 1;
					$this->message = SUCCESS;
				}else{

					$this->status  = 0;
					$this->message = SOMETHING_WENT_WRONG;
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

// 		public function get_patient_apptmnt()
// 		{
// 			$data = $this->input->post();

// 			if(empty($data['patient_id'])){
// 				$this->status  = 0;
// 				$this->message = "Patient id required."; 
// 			}else if(empty($data['type'])){
// 				$this->status  = 0;
// 				$this->message = "Type required.";
// 			}else{
// 				if($data['type'] == "date"){
					
// 					if(empty($data['date'])){
// 						$this->status  = 0;
// 						$this->message = "Date required.";	
// 					}else{ 
// 						$result = $this->model->get_patient_apptmnt($data);

// 						$this->data   = $result;
// 						$this->status = 1;
// 					}

// 				}else{
// 					$result = $this->model->get_patient_apptmnt($data);

// 					if($result){
// 						$this->data   = $result;
// 						$this->status = 1;	
// 					}else{
// 						$this->status  = 1;
// 						$this->message = "No data found!";
// 					}
					
// 				}
// 			}

// 			if($this->status != 1){
// 				$this->data = new stdClass();
// 			}

// 			$this->response();
// 		}
        public function get_patient_apptmnt()
		{
			$data = $this->input->post();

			if(empty($data['patient_id'])){
				$this->status  = 0;
				$this->message = PATIENT_ID_REQUIRED; 
			}else if(empty($data['type'])){
				$this->status  = 0;
				$this->message = TYPE_REQUIRED;
			}else{
				if($data['type'] == "date"){
					
					if(empty($data['date'])){
						$this->status  = 0;
						$this->message = DATE_REQUIRED;	
					}else{ 
						$result = $this->model->get_patient_apptmnt($data);

						foreach ($result as $key => $value) {
							if($value['profile_photo'] != ""){
								$result[$key]['profile_photo'] = DOCTOR_PIC_URL.$value['profile_photo'];
							}	
						}

						$this->data   = $result;
						$this->status = 1;
					}

				}else{
					$result = $this->model->get_patient_apptmnt($data);
					
					foreach ($result as $key => $value) {
						if($value['profile_photo'] != ""){
							$result[$key]['profile_photo'] = DOCTOR_PIC_URL.$value['profile_photo'];
						}	
					}

					if($result){
						$this->data   = $result;
						$this->status = 1;	
					}else{
						$this->status  = 1;
						$this->message = NO_DATA_FOUND;
					}
					
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}
		
		public function get_doctor_list()
		{	

			$result = $this->model->get_doctors_list();
			
			foreach ($result as $key => $value) {
				if($value['profile_photo'] != ""){
					$result[$key]['profile_photo'] = DOCTOR_PIC_URL.$value['profile_photo'];
				}	
			}
			
			$this->status = 1;
			$this->data   = $result;

			$this->response();
		}

		public function get_doctor_details()
		{
			$id = $this->input->post('doctor_id');
			if(empty($id)){
				$this->status  = 0;
				$this->message = PLEASE_ENTER_DOCTOR_ID; 
			}else{
				$doctor = $this->model->get_doctor_details($id);

				if($doctor->profile_photo != ""){
					$doctor->profile_photo = DOCTOR_PIC_URL.$doctor->profile_photo;
				}

				$this->status = 1;
				$this->data   = $doctor;
	
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}
		
			$this->response();
		}

		public function update_patient()
		{
			$valid = true;
			$data  = $this->input->post();

			if(empty($data['patient_id'])){
				$this->status  = 0;
				$this->message = PATIENT_ID_REQUIRED; 
			}else if(empty($data['fullname'])){
				$this->status  = 0;
				$this->message = FULLNAME_REQUIRED; 
			}else if(empty($data['age'])){
				$this->status  = 0;
				$this->message = AGE_REQUIRED; 
			}else if(empty($data['mobile'])){
				$this->status  = 0;
				$this->message = MOBILE_REQUIRED; 
			}else if(empty($data['countrycode'])){
				$this->status  = 0;
				$this->message = COUNTRY_CODE_REQUIRED; 
			}else if(empty($data['gender'])){
				$this->status  = 0;
				$this->message = GENDER_REQUIRED; 
			}else{

				$result = $this->model->update_patient_details($data ,$data['patient_id']);

				if($result){
					if(isset($_FILES['profile_image']) && $_FILES['profile_image']['name']){
					    $image_path = './uploads/patients_profile_images/';
					  
					    $path       = $_FILES['profile_image']['tmp_name'];
					    
					    $extension          = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
					    $allowed_extensions = [
					        'jpg',
					        'png',
					        'ogg',
					        'webm'
					    ];
					    if (!in_array($extension, $allowed_extensions)) {    
					        $valid = false;
					    }
					    
					    $filename  = date('dmyHis').'_'.$_FILES['profile_image']['name'];
					    $file = $image_path . $filename;

					    copy($path, $file);

					    $this->db->where('id' , $data['patient_id']);
					    $this->db->set('profile_photo' , $filename);
					    $this->db->update('patients');
					}

					if($valid == false){
				        $this->status  = 0;
						$this->message = THIS_TYPE_OF_FILE_NOT_ALLOWED;
					}else{
					    $user = $this->model->get_user('patients',$data['patient_id']);
						
						if($user['profile_photo'] != ""){
							$user['profile_photo'] = PATIENT_PIC_URL.$user['profile_photo'];
						}

						$this->status  = 1;
						$this->data    = $user;
						$this->message = PATIENT_DETAILS_UPDATED_SUCCESSFULLY;
					}
					
				}else{
					$this->status = 0;
					$this->message = SOMETHING_WENT_WRONG;
				}
				
			}
			
			if($this->status != 1){
				$this->data = new stdClass();
			}
			
			$this->response();
		}

		public function get_doctor_time()
		{
			$data = $this->input->post();
			if($data['doctor_id'] != "" && $data['date'] != ""){

				$appointments = $this->db->select('time')
			            				  ->where('doctor_id' , $data['doctor_id'])
			            				  ->where('date' , date('Y-m-d',strtotime($data['date'])))
			            				  ->where('status !=' , 'cancel')
			            				  ->get('appointments')->result_array();

				$this->db->where('id' , $data['doctor_id']);
				$this->db->select('appointment_time_slots AS time');
				$time = $this->db->get('doctors')->row();
				
				$hours = $this->db->where('doctor_id' , $data['doctor_id'])
						 		  ->get('consultation_hours')->result_array();
		        $temp = [];
			    foreach ($hours as $key => $each) {
			    	$return = '';// Define output
		    	    $StartTime    = strtotime ($each['from_time']); //Get Timestamp
		    	    $EndTime      = strtotime ($each['to_time']); //Get Timestamp

		    	    $AddMins  = $time->time * 60;

		    	    while ($StartTime <= $EndTime) 
		    	    {
		    	        $return = date ("h:i A", $StartTime);
		    	        if($return != date ("h:i A", $EndTime)){
		    	        	array_push($temp, $return);	
		    	        }
		    	        $StartTime += $AddMins; 
		    	    }
			    }
			    $data['time'] = $temp;
			    
			    $temp2 = [];
		    	foreach ($appointments as $apptmt) {
		    		$hh = date('h:i A',strtotime($apptmt['time']));
		    		array_push($temp2, $hh);
		    	}
			    $data['booked_appntmt'] = $temp2;

			    $this->status = 1;
			    $this->data   = $data;
			}else{
				$this->status  = 0;
				$this->message = ALL_FIELDS_REQUIRED;
			}

			$this->response();
		}

// 		public function add_appointment()
// 		{
// 			$data = $this->input->post();
// 			if(empty($data['patient_id'])){
// 				$this->status  = 0;
// 				$this->message = "Patient id required.";
// 			}else if(empty($data['doctor_id'])){
// 				$this->status  = 0;
// 				$this->message = "Doctor id required.";
// 			}else if(empty($data['date'])){
// 				$this->status  = 0;
// 				$this->message = "Date required.";
// 			}else if(empty($data['time'])){
// 				$this->status  = 0;
// 				$this->message = "Time required.";
// 			}else{
				
// 			    $tz = $this->db->select('time_zone')
// 							   ->where('user' , $data['patient_id'])
// 							   ->where('type' , 'patient')
// 							   ->get('user_devices')->row();
                
// 				date_default_timezone_set($tz->time_zone);
                
// 				if(isset($data['app_id']) && $data['app_id'] != ""){
				    
// 				    $patient_name     = $this->model->get_patient_name($data['patient_id']);	
// 					$data3['message']   = $patient_name ." book appointment for the time ". $data['date'] ." ". $data['time'];
					
// 					$data['date']		= date('Y-m-d' , strtotime($data['date']));
// 					$data['time']		= date('H:i:s' , strtotime($data['time']));
// 					$data['status']     = 'upcoming';
					
// 					$id = $data['app_id'];
// 					unset($data['app_id']);
// 					//note
// 					$this->db->where('id' , $id);
// 					$this->db->update('appointments', $data);
// 					$appt_id = $id;
					
// 					//send notification to admin
// 					//$data3['message'] = "Appointment updated.";
// 					$data3['title']   = "Appointment";
// 					$data3['user'] = 1;
// 					$data3['type'] = "admin";
// 					$data3['status']  = 'updated';
// 					$data3['url']  = base_url('admin/appointments/get_appt/all');
// 					$this->model->send_push_notification($data3);

// 					//send notification to doctor
// 					$isNotify = $this->model->get_notify('doctors' , $data['doctor_id']);

// 					if($isNotify){
// 						$data1['topic'] = 'update appointment';
// 						$data1['message'] = 'Appointment updated.';
// 						$data1['user'] = $data['doctor_id'];
// 						$data1['type'] = 'doctor';
// 						$data1['reference_id'] = $appt_id;
						
// 						$isSet = $this->model->set_notification($data1);

// 						if($isSet){
// 							$data2['user'] = $data['doctor_id'];
// 							$data2['type'] = 'doctor';
// 							$data2['message'] = 'Appointment updated.';
// 							$data2['title']   = 'appointment';
// 							$data2['reference_id'] = $data['patient_id'];
// 							$data2['status']  = 'updated';
// 							$this->model->send_push_notification($data2);
// 						}
// 					}

// 				}else{
// 					$data['status']     = 'upcoming';
// 					$data['added_date'] = date('Y-m-d H:i:s');
// 					$data['date']		= date('Y-m-d' , strtotime($data['date']));
// 					$data['time']		= date('H:i:s' , strtotime($data['time']));
// 					//note
// 					$this->db->insert('appointments', $data);
// 					$appt_id = $this->db->insert_id();
					
// 					if($appt_id > 0){
					    
// 					    //send mail to patient - START
// 		 				$temp = array(
// 		 						'date' => date('d-m-Y' , strtotime($data['date'])),
// 		 						'time' => date('h:i A' , strtotime($data['time'])),
// 		 						'doctor_id' => $data['doctor_id'],
// 		 						'patient_id'=> $data['patient_id'],
// 		 						'note' => isSet($data['note']) ? $data['note'] : ''
// 		 				);
// 		 				$this->model->send_appointment_mail($temp);
// 		 				//send mail to patient - END

//     					//send notification to admin
//     					$patient_name     = $this->model->get_patient_name($data['patient_id']);	
    					
// 					    $data3['message']   = $patient_name ." book appointment for the time ". date('d-m-Y' , strtotime($data['date'])) ." ". date('h:i A' , strtotime($data['time']));
//     					//$data3['message'] = "New Appointment Added.";
//     					$data3['title']   = "Appointment";
//     					$data3['user'] = 1;
//     					$data3['status']  = 'add';
//     					$data3['type'] = "admin";
//     					$data3['url']  = base_url('admin/appointments/get_appt/all');
//     					$this->model->send_push_notification($data3);
    
//     					//send notification to doctor
//     					$isNotify = $this->model->get_notify('doctors' , $data['doctor_id']);
    
//     					if($isNotify){
//     						$data1['topic'] = 'new appointment';
//     						$data1['message'] = 'New Appointment Added.';
//     						$data1['user'] = $data['doctor_id'];
//     						$data1['type'] = 'doctor';
//     						$data1['reference_id'] = $appt_id;
    						
//     						$isSet = $this->model->set_notification($data1);
    
//     						if($isSet){
//     							$data2['user'] = $data['doctor_id'];
//     							$data2['type'] = 'doctor';
//     							$data2['message'] = 'New Appointment Added.';
//     							$data2['title']   = 'new appointment';
//     							$data2['reference_id'] = $data['patient_id'];
//     							$data2['status']  = 'add';
//     							$this->model->send_push_notification($data2);
//     						}
// 						}	
// 					}
// 				// 	if($appt_id > 0){
// 				// 		$data3['message'] = "New Appointment Added.";
// 				// 		$data3['title']   = "Appointment";
// 				// 		$data3['user'] = 1;
// 				// 		$data3['type'] = "admin";
// 				// 		$data3['url']  = base_url('admin/appointments/get_appt/all');
// 				// 		$this->model->send_push_notification($data3);
// 				// 	}
					
// 				}

// 				if($appt_id > 0){
					
// 				// 	$isNotify = $this->model->get_notify('doctors' , $data['doctor_id']);

// 				// 	if($isNotify){
					    
//     // 					$data1['topic'] = 'new appointment';
//     // 					$data1['message'] = 'New Appointment Added.';
//     // 					$data1['user'] = $data['doctor_id'];
//     // 					$data1['type'] = 'doctor';
    					
//     // 					$isSet = $this->model->set_notification($data1);
    
//     // 					if($isSet){
//     // 						$data2['user'] = $data['doctor_id'];
//     // 						$data2['type'] = 'doctor';
//     // 						$data2['message'] = 'New Appointment Added.';
//     // 						$data2['title']   = 'new appointment';
//     // 						$data2['reference_id'] = $data['patient_id'];
//     // 						$this->model->send_push_notification($data2);
//     // 					}
// 				// 	}
					
// 					$apptmt = $this->db->select('appointments.date,appointments.time,doctors.fullname AS doctor_name')
// 									   ->from('appointments')
// 									   ->join('doctors','doctors.id = appointments.doctor_id')
// 					 		           ->where('appointments.id',$appt_id)
// 					 		           ->get()->row();
                   
// 				// 	$apptmt->date = date('d-m-Y' , strtotime($apptmt->date));
// 				// 	$apptmt->time = date('h:i A' , strtotime($apptmt->time));
					
// 					$this->status  = 1;
// 					$this->message = "Appointment save successfully..";
// 					$this->data    = $apptmt; 
					
// 				}else{
// 					$this->status  = 0;
// 					$this->message = "Somthing went wrong!!";
	
// 				}
				
// 			}

// 			$this->response();
			
// 		}
        public function add_appointment()
		{
			$data = $this->input->post();
			if(empty($data['patient_id'])){
				$this->status  = 0;
				$this->message = PATIENT_ID_REQUIRED;
			}else if(empty($data['doctor_id'])){
				$this->status  = 0;
				$this->message = DOCTOR_ID_REQUIRED;
			}else if(empty($data['date'])){
				$this->status  = 0;
				$this->message = DATE_REQUIRED;
			}else if(empty($data['time'])){
				$this->status  = 0;
				$this->message = TIME_REQUIRED;
			}else{
		        $tz = $this->db->select('time_zone')
							   ->where('user' , $data['patient_id'])
							   ->where('type' , 'patient')
							   ->get('user_devices')->row();
				
				date_default_timezone_set($tz->time_zone);

				if(isset($data['app_id']) && $data['app_id'] != ""){

					$data['date']		= date('Y-m-d' , strtotime($data['date']));
					$data['time']		= date('H:i:s' , strtotime($data['time']));
					$data['status']     = 'pending';

					$id = $data['app_id'];
					unset($data['app_id']);
					//note
					$this->db->where('id' , $id);
					$this->db->update('appointments', $data);
					$appt_id = $id;

					//send notification to admin
					$data3['message'] = APPOINTMENT_UPPDATED;
					$data3['title']   = "Appointment";
					$data3['user'] = 1;
					$data3['type'] = "admin";
					$data3['status']  = 'updated';
					$data3['url']  = base_url('admin/appointments/get_appt/all');
					$this->model->send_push_notification($data3);

					//send notification to doctor
					$isNotify = $this->model->get_notify('doctors' , $data['doctor_id']);

					if($isNotify){
						$data1['topic'] = 'Appointment';
						$data1['message'] = APPOINTMENT_UPPDATED;
						$data1['user'] = $data['doctor_id'];
						$data1['type'] = 'doctor';
						$data1['reference_id'] = $appt_id;
						$data1['appt_id'] = $appt_id;
						
						$isSet = $this->model->set_notification($data1);

						if($isSet){
							$data2['user'] = $data['doctor_id'];
							$data2['type'] = 'doctor';
							$data2['message'] = APPOINTMENT_UPPDATED;
							$data2['title']   = 'Appointment';
							$data2['reference_id'] = $data['patient_id'];
							$data2['status']  = 'updated';
							$this->model->send_push_notification($data2);
						}
					}

				}else{
					$data['status']     = 'pending';
					$data['added_date'] = date('Y-m-d H:i:s');
					$data['date']		= date('Y-m-d' , strtotime($data['date']));
					$data['time']		= date('H:i:s' , strtotime($data['time']));
					//note
					$this->db->insert('appointments', $data);
					$appt_id = $this->db->insert_id();
					
					if($appt_id > 0){
						
						//send mail to patient - START
		 				$temp = array(
		 						'date' => date('d-m-Y' , strtotime($data['date'])),
		 						'time' => date('h:i A' , strtotime($data['time'])),
		 						'doctor_id' => $data['doctor_id'],
		 						'patient_id'=> $data['patient_id'],
		 						'note' => isSet($data['note']) ? $data['note'] : ''
		 				);
		 				$this->model->send_appointment_mail($temp);
		 				//send mail to patient - END

						//send notification to admin
						$patient_name     = $this->model->get_name('patients', $data['patient_id']);	
						$doctor_name      = $this->model->get_name('doctors', $data['doctor_id']);   					
						$data3['message']   = $patient_name ." book appointment with doctor ".$doctor_name." for time  ". date('d-m-Y' , strtotime($data['date'])) ." ". date('h:i A' , strtotime($data['time']));
						
						//$data3['message'] = "New Appointment Added.";
						$data3['title']   = "New Appointment";
						$data3['user'] = 1;
						$data3['type'] = "admin";
						$data3['status']  = 'add';
						$data3['url']  = base_url('admin/appointments/get_appt/all');
						$this->model->send_push_notification($data3);

						//send notification to doctor
						$isNotify = $this->model->get_notify('doctors' , $data['doctor_id']);

						if($isNotify){
							$data1['topic'] = 'New appointment';
							//$data1['message'] = 'New Appointment Added.';
							$data1['message'] = $patient_name ." book appointment for the time ". date('d-m-Y' , strtotime($data['date'])) ." ". date('h:i A' , strtotime($data['time']));
							$data1['user'] = $data['doctor_id'];
							$data1['type'] = 'doctor';
							$data1['reference_id'] = $appt_id;
							$data1['appt_id'] = $appt_id;
							
							$isSet = $this->model->set_notification($data1);

							if($isSet){
								$data2['user'] = $data['doctor_id'];
								$data2['type'] = 'doctor';
								$data2['message'] = $patient_name ." book appointment for the time ". date('d-m-Y' , strtotime($data['date'])) ." ". date('h:i A' , strtotime($data['time']));
								//$data2['message'] = 'New Appointment Added.';
								$data2['title']   = 'New appointment';
								$data2['reference_id'] = $data['patient_id'];
								$data2['status']  = 'add';
								$this->model->send_push_notification($data2);
							}
						}	
					}
					
				}

				if($appt_id > 0){

					$apptmt = $this->db->select('appointments.date,appointments.time,doctors.fullname AS doctor_name')
									   ->from('appointments')
									   ->join('doctors','doctors.id = appointments.doctor_id')
					 		           ->where('appointments.id',$appt_id)
					 		           ->get()->row();
					$apptmt->date = date('d-m-Y' , strtotime($apptmt->date));
					$apptmt->time = date('h:i A' , strtotime($apptmt->time));		           			
					$this->status  = 1;
					$this->message = APPOINTMENT_SAVE_SUCCESSFULLY;
					$this->data    = $apptmt; 
					
				}else{
					$this->status  = 0;
					$this->message = SOMETHING_WENT_WRONG;
	
				}
				
			}
			
			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
			
		}
		

		public function change_appointment_status()
		{
			// $temp = [];
			$this->db->where('status' , 'upcoming');
			$data = $this->db->get('appointments')->result_array();
			
			foreach ($data as $key => $value) {

		        $tz = $this->db->select('time_zone')
    						   ->where('user' , $value['doctor_id'])
    						   ->where('type' , 'doctor')
    						   ->get('user_devices')->row();

    			if($tz->time_zone != ""){
    				date_default_timezone_set($tz->time_zone);
    			}
				
				$date = $value['date']." ".$value['time'];
				
				$time = strtotime($date);
				$Time = date("Y-m-d H:i", strtotime('+70 minutes', $time));
				
				$t = strtotime($Time);
				$current_time = time();
				
				if($current_time > $t){
					
					$this->db->where('id' , $value['id'])
							 ->set('status' , 'not attended')
							 ->update('appointments');

					//array_push($temp, $date);
					//change status to not attended
				}			
			}
			//print_r($temp);
		}

		public function get_notifications()
		{
			$data = $this->input->post();
			
			$notifications = $this->model->get_notification($data);

			$this->status 	= 1;
			$this->data 	= $notifications;

			$this->response();
		}

		public function get_month_apptmnt()
		{
			$data = $this->input->post();

			if($data['month'] == ""){
				$this->status  = 0;
				$this->message = MONTH_REQUIRED;
			}else if($data['year'] == ""){
				$this->status  = 0;
				$this->message = YEAR_REQUIRED;
			}else if($data['type'] == ""){
				$this->status  = 0;
				$this->message = TYPE_REQUIRED;
			}else{
				if($data['type'] == "doctor"){
					$result = $this->db->select('DISTINCT(date)')
								   ->where('YEAR(`date`)' , $data['year'])
								   ->where('MONTH(`date`)' , $data['month'])
								   ->where('doctor_id' , $data['id'])
								   ->get('appointments')->result_array();

				}else{
					$result = $this->db->select('DISTINCT(date)')
								   ->where('YEAR(`date`)' , $data['year'])
								   ->where('MONTH(`date`)' , $data['month'])
								   ->where('patient_id' , $data['id'])
								   ->get('appointments')->result_array();

				}
	
				//$result = $this->db->query('SELECT * FROM `appointments` WHERE YEAR(`date`) = "'.$data['year'].'" AND MONTH(`date`) = "'.$data['month'].'"')->result_array();   
 				$this->status = 1;
 				$this->data   = $result;
 				
			}

			$this->response();
		}
		
		public function get_cms_content()
		{
			$page_id = $this->input->post('page_id');

			if($page_id == ""){
				$this->status  = 0;
				$this->message = PAGE_ID_REQUIRED;
			}else{

				$result = $this->db->select('id AS page_id,page_name,slug,content')
								   ->where('id' , $page_id)
								   ->get('cms_pages')->row();

				$this->status = 1;
				$this->data   = $result;
			}

			$this->response();
		}
        
//         public function update_status()
// 		{
// 			$data = $this->input->post();
			
// 			if($data['appt_id'] == ""){
// 				$this->status  = 0;
// 				$this->message = "Appointment id required.";
// 			}else if($data['status'] == ""){
// 				$this->status  = 0;
// 				$this->message = "Status required.";
// 			}else{

// 				$result = $this->model->update_status($data);
				
// 				if($result){
// 					$this->status  = 1;
// 					$this->message = "Status changed successfully.";
// 				}else{
// 					$this->status  = 0;
// 					$this->message = "Somthing went wrong"; 
// 				}
// 			}

// 			$this->response();
// 		}
        
        
		public function update_status()
		{
			$data = $this->input->post();
			
			if($data['appt_id'] == ""){
				$this->status  = 0;
				$this->message = APPOINTMENT_ID_REQUIRED;
			}else if($data['status'] == ""){
				$this->status  = 0;
				$this->message = STATUS_REQUIRED;
			}else if($data['type'] == ""){
				$this->status  = 0;
				$this->message = TYPE_REQUIRED;
			}else{

				if($data['status'] == 'cancel'){

					$app = $this->db->select('date,time,patient_id,doctor_id')
									->where('id' , $data['appt_id'])
							        ->get('appointments')->row();

				    if($data['type'] == "doctor"){
				       $tz = $this->db->select('time_zone')
		    						  ->where('user' , $app->doctor_id)
		    						  ->where('type' , 'doctor')
		    						  ->get('user_devices')->row();

				    }else if($data['type'] == "patient"){
				       $tz = $this->db->select('time_zone')
		    						  ->where('user' , $app->patient_id)
		    						  ->where('type' , 'patient')
		    						  ->get('user_devices')->row();

				    }

				    date_default_timezone_set($tz->time_zone);

					$timestamp = strtotime($app->date ." ". $app->time);

					$time = $timestamp - (12 * 60 * 60);

					$datetime = date("Y-m-d H:i:s", $time);

					$now = strtotime(date('Y-m-d H:i:s'));

					if($now < strtotime($datetime)){
						$this->db->where('id' , $data['appt_id'])
								 ->update('appointments' , ['status' => 'cancel']);
						
						if($this->db->affected_rows() > 0){

							$data1['topic']   = 'cancel appointment';
							$data1['message'] = APPOINTMENT_CANCELED;
							
							if($data['type'] == "doctor"){
							   $data1['user'] = $app->patient_id;
							   $data1['type'] = 'patient';
							   $data1['reference_id'] = $app->doctor_id;
							   $data1['appt_id'] = $data['appt_id'];

							
							   $data3['message'] = APPOINTMENT_CANCEL_BY_DOCTOR;
				 			   $data3['title']   = "Appointment";

				 			   $isNotify = $this->model->get_notify('patients' , $app->patient_id);

						    }else if($data['type'] == "patient"){
						       $data1['user'] = $app->doctor_id;
							   $data1['type'] = 'doctor';
							   $data1['reference_id'] = $data['appt_id'];   
							   $data1['appt_id'] = $data['appt_id'];

							   $data3['message'] = APPOINTMENT_CANCEL_BY_PATIENT;
				 			   $data3['title']   = "Appointment";

				 			   $isNotify = $this->model->get_notify('doctors' , $app->doctor_id);
						    }

						     
						    if($isNotify){
						    	$isSet = $this->model->set_notification($data1);

						    	if($isSet){
						    		if($data['type'] == "doctor"){
						    		   $data2['user'] = $app->patient_id;
						    		   $data2['type'] = 'patient';
						    		   $data2['reference_id'] = $app->doctor_id;
						    		   $data2['message'] = APPOINTMENT_CANCEL_BY_DOCTOR;
						    	    }else if($data['type'] == "patient"){
						    		   $data2['user'] = $app->doctor_id;
						    		   $data2['type'] = 'doctor';
						    		   $data2['reference_id'] = $app->patient_id;
						    		   $data2['message'] = APPOINTMENT_CANCEL_BY_PATIENT;
						    	    }
						    		
						    		$data2['status']  = 'cancel';
						    		$data2['title']   = 'cancel appointment';
						    		
						    		$this->model->send_push_notification($data2);
						    	}
						    }
						   
						    $data3['user'] = 1;
							$data3['type'] = "admin";
							$data3['status']  = 'cancel';
				            $data3['url']  = base_url('admin/appointments/get_appt/all');
							$this->model->send_push_notification($data3);

							$this->status  = 1;
							$this->message = APPOINTMENT_CANCELED;	
						}else{
							$this->status  = 0;
							$this->message = SOMETHING_WENT_WRONG;
						}	
											
					}else{

						$this->status  = 0;
						$this->message = CANT_CANCEL_APPOINTMENT;
					}
				}else if($data['status'] == 'upcoming'){

					$app = $this->db->select('date,time,patient_id,doctor_id')
									->where('id' , $data['appt_id'])
							        ->get('appointments')->row();

				    if($data['type'] == "doctor"){
				       $tz = $this->db->select('time_zone')
		    						  ->where('user' , $app->doctor_id)
		    						  ->where('type' , 'doctor')
		    						  ->get('user_devices')->row();

				    }else if($data['type'] == "patient"){
				       $tz = $this->db->select('time_zone')
		    						  ->where('user' , $app->patient_id)
		    						  ->where('type' , 'patient')
		    						  ->get('user_devices')->row();

				    }

				    date_default_timezone_set($tz->time_zone);

					$timestamp = strtotime($app->date ." ". $app->time);

					$time = $timestamp - (12 * 60 * 60);

					$datetime = date("Y-m-d H:i:s", $time);

					$now = strtotime(date('Y-m-d H:i:s'));

					//if($now < strtotime($datetime)){
						$this->db->where('id' , $data['appt_id'])
								 ->update('appointments' , ['status' => 'upcoming']);
						
						if($this->db->affected_rows() > 0){

							$data1['topic']   = 'appointment schedule';
							$data1['message'] = YOUR_APPOINTMENT_ACCEPTED_BY_DOCTOR;
							
							if($data['type'] == "doctor"){
							   $data1['user'] = $app->patient_id;
							   $data1['type'] = 'patient';
							   $data1['reference_id'] = $app->doctor_id;
							   $data1['appt_id'] = $data['appt_id']; 
							
							   $data3['message'] = YOUR_APPOINTMENT_ACCEPTED_BY_DOCTOR;
				 			   $data3['title']   = "Appointment";

				 			   $isNotify = $this->model->get_notify('patients' , $app->patient_id);

						    }else if($data['type'] == "patient"){
						       $data1['user'] = $app->doctor_id;
							   $data1['type'] = 'doctor';
							   $data1['reference_id'] = $data['appt_id'];   
							   $data1['appt_id'] = $data['appt_id']; 

							   $data3['message'] = YOUR_APPOINTMENT_ACCEPTED_BY_PATIENT;
				 			   $data3['title']   = "Appointment";

				 			   $isNotify = $this->model->get_notify('doctors' , $app->doctor_id);
						    }

						     
						    if($isNotify){
						    	$isSet = $this->model->set_notification($data1);

						    	if($isSet){
						    		if($data['type'] == "doctor"){
						    		   $data2['user'] = $app->patient_id;
						    		   $data2['type'] = 'patient';
						    		   $data2['reference_id'] = $app->doctor_id;
						    		   $data2['message'] = YOUR_APPOINTMENT_ACCEPTED_BY_DOCTOR;
						    	    }else if($data['type'] == "patient"){
						    		   $data2['user'] = $app->doctor_id;
						    		   $data2['type'] = 'doctor';
						    		   $data2['reference_id'] = $app->patient_id;
						    		   $data2['message'] = YOUR_APPOINTMENT_ACCEPTED_BY_PATIENT;
						    	    }
						    		
						    		$data2['status']  = 'cancel';
						    		$data2['title']   = 'appointment accepted';
						    		
						    		$this->model->send_push_notification($data2);
						    	}
						    }
						   
						    $data3['user'] = 1;
							$data3['type'] = "admin";
							$data3['status']  = 'upcoming';
				            $data3['url']  = base_url('admin/appointments/get_appt/all');
							$this->model->send_push_notification($data3);

							$this->status  = 1;
							$this->message = APPOINTMET_ACCEPTED;	
						}else{
							$this->status  = 0;
							$this->message = SOMETHING_WENT_WRONG;
						}	
											
					//}else{

						//$this->status  = 0;
						//$this->message = CANT_ACCEPT_APPOINTMENT;
					//}


				}else{

					if($data['status'] == 'completed'){
						$app = $this->db->select('date,time,patient_id,doctor_id')
										->where('id' , $data['appt_id'])
								        ->get('appointments')->row();
					    
					    $tz = $this->db->select('time_zone')
		    						   ->where('user' , $app->doctor_id)
		    						   ->where('type' , 'doctor')
		    						   ->get('user_devices')->row();
					    
					    date_default_timezone_set($tz->time_zone);

						$time = strtotime($app->date ." ". $app->time);

						$datetime = date("Y-m-d H:i:s", $time);

						$now = strtotime(date('Y-m-d H:i:s'));

						if($now > strtotime($datetime)){
							$result = $this->model->update_status($data);
							
							if($result){
								$this->status  = 1;
								$this->message = STATUS_CHANGE_SUCCESSFULLY;
							}else{
								$this->status  = 0;
								$this->message = SOMETHING_WENT_WRONG; 
							}

						}else{
							$this->status  = 0;
							$this->message = CANT_COMPLETED_APPOINTMENT;
						}

					}else{
						$result = $this->model->update_status($data);
						if($result){
							$this->status  = 1;
							$this->message = STATUS_CHANGE_SUCCESSFULLY;
						}else{
							$this->status  = 0;
							$this->message = SOMETHING_WENT_WRONG; 
						}	
					}

				}

			}

			$this->response();
		}
        
        public function add_prescription()
		{
			$valid = true;

			$data = $this->input->post();
			
			if($data['appt_id'] == ""){
				$this->status  = 0;
				$this->message = APPOINTMENT_ID_REQUIRED;
			}else if($data['description'] == ""){
				$this->status  = 0;
				$this->message = DESCRIPTION_REQUIRED;
			}else{
				
				if(isset($_FILES['attachment']) && $_FILES['attachment']['name'] != ""){
				    
				    $image_path = './uploads/prescription_attachments/';
				  
				    $path       = $_FILES['attachment']['tmp_name'];
				    
				    $extension          = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
				    $allowed_extensions = [
				        'jpg',
				        'png',
				        'pdf'
				    ];

				    if (!in_array($extension, $allowed_extensions)) {    
				        $valid = false;
				    }else{
				    	$filename  = date('dmyHis').'_'.$_FILES['attachment']['name'];
				    	$file = $image_path . $filename;

				    	copy($path, $file);

				    	$data['added_date'] = date('Y-m-d H:i:s');
				    	$data['attachment'] = $filename;

				    	$this->db->insert('prescriptions',$data);
				    	$insert_id = $this->db->insert_id();
				    }
					
					if($valid == false){
						$this->status  = 0;
						$this->message = THIS_TYPE_OF_FILE_NOT_ALLOWED;
					}else if($insert_id > 0){
						$this->status  = 1;
						$this->message = PRESCRIPTION_ADDED;
					}else{
						$this->status  = 0;
						$this->message = SOMETHING_WENT_WRONG;
					}

				}else{

					$data['added_date'] = date('Y-m-d H:i:s');
					
					$this->db->insert('prescriptions',$data);
					$insert_id = $this->db->insert_id();
					
					if($insert_id > 0){
						$this->status  = 1;
						$this->message = PRESCRIPTION_ADDED;
					}else{
						$this->status  = 0;
						$this->message = SOMETHING_WENT_WRONG;
					}					
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

		public function edit_prescription()
		{
			$data = $this->input->post();
			
			if($data['presc_id'] == ""){
				$this->status  = 0;
				$this->message = PRESCIRPTION_ID_REQUIRED;
			}else if($data['description'] == ""){
				$this->status  = 0;
				$this->message = DESCRIPTION_REQUIRED;
			}else{
				
				$presc_id = $data['presc_id'];
				unset($data['presc_id']);

				if(isset($_FILES['attachment']) && $_FILES['attachment']['name'] != ""){
				    
				    $image_path = './uploads/prescription_attachments/';
				  
				    $path       = $_FILES['attachment']['tmp_name'];
				    
				    $extension          = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
				    $allowed_extensions = [
				        'jpg',
				        'png',
				        'pdf'
				    ];

				    if (!in_array($extension, $allowed_extensions)) {    
				        
				        $this->status  = 0;
				        $this->message = THIS_TYPE_OF_FILE_NOT_ALLOWED;

				    }else{
				    	$filename  = date('dmyHis').'_'.$_FILES['attachment']['name'];
				    	$file = $image_path . $filename;

				    	copy($path, $file);

				    	$data['last_updated'] = date('Y-m-d H:i:s');
				    	$data['attachment'] = $filename;

				    	$this->db->where('id' , $presc_id);
				    	$this->db->update('prescriptions',$data);

				   		$this->status  = 1;
				   		$this->message = PRESCRIPTION_UPDATED;
				    }

				}else{

					$data['last_updated'] = date('Y-m-d H:i:s');
					
					$this->db->where('id' , $presc_id);
					$this->db->update('prescriptions',$data);
					
					$this->status  = 1;
					$this->message = PRESCRIPTION_UPDATED;
										
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		} 
        
        public function get_prescription()
		{
			$data = $this->input->post();

			if($data['appt_id'] == ""){
				$this->status  = 0;
				$this->message = APPOINTMENT_ID_REQUIRED;
			}else{

				$presc = $this->db->where('appt_id' , $data['appt_id'])
						 		  ->get('prescriptions')->row();
				
				if(empty($presc)){
					$presc = '';
				}else{
					if($presc->attachment != ""){
						$presc->attachment = PRESCRIPTION_URL.$presc->attachment;  
					}
				}
				
				$this->status = 1;
				$this->data   = $presc; 
				
			}
			
			$this->response();
		}

        public function get_patient_list()
		{
			$data = $this->input->post();
			if($data['doctor_id'] == ""){
				$this->status  = 0;
				$this->message = DOCTOR_ID_REQUIRED; 
			}else{
				
				// Pagination	
    			$page 		= isset($_POST["page"]) ? (int)$_POST["page"] : 0;
    			$limit 		= isset($_POST["limit"]) ? (int)$_POST["limit"] : 0;
    			
    			if($page != 0 && $limit != 0){
    				
    		  		if($page == '' || $page <= 0){
    		  			$page = 1;
    		  		}

    		        if($limit != "") {
    		        	$page_size = $limit;
    		        }else{
    		        	$page_size = $this->mysqlPage_Size;
    				}

    				$this->db->limit($page_size * ($page - 1) , $page_size);
    		        
    			}
	    		
				$result = $this->db->select('DISTINCT(patient_id)')
								   ->where('doctor_id' , $data['doctor_id'])
								   ->get('appointments')->result_array();
				$temp = [];

				foreach ($result as $key => $value) {
					$patient = $this->db->select('id,fullname,mobile,age,gender,profile_photo')	
										->where('id',$value['patient_id'])
										->get('patients')->row();
					
					if($patient->profile_photo != ""){
						$patient->profile_photo = PATIENT_PIC_URL.$patient->profile_photo;
					}
					
					if($patient != null){
						array_push($temp, $patient);	
					}
					
				}
				
				$this->status = 1;
				$this->data   = $temp;
			}

			$this->response();

		}
		
		public function get_doctors_by_apptmnts()
		{
			$data = $this->input->post();
			if($data['patient_id'] == ""){
				$this->status  = 0;
				$this->message = PATIENT_ID_REQUIRED; 
			}else{
				
				// Pagination	
    			$page 		= isset($_POST["page"]) ? (int)$_POST["page"] : 0;
    			$limit 		= isset($_POST["limit"]) ? (int)$_POST["limit"] : 0;
    			
    			if($page != 0 && $limit != 0){
    				
    		  		if($page == '' || $page <= 0){
    		  			$page = 1;
    		  		}

    		        if($limit != "") {
    		        	$page_size = $limit;
    		        }else{
    		        	$page_size = $this->mysqlPage_Size;
    				}

    				$this->db->limit($page_size * ($page - 1) , $page_size);
    		        
    			}
	    		
				$result = $this->db->select('DISTINCT(doctor_id)')
								   ->where('patient_id' , $data['patient_id'])
								   ->get('appointments')->result_array();
				$temp = [];

				foreach ($result as $key => $value) {
					$doctor = $this->db->where('id' , $value['doctor_id'])
									   ->where('status' , 'active')
									   ->get('doctors')->row();
					
					if($doctor->profile_photo != ""){
						$doctor->profile_photo = DOCTOR_PIC_URL.$doctor->profile_photo;
					}

					if($doctor != null){
						array_push($temp, $doctor);	
					}
					
				}
				
				$this->status = 1;
				$this->data   = $temp;
			}

			$this->response();

		}
		
		public function appointment_list()
		{
			$data = $this->input->post();
			
			if($data['doctor_id'] == ""){
				$this->status  = 0;
				$this->message = DOCTOR_ID_REQUIRED;
			}else if($data['patient_id'] == ""){
				$this->status  = 0;
				$this->message = PATIENT_ID_REQUIRED;
			}else{
                // Pagination	
    			$page 		= isset($_POST["page"]) ? (int)$_POST["page"] : 0;
    			$limit 		= isset($_POST["limit"]) ? (int)$_POST["limit"] : 0;
    			
    			if($page != 0 && $limit != 0){
    				
    		  		if($page == '' || $page <= 0){
    		  			$page = 1;
    		  		}

    		        if($limit != "") {
    		        	$page_size = $limit;
    		        }else{
    		        	$page_size = $this->mysqlPage_Size;
    				}

    				$this->db->limit($page_size * ($page - 1) , $page_size);
    		        
    			}
	    		
				$result = $this->db->where('patient_id' , $data['patient_id'])
								   ->where('doctor_id' , $data['doctor_id'])
								   ->get('appointments')->result_array();
				if($result){
					$this->status = 1;
					$this->data   = $result;
				}else{
					$this->status = 1;
					$this->data   = NO_DATA_FOUND;
				}
			} 

			$this->response();
				
		}
        
        public function doctorFilterList()
        {
            $data = $this->input->post();

            if($data['filter_type'] == ""){

                $this->status  = 0;
                $this->message = "please_enter_filter_type";
            }else{

                $country =  isset($data['country']) ? $data['country'] : '';
                $city =  isset($data['city']) ? $data['city'] : '';

                $result = $this->model->get_town_city_list($data['filter_type'], $country , $city);

                if($result){
                    $this->status = 1;
                    $this->data   = $result;
                }else{
                    $this->status = 1;
                    $this->data   = NO_DATA_FOUND;
                }
            }
            $this->response();
        }
        
	}//main class
