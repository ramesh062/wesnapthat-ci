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

			if(empty($data['email']) || empty($data['password'])){
				
				$this->status 	= 0;
				$this->message 	= "Email address and Password Both Required.";
			}else{
				
				if($data['type'] == "doctor"){
					
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

						$this->status 	= 1;
						$this->data 	= array('doctor'=>$user ,'settings'=>$settings);
					}else{

						$this->status 	= 0;
						$this->message 	= "Invalid Email or Password";
					}
				}else if($data['type'] == "patient"){
					
					$isValidUser = $this->model->validate('patients', array('email'=>$data['email'], 'password'=>md5($data['password'])));
					
					if($isValidUser){
						// Get user details
						$uId = $this->model->get('patients', 'id', array('email'=>$data['email'], 'password'=>md5($data['password'])));
						$user = $this->model->get_user('patients',$uId);

						// Set user device info
						$device_info = array(
							'user' 			=> $uId,
							'type'			=> isset($data['type']) ? $data['type'] : '',
							'udid' 			=> isset($data['udid']) ? $data['udid'] : '',
							'device_type' 	=> isset($data['device_type']) ? $data['device_type'] : '',
							'os_version' 	=> isset($data['os_version']) ? $data['os_version'] : '',
							'handset' 		=> isset($data['handset']) ? $data['handset'] : '',
							'ip_address' 	=> isset($data['ip_address']) ? $data['ip_address'] : ''
						);
						$this->model->set_user_device($device_info);

						if($user['profile_photo'] != ""){
							$user['profile_photo'] = PATIENT_PIC_URL.$user['profile_photo'];
						}

						$settings = $this->db->select('admin.hospital_name,admin.address,admin.phone,currency_table.name as currency_name,currency_table.sign as currency_sign')
											 ->from('admin')
											 ->join('currency_table' ,'admin.currency = currency_table.id')
											 ->get()->row();

						$this->status 	= 1;
						$this->data 	= array('patient'=>$user ,'settings'=>$settings);
					}else{

						$this->status 	= 0;
						$this->message 	= "Invalid Email or Password";
					}
				}else{

					$this->status 	= 0;
					$this->message 	= "Please enter type.";
				}
				
			}

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
				$this->message = "Please enter fullname";
			}else if($data['email'] == ""){
				$this->status  = 0;
				$this->message = "Please enter email address";
			}else if($data['mobile'] == ""){
				$this->status  = 0;
				$this->message = "Please enter mobile number";
			}else if($data['age'] == ""){
				$this->status  = 0;
				$this->message = "Please enter age";
			}else if($data['gender'] == ""){
				$this->status  = 0;
				$this->message = "Please select gender";
			}else if($data['password'] == ""){
				$this->status  = 0;
				$this->message = "Please enter password";
			}else{
				$id = $this->model->patient_signup($data);
				if($id == false){

					$this->status  = 0;
					$this->message = "Email already exist..";
				}else{
					
					$user = $this->model->get_user('patients',$id);
					if($user['profile_photo'] != ""){
						$user['profile_photo'] = PATIENT_PIC_URL.$user['profile_photo'];
					}
					$settings = $this->db->select('admin.hospital_name,admin.address,admin.phone,currency_table.name as currency_name,currency_table.sign as currency_sign')
										 ->from('admin')
										 ->join('currency_table' ,'admin.currency = currency_table.id')
										 ->get()->row();
					$this->status 	= 1;
					$this->data 	= array('patient'=>$user ,'settings'=>$settings);
					$this->message = "Patient registered successfully..";
				}
			}	

			if($this->status != 1){
				$this->data = new stdClass();
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
			$this->data 	= array('settings'=>$settings);

			$this->response();
		}

		public function change_email()
		{
			$data = $this->input->post();

			if($data['id'] == ""){
				$this->status  = 0;
				$this->message = "Please enter id.";
			}else if($data['type'] == ""){
				$this->status  = 0;
				$this->message = "Please enter type.";
			}else if($data['email'] == ""){
				$this->status  = 0;
				$this->message = "Please enter email address.";
			}else{
				if($data['type'] == "doctor"){
					$id = $this->model->update_email('doctors',$data);
				}else{
					$id = $this->model->update_email('patients',$data);
				}

				if($id){
					$this->status  = 1;
					$this->message = "Email updated.";
				}else{
					$this->status  = 0;
					$this->message = "Somthing went wrong";
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

		public function change_password()
		{
			$data = $this->input->post();

			if($data['id'] == ""){
				$this->status  = 0;
				$this->message = "Please enter id.";
			}else if($data['type'] == ""){
				$this->status  = 0;
				$this->message = "Please enter type.";
			}else if($data['password'] == ""){
				$this->status  = 0;
				$this->message = "Please enter password.";
			}else{
				if($data['type'] == "doctor"){
					$id = $this->model->update_password('doctors',$data);
				}else{
					$id = $this->model->update_password('patients',$data);
				}

				if($id){
					$this->status  = 1;
					$this->message = "Password updated.";
				}else{
					$this->status  = 0;
					$this->message = "Somthing went wrong";
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
				$this->message 	= "Please enter your email address";
			
			}else if(empty($data['type'])){
				$this->status 	= 0;
 				$this->message 	= "Please enter type";

			}else{
				
				if($data['type'] == 'doctor'){
					$isValidUser = $this->model->validate('doctors', array('email'=>$data['email']));
				
				}else if($data['type'] == 'patient'){
					$isValidUser = $this->model->validate('patients', array('email'=>$data['email']));
				
				}

				if(!$isValidUser){
					$this->status 	= 0;
					$this->message 	= "Invalid user.";
				
				}else{
					// Send OTP 
					$isOTPSent = $this->model->otp('send', $data['email']);

					if(!$isOTPSent){
						$this->status 	= 0;
						$this->message 	= "Sorry, we are unable to send you OTP. Please try again or contanct support.";

					}else{
						$this->status 	= 1;
						$this->message 	= "We have sent an OTP to your email address. Kindly confirm.";
					}
				}
			}

			$this->response();
		}

		public function verify_otp()
		{
			$email 	= $this->input->post('email');
			$otp 	= $this->input->post('otp');

			if(empty($email) || empty($otp)){
				$this->status 	= 0;
				$this->message 	= "Email or OTP missing.";

			}else{
				// Validate email and otp
				$isValidOTP = $this->model->validate('otp', array('email'=>$email, 'otp'=>$otp));

				if($isValidOTP){
					$this->status 	= 1;
					$this->message 	= "OTP verified successfully.";
				
				}else{
					$this->status 	= 0;
					$this->message 	= "Verification failed.";
				
				}
			}

			$this->response();
		}

		public function set_password()
		{
			$isPwdChanged = false;
			$data 	= $this->input->post();
			
			// Validate passwords
			if(empty($data['new_password']) || empty($data['confirm_password']) || empty($data['type'])){
				$this->status 	= 0;
				$this->message 	= "All fields required.";

			}else if($data['new_password'] != $data['confirm_password']){
				$this->status 	= 0;
				$this->message 	= "Confirm password does not match.";

			}else{
				// Validate email and otp
				$isValidOTP = $this->model->validate('otp', array('email'=>$data['email'], 'otp'=>$data['otp'])); 

				if(!$isValidOTP){ 
					$this->status 	= 0;
					$this->message 	= "Sorry, we cannot accept the request. Please try again or contact support.";

				}else{

					if($data['type'] == 'doctor'){
						$isPwdChanged = $this->model->set_password('doctors', $data['new_password'], array('email'=>$data['email'])); 

					}else if($data['type'] == 'patient'){
						$isPwdChanged = $this->model->set_password('patients', $data['new_password'], array('email'=>$data['email'])); 
					
					}	
					
					if($isPwdChanged){
						// Delete OTP
						$this->model->del('otp', array('email'=>$data['email']));

						$this->status 	= 1;
						$this->message 	= "Password has been changed successfully.";
					}else{
						$this->status 	= 0;
						$this->message 	= "Sorry, we could not change your password. Try again or contact support.";
					}
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
				$this->message 	= "Fullname required.";
			}else if(empty($data['qualification'])){
				$this->status 	= 0;
				$this->message 	= "Qualification required.";
			}else if(empty($data['speciality'])){
				$this->status 	= 0;
				$this->message 	= "Speciality required.";
			}else if(empty($data['experience'])){
				$this->status 	= 0;
				$this->message 	= "Experience required.";
			}else if(empty($data['gender'])){
				$this->status 	= 0;
				$this->message 	= "Gender required.";
			}else if(empty($data['consultation_charges'])){
				$this->status 	= 0;
				$this->message 	= "Consultation charges required.";
			}else{
				$id  = isset($data['doctor_id']) ? $data['doctor_id'] : "";
				if($id == ""){
					$this->status 	= 0;
					$this->message 	= "Doctor id required.";	
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
							$this->message = "This type of file not allowed.";
						}else{
							$this->status  = 1;
							$this->message = "Doctor details update successfully..";
						}
						
					}else{
						$this->status  = 0;
						$this->message = "Somthing went wrong!";
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
				$this->message = "Doctor id required."; 
			}else if(empty($data['type'])){
				$this->status  = 0;
				$this->message = "Type required.";
			}else{
				if($data['type'] == "date"){
					
					if(empty($data['date'])){
						$this->status  = 0;
						$this->message = "Date required.";	
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
						$this->message = "No data found!";
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
				$this->message = "Please enter doctor id."; 
			}else if(empty($data['appointment_time_slot'])){
				$this->status  = 0;
				$this->message = "Please enter Appointment time slot."; 
			}else if(empty($data['from_time']) || empty($data['to_time'])){
				$this->status  = 0;
				$this->message = "Please select consultation hours.";  
			}else if(empty($data['weekly_off_days'])){
				$this->status  = 0;
				$this->message = "Please select weekly off days.";
			}else{
				$result  = $this->model->update_doctor_time($data);
				
				if($result){
					$this->status  = 1;
					$this->message = "Success..";	
				}else{
					$this->status  = 0;
					$this->message = "Somthing went wrong!";
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
				$this->message = "Appointment id required.."; 
			}else{
				$result = $this->model->view_apptmnt($data['appt_id']);

				if(!empty($result)){

					if($result->profile_photo != ""){						
						$result->profile_photo = PATIENT_PIC_URL.$result->profile_photo;
					}

					$this->status = 1;
					$this->data   = $result;
				}else{
					$this->status = 0;
					$this->data   = "Somthing went wrong!!";
				}
			}

			if($this->status != 1){
				$this->data = new stdClass();
			}

			$this->response();
		}

		public function cancel_appointment()
		{
			$data = $this->input->post();
			
			if(empty($data['appt_id'])){
				$this->status  = 0;
				$this->message = "Appointment id required."; 
			}else if(empty($data['type'])){
				$this->status  = 0;
				$this->message = "Type required.";
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
						$data1['message'] = 'Appointment Canceled.';
						
						if($data['type'] == "doctor"){
						   $data1['user'] = $app->patient_id;
						   $data1['type'] = 'patient';
							
						   $data3['message'] = "Appointment Cancel by doctor.";
			 			   $data3['title']   = "Appointment.";

					    }else if($data['type'] == "patient"){
					       $data1['user'] = $app->doctor_id;
						   $data1['type'] = 'doctor';
							
						   $data3['message'] = "Appointment Cancel by patient.";
			 			   $data3['title']   = "Appointment.";
					    }

						$isSet = $this->model->set_notification($data1);

						if($isSet){
							if($data['type'] == "doctor"){
							   $data2['user'] = $app->patient_id;
							   $data2['type'] = 'patient';
							   $data2['reference_id'] = $app->doctor_id;

						    }else if($data['type'] == "patient"){
							   $data2['user'] = $app->doctor_id;
							   $data2['type'] = 'doctor';
							   $data2['reference_id'] = $app->patient_id;
						    }
							$data2['message'] = 'Appointment Canceled.';
							$data2['title']   = 'cancel appointment';
							
							$this->model->send_push_notification($data2);
						}
					    
					    $data3['user'] = 1;
						$data3['type'] = "admin";
			            $data3['url']  = base_url('admin/appointments/get_appt/all');
						$this->model->send_push_notification($data3);

						$this->status  = 1;
						$this->message = "Appointment Canceled.";	
					}else{
						$this->status  = 0;
						$this->message = "Somthing went wrong!!";
					}	
										
				}else{

					$this->status  = 0;
					$this->message = "Can't cancel appointment.";
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
				$this->message = "Id required.";
			}else if(empty($data['type'])){
				$this->status  = 0;
				$this->message = "Type required.";
			}else if($data['notify'] == ""){
				$this->status  = 0;
				$this->message = "Notify required.";
			}else{
				if($data['type'] == "doctor"){
					$table = "doctors";
				}else if($data['type'] == "patient"){
					$table = "patients";
				}

				$result = $this->model->change_notify($table , $data);

				if($result){
					$this->status  = 1;
					$this->message = "Success..";
				}else{

					$this->status  = 0;
					$this->message = "Somthing went wrong";
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
				$this->message = "Patient id required."; 
			}else if(empty($data['type'])){
				$this->status  = 0;
				$this->message = "Type required.";
			}else{
				if($data['type'] == "date"){
					
					if(empty($data['date'])){
						$this->status  = 0;
						$this->message = "Date required.";	
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
						$this->message = "No data found!";
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
				$this->message = "Please enter doctor id."; 
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
				$this->message = "Patient id required."; 
			}else if(empty($data['fullname'])){
				$this->status  = 0;
				$this->message = "Fullname required."; 
			}else if(empty($data['age'])){
				$this->status  = 0;
				$this->message = "Age required."; 
			}else if(empty($data['mobile'])){
				$this->status  = 0;
				$this->message = "mobile required."; 
			}else if(empty($data['email'])){
				$this->status  = 0;
				$this->message = "Email required."; 
			}else if(empty($data['gender'])){
				$this->status  = 0;
				$this->message = "Gender required."; 
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
						$this->message = "This type of file not allowed.";
					}else{
					    $user = $this->model->get_user('patients',$data['patient_id']);
						
						if($user['profile_photo'] != ""){
							$user['profile_photo'] = PATIENT_PIC_URL.$user['profile_photo'];
						}

						$this->status  = 1;
						$this->data    = $user;
						$this->message = "Patient details update successfully..";
					}
					
				}else{
					$this->status = 0;
					$this->message = "Somthing went wrong!";
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
				$this->message = "All fields required!";
			}

			$this->response();
		}

		public function add_appointment()
		{
			$data = $this->input->post();
			if(empty($data['patient_id'])){
				$this->status  = 0;
				$this->message = "Patient id required.";
			}else if(empty($data['doctor_id'])){
				$this->status  = 0;
				$this->message = "Doctor id required.";
			}else if(empty($data['date'])){
				$this->status  = 0;
				$this->message = "Date required.";
			}else if(empty($data['time'])){
				$this->status  = 0;
				$this->message = "Time required.";
			}else{
				
				if(isset($data['app_id']) && $data['app_id'] != ""){
					$data['date']		= date('Y-m-d' , strtotime($data['date']));
					$data['time']		= date('H:i:s' , strtotime($data['time']));
					$id = $data['app_id'];
					unset($data['app_id']);
					//note
					$this->db->where('id' , $id);
					$this->db->update('appointments', $data);
					$appt_id = $id;

				}else{
					$data['status']     = 'upcoming';
					$data['added_date'] = date('Y-m-d H:i:s');
					$data['date']		= date('Y-m-d' , strtotime($data['date']));
					$data['time']		= date('H:i:s' , strtotime($data['time']));
					//note
					$this->db->insert('appointments', $data);
					$appt_id = $this->db->insert_id();
					
					if($appt_id > 0){
						$data3['message'] = "New Appointment Added.";
						$data3['title']   = "Appointment";
						$data3['user'] = 1;
						$data3['type'] = "admin";
						$data3['url']  = base_url('admin/appointments/get_appt/all');
						$this->model->send_push_notification($data3);
					}
					
				}

				if($appt_id > 0){
					
					$data1['topic'] = 'new appointment';
					$data1['message'] = 'New Appointment Added.';
					$data1['user'] = $data['doctor_id'];
					$data1['type'] = 'doctor';
					
					$isSet = $this->model->set_notification($data1);

					if($isSet){
						$data2['user'] = $data['doctor_id'];
						$data2['type'] = 'doctor';
						$data2['message'] = 'New Appointment Added.';
						$data2['title']   = 'new appointment';
						$data2['reference_id'] = $data['patient_id'];
						$this->model->send_push_notification($data2);
					}

					$apptmt = $this->db->select('appointments.date,appointments.time,doctors.fullname AS doctor_name')
									   ->from('appointments')
									   ->join('doctors','doctors.id = appointments.doctor_id')
					 		           ->where('appointments.id',$appt_id)
					 		           ->get()->row();

					$this->status  = 1;
					$this->message = "Appointment save successfully..";
					$this->data    = $apptmt; 
					
				}else{
					$this->status  = 0;
					$this->message = "Somthing went wrong!!";
	
				}
				
			}

			$this->response();
			
		}

		public function change_appointment_status()
		{
			// $temp = [];
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
					if($value['status'] != "completed"){
						$this->db->where('id' , $value['id'])
								 ->set('status' , 'not attended')
								 ->update('appointments');
	
					}
					
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
				$this->message = "Month required.";
			}else if($data['year'] == ""){
				$this->status  = 0;
				$this->message = "Year required.";
			}else if($data['type'] == ""){
				$this->status  = 0;
				$this->message = "Type required.";
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

	}//main class