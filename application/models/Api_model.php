<?php 
	class API_model extends CI_Model
	{
		public function __construct()
		{
			$this->load->database();
			$this->load->helper('message_helper');
		}

		public function debug()
		{
			print_r($this->db->last_query()); 
		}

	 	public function validate($table, $where)
	 	{
	 		if($table == 'doctors'){
	 			$this->db->where('status' ,'active');
	 		}

	 		$data = $this->db->select('count(*) AS cnt')
	 			->from($table)
	 			->where($where)
	 			->get()
	 			->row_array();

	 		return ($data['cnt'] == 1) ? true : false;	
	 	}

	 	public function get($table, $field, $where)
	 	{
	 		$data = $this->db->select($field)
	 			->from($table)
	 			->where($where)
	 			->get()
	 			->row_array();
	 	
	 		return ($this->db->affected_rows() == 1) ? $data[$field] : null;
	 	}

	 	public function get_user($table, $uId)
	 	{
	 		return $this->db->select('*')
	 			->from($table)
	 			->where('id', $uId)
	 			->get()
	 			->row_array();
	 	}
        
        public function get_notify($table , $uId)
	 	{
	 		$data =  $this->db->select('notification')
				 			->from($table)
				 			->where('id', $uId)
				 			->get()
				 			->row_array();
			
			return $data['notification'];							 				
	 	}
	 	
// 	 	public function set_user_device($data)
// 	 	{	
// 	 		$fields = array();

// 	 		$fields['udid'] 		= $data['udid'];
// 	 		$fields['type'] 		= $data['type'];
// 	 		$fields['device_type'] 	= $data['device_type'];
// 	 		$fields['os_version'] 	= $data['os_version'];
// 	 		$fields['handset'] 		= $data['handset'];
// 	 		$fields['ip_address'] 	= $data['ip_address'];
// 	 		$fields['time_zone'] 	= $data['time_zone'];
// 	 		// Check if user is already exists
// 	 		$newId = $this->model->get('user_devices', 'user', array('user'=>$data['user']));

// 	 		// Update record
// 	 		if($newId > 0){
// 	 			$this->db->update('user_devices', $fields, array("user" => $data['user']));
// 	 		// Insert data
// 	 		}else{
// 	 			$fields['user'] 		= $data['user'];
// 	 			$this->db->insert('user_devices', $fields);
// 	 			$newId = $this->db->insert_id();
// 	 		}

// 	 		return $newId > 0 ? true : false;	
// 	 	}
        
        public function set_user_device($data)
	 	{	
	 		$fields = array();

	 		$fields['udid'] 		= $data['udid'];
	 		$fields['type'] 		= $data['type'];
	 		$fields['device_type'] 	= $data['device_type'];
	 		$fields['os_version'] 	= $data['os_version'];
	 		$fields['handset'] 		= $data['handset'];
	 		$fields['ip_address'] 	= $data['ip_address'];
	 		$fields['time_zone'] 	= $data['time_zone'];
	 		
	 		$user = $this->db->select('user')
			 		         ->where('user' , $data['user'])
			 		         ->where('type' , $data['type'])
			 		         ->get('user_devices')->row_array();

	 		$newId = $user['user'];

	 		if($newId > 0){
	 			$this->db->where('user' , $data['user'])
			 		     ->where('type' , $data['type'])
			 			 ->update('user_devices', $fields);
	 		}else{
	 			$fields['user'] 		= $data['user'];
	 			$this->db->insert('user_devices', $fields);
	 			$newId = $this->db->insert_id();
	 		}
           
	 		return $newId > 0 ? true : false;	
	 	}

	 	public function patient_signup($data)
	 	{
	 		$data['type']     = 'registered';
	 		$data['reg_date'] = date('Y-m-d H:i:s');
	 		$data['password'] = md5($data['password']);
			
	 		$patient = $this->db->select('id,type')
					 			->from('patients')
					 			->where('mobile' ,$data['mobile'])
					 			->where('countrycode' ,$data['countrycode'])
								 ->where("type!='deleted'")
					 			->get()
					 			->row_array();
	 		if(!empty($patient['id']) && $patient['id'] > 0){

	 			if($patient['type'] == "guest"){

	 				$this->db->where('id' , $patient['id'])
	 						 ->update('patients' , $data);
	 				$id = $patient['id'];
	 			}else{

	 				$id = 0;
	 			}
	 		}else{

	 			$this->db->insert('patients', $data);
	 			$id = $this->db->insert_id();
	 		}
	 		return $id > 0 ? $id : false;	
	 	}

	 	public function update_email($table ,$data)
	 	{
	 		$this->db->where('id' , $data['id'])
	 				 ->set('email', $data['email'])
	 				 ->update($table);
	 		$count = $this->db->affected_rows();
	 		return $count > 0 ? true : false;
	 	}

	 	public function update_password($table ,$data)
	 	{
	 		$this->db->where('id' , $data['id'])
	 				 ->set('password', md5($data['new_password']))
	 				 ->update($table);
	 		$count = $this->db->affected_rows();
	 		return $count > 0 ? true : false;
	 	}

	 	public function update_patient_user_status($table ,$data)
	 	{
	 		$this->db->where('id' , $data['id']);
	 		$this->db->set('last_updated', 'NOW()', FALSE);
	 		$this->db->update($table, array(
				'otp_varified'=>$data['otp_varified']
			));
	 		//$count = $this->db->affected_rows();
	 		return $this->db->affected_rows() == 1 ? true : false;
	 		//return $count > 0 ? true : false;
	 	}

	 	public function otp_mobile($flag, $mobile , $countryCode)
	 	{
	 		$this->db->where(array('mobile'=> $mobile , 'countrycode'=> $countryCode));
	 		$this->db->delete('otp');

	 		$otp = rand(pow(10, 6-1), pow(10, 6)-1);
	 		$isInserted = $this->db->insert('otp', array(
	 			'mobile'=>$mobile, 
	 			'countrycode'=>$countryCode, 
	 			'otp'=>$otp
	 		));

	 		if(!$isInserted) return false;
	 		$fullmobile = $countryCode . $mobile;

	 		// SEND SMS WITH OTP
	 		$data=send_message( $fullmobile ,YOUR_OTP_FOR_MONDOC. $otp);

	 		return true;
	 	}


	 	public function otp($flag, $email)
	 	{
	 		// Remove previous OTPs if any from the same email
	 		$this->db->where('email', $email);
	 		$this->db->delete('otp');

	 		$otp = rand(pow(10, 6-1), pow(10, 6)-1);

	 		$this->db->set('date', 'NOW()', FALSE);
	 		$isInserted = $this->db->insert('otp', array(
	 			'email'=>$email, 
	 			'otp'=>$otp
	 		));
	 		
	 		if(!$isInserted) return false;

	 		// Send email with OTP
	 		$to 		= $email;
            		$subject 	=  EMAIL_SUBJ_VERIFY ;
            		$msg 		= "OTP to reset your password.\n OTP : " . $otp;
            
            		$this->email->from(OTP_FROM_EMAIL);
            		$this->email->to($to);
            		$this->email->message($msg);
            		$this->email->subject($subject);
            		$result = $this->email->send();

            		return $result;
	 	}

	 	public function set_password($table, $pwd, $where)
	 	{
	 		$this->db->where($where);
	 		$this->db->set('last_updated', 'NOW()', FALSE);
			$this->db->update($table, array(
				'password'=>md5($pwd)
			));	

			return $this->db->affected_rows() == 1 ? true : false;
	 	}
	 	public function set_patient_password($table, $pwd, $where)
	 	{
	 		$this->db->where($where);
	 		$this->db->set('last_updated', 'NOW()', FALSE);
			$this->db->update($table, array(
				'password'=>md5($pwd)
			));	

			return $this->db->affected_rows() == 1 ? true : false;
	 	}

	 	public function del($table, $where)
	 	{
	 		$this->db->where($where);
	 		$this->db->delete($table);

	 		return $this->db->affected_rows() == 1 ? true : false;
	 	}

	 	public function update_doctor_details($data , $id)
	 	{
	 		$data['last_updated'] = date('Y-m-d H:i:s');
	 		unset($data['doctor_id']);

	 		$this->db->where('id' , $id);
	 		$this->db->update('doctors' , $data);
	 		
	 		return $this->db->affected_rows() == 1 ? true : false;
	 	}

	 	public function get_doctor_apptmnt($data)
	 	{
	 		if($data['type'] == 'upcoming' || $data['type'] == 'completed' || $data['type'] == 'cancel' || $data['type'] == 'pending'){
	 		    $this->db->where('appointments.status',$data['type']);
	 		
	 		}else if($data['type'] == 'date'){
	 			$date = date('Y-m-d' , strtotime($data['date']));
	 			$this->db->where('appointments.date',$date);

	 		}

	 		$this->db->select('appointments.id,patients.fullname as patient_name,appointments.status,appointments.time,appointments.date');
	 		$this->db->from('appointments');
	 		$this->db->join('patients','patients.id=appointments.patient_id');
	 		$this->db->where('appointments.doctor_id' , $data['doctor_id']);
	 		$this->db->where('appointments.status !=' , 'deleted');
            		$this->db->order_by('appointments.date', 'desc');
            
	 		$appointments = $this->db->get()->result_array();
	 		return $appointments;
	 	}

	 	public function get_single_appointment($data)
	 	{
	 		$this->db->where('appointments.id',$data['id']);

	 		$this->db->select('appointments.id,patients.fullname as patient_name,appointments.status,appointments.time,appointments.date');
	 		$this->db->from('appointments');

	 		$this->db->join('patients','patients.id=appointments.patient_id');
	 		//$this->db->where('appointments.id' , $data['doctor_id']);
	 		// $this->db->where('appointments.status !=' , 'cancel');
            		$this->db->order_by('appointments.date', 'asc');
            
	 		$appointments = $this->db->get()->result_array();
	 		return $appointments;
	 	}

	 	public function update_doctor_time($data)
	 	{
	 		$this->db->where('id' , $data['doctor_id'])
	 				 ->update('doctors' , [
	 				 		'appointment_time_slots' => $data['appointment_time_slot'],
	 				 		'weekly_off_days'        => $data['weekly_off_days'],
	 				 		'last_updated'           => date('Y-m-d H:i:s'),
	 				 ]);
	 	    
			//add consultation hours
			
			$this->db->where('doctor_id' , $data['doctor_id']);
			$this->db->where('type','doctor');
			$this->db->delete('consultation_hours');
			
			$data1['type']       = 'doctor';
			$data1['doctor_id']  = $data['doctor_id'];

			foreach ($data['from_time'] as $key => $value) {

		        $data1['from_time'] = date("H:i", strtotime($value));
		        $data1['to_time']   = date("H:i", strtotime($data['to_time'][$key]));
		        
		        $this->db->insert('consultation_hours',$data1);
		        $insert_id = $this->db->insert_id();
		    }
			
			return $insert_id > 0 ? true : false;
	 	}

	 	public function view_apptmnt($id , $type)
	 	{
	 		/*$this->db->select('appointments.id,patients.fullname as patient_name,appointments.status,appointments.time,appointments.date,patients.profile_photo,patients.email,patients.mobile, patients.countrycode,patients.age,patients.gender,appointments.note');
	 			$this->db->from('appointments');
	 			$this->db->join('patients','patients.id=appointments.patient_id');
	 			$this->db->where('appointments.id' , $id);
	 			$appointments = $this->db->get()->row();

		 		return $appointments; */
		 		
	 		if($type == "doctor") {

	 			$this->db->select('appointments.id,patients.fullname as patient_name,appointments.status,appointments.time,appointments.date,patients.profile_photo,patients.email,patients.mobile, patients.countrycode,patients.age,patients.gender,appointments.note');
	 			$this->db->from('appointments');
	 			$this->db->join('patients','patients.id=appointments.patient_id');
	 			$this->db->where('appointments.id' , $id);
	 			$appointments = $this->db->get()->row();

		 		return $appointments;
	 		}else{

	 			$this->db->select('appointments.id,
	 				doctors.fullname as doctor_name,
	 				doctors.id as doctor_id,
	 				doctors.speciality,
	 				doctors.qualification,
	 				doctors.profile_photo,
	 				doctors.consultation_charges,
	 				doctors.experience,
	 				doctors.weekly_off_days,
	 				doctors.appointment_time_slots,
	 				appointments.time,
	 				appointments.date,
	 				appointments.status,	
	 				appointments.note');
	 			$this->db->from('appointments');
	 			$this->db->join('doctors','doctors.id=appointments.doctor_id');
	 			$this->db->where('appointments.id' , $id);
	 			$appointments = $this->db->get()->row();

	 			return $appointments;
	 		}
	 	}

	 	public function change_notify($table , $data)
	 	{
	 		$this->db->where('id' , $data['id'])
		 			 ->set('notification' , $data['notify'])
		 			 ->update($table);

	 		return $this->db->affected_rows() == 1 ? true : false;
	 	}

	 	public function get_patient_apptmnt($data)
	 	{
	 		if($data['type'] == 'pending' || $data['type'] == 'upcoming' || $data['type'] == 'completed' || $data['type'] == 'cancel' || $data['type'] == 'not attended'){
	 		    $this->db->where('appointments.status',$data['type']);
	 		
	 		}else if($data['type'] == 'date'){
	 			$date = date('Y-m-d' , strtotime($data['date']));
	 			$this->db->where('appointments.date',$date);

	 		}

	 		$this->db->select('appointments.id,doctors.fullname as doctor_name,appointments.status,appointments.time,appointments.date,doctors.id as doctor_id,doctors.speciality,doctors.qualification,doctors.profile_photo,appointments.note,doctors.consultation_charges,doctors.experience');
	 		$this->db->from('appointments');
	 		$this->db->join('doctors','doctors.id=appointments.doctor_id');
	 		$this->db->where('appointments.patient_id' , $data['patient_id']);
	 		//$this->db->where('appointments.status !=' , 'cancel');
	 		$this->db->order_by('appointments.date', 'desc');
	 		
	 		$appointments = $this->db->get()->result_array();
	 		return $appointments;
	 	}

	 	public function get_doctors_list()
	 	{
	 		$doctors = $this->db->where('status' , 'active')
	 							->get('doctors')->result_array();
	 		return $doctors;					
	 	}
        public function get_town_city_list($type, $country, $city){

                                               if($tpye == "country"){

                                                   $this->db->distinct();
                                                   $this->db->select('country');
                                                   $this->db->from('doctors');
                                                   $results  = $this->db->get()->result_array();
                                                   return $results;
                                               }else if($type == "city"){

                                                   $this->db->distinct();
                                                   $this->db->select('city');

                                                   if($country != ""){
                                                       $this->db->where('country' , $country);
                                                   }
                                                   $this->db->from('doctors');
                                                   $results  = $this->db->get()->result_array();
                                                   return $results;

                                               }else if($type == "town"){
                                                   $this->db->distinct();
                                                   $this->db->select('town');
                                                   if($country != ""){
                                                       $this->db->where('country' , $country);
                                                   }
                                                   if($city != ""){
                                                       $this->db->where('city' , $city);
                                                   }
                                                   $this->db->from('doctors');
                                                   $results  = $this->db->get()->result_array();
                                                   return $results;
                                               }
        }

	 	public function get_doctor_details($id)
	 	{
	 		$doctor = $this->db->where('id' , $id)
	 						   ->get('doctors')->row();
	 		
	 		$this->db->where('doctor_id' , $id);
			$hours = $this->db->get('consultation_hours')->result_array();
			$temp = [];
			foreach ($hours as $key => $each) {
				$time = date('h:i A', strtotime($each['from_time'])) .' To '. date('h:i A', strtotime($each['to_time']));;

				array_push($temp, $time);
			}
			
			$doctor->time_schedule = implode(" , ", $temp);
			
	 		return $doctor;	
	 	}

	 	public function update_patient_details($data , $id)
	 	{
	 		$data['last_updated'] = date('Y-m-d H:i:s');
	 		unset($data['patient_id']);

	 		$this->db->where('id' , $id)
	 				 ->update('patients',$data);

	 		return $this->db->affected_rows() == 1 ? true : false;	
	 	}

	 	public function get_notification($data)
	 	{
	 		$fields = array();
	 		$fields[] = "b.id";
	 		$fields[] = "b.topic";
	 		$fields[] = "b.message";
	 		$fields[] = "b.broadcast_date";

	 		
	 		if($data['type'] == 'patient'){
	 		    $fields[] = "r.reference_id AS doctor_id";
	 		    $fields[] = "r.appt_id AS appointment_id";
	 		}else{
	 		    $fields[] = "r.reference_id AS appointment_id";
	 		}
	 		
	 		$fields = implode(',', $fields);

	 		$notifications = $this->db->select($fields)
	 			->from('broadcast b')
	 			->join('broadcast_recipients r', 'r.broadcast = b.id')
	 			->where('r.user', $data['user'])
	 			->where('r.type', $data['type'])
	 			->order_by('b.broadcast_date','desc')
	 			->get()
	 			->result_array();

	 		return $notifications;	
	 	}

	 	public function send_push_notification($data)
	 	{	
	 		$udid	 = $this->db->select('udid')
							   ->where('user' , $data['user'])
							   ->where('type' , $data['type'])
							   ->get("user_devices")->row();
			
 			$message = $data["message"];
 			$title 	 = $data["title"];
 			
 			if(isset($data["url"]) && $data["url"] != ""){
 			    $url = $data['url'];
 			}else{
 				$url = "";
 			}
	 		
	 		$oneSignals = $this->db->get('onesignals')->row();
	 		
	 		if($data['type'] == 'patient'){
	 			//$oneSignal = ONE_SIGNAL_PATIENT_APP_ID;
	 			
	 			$oneSignal = $oneSignals->patient;
	 		}else{
	 			//$oneSignal = ONE_SIGNAL_APP_ID; 
	 			$oneSignal = $oneSignals->doctor; 
	 		}	
	 		if(!empty($udid->udid)){
				$player_ids = $udid->udid;
					
				$contents = array(
					"en" => $message
				);
				$headings = array(
					"en" => $title
				);
			
				$fields = array(
					'app_id' => $oneSignal,
					'include_player_ids' => array($player_ids),
					'data' => array("foo" => "bar","status" => $data['status']),
					'contents' => $contents,
					'headings' => $headings,
					'priority' => 10,
					'url'=> $url
				);
					
				$fields = json_encode($fields);
					
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);
				curl_setopt($ch, CURLOPT_POST, TRUE);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
				$response = curl_exec($ch);
				curl_close($ch);
			}
            //return $response;
	 	}

	 	public function set_notification($data)
	 	{
			$data1['topic']    = $data['topic'];
			$data1['message']  = $data['message'];
			$data1['reg_date'] = date('Y-m-d H:i:s');
			$data1['broadcast_date'] = date('Y-m-d H:i:s');
			$data1['is_sent']  = '1';

			$this->db->insert('broadcast' ,$data1);
			$insert_id  = $this->db->insert_id();

			if($insert_id > 0){
				$this->db->insert('broadcast_recipients' , [
							 'broadcast' => $insert_id,
							 'user'      => $data['user'],
							 'type'      => $data['type'],
							 'reference_id' => $data['reference_id'],
							 'appt_id' => $data['appt_id']
						   ]);
			}

			return $insert_id > 0 ? true : false;
		}
        
        public function update_status($data)
		{
			$this->db->set('status' , $data['status'])
					 ->where('id' , $data['appt_id'])
					 ->update('appointments');

			return $this->db->affected_rows() == 1 ? true : false;		
		}
		
		public function send_appointment_mail($data)
		{
		    $doctor = $this->db->select('fullname')
		                       ->from('doctors')
		                       ->where('id',$data['doctor_id'])
		                       ->get()->row();
		                       
		    $patient = $this->db->select('email')
		    			        ->from('patients')
		    			        ->where('id' , $data['patient_id'])
		    			        ->get()->row();
		    
		    $to = $patient->email;

		    $msg = '<table style="max-width:600px; margin: 0px auto; border: #7f90ff 1px solid; padding: 0px; width: 100%; border-collapse: collapse;">
		        <tbody>
		            <tr>
		                <td style="border: #7f90ff 1px solid; width: 25%; padding: 7px 10px;">Doctor Name:</td>
		                <td style="border: #7f90ff 1px solid; width: 75%; padding: 7px 10px;"> Dr. '. $doctor->fullname .'</td>
		            </tr>
		            <tr>
		                <td style="border: #7f90ff 1px solid; width: 25%; padding: 7px 10px;">Date:</td>
		                <td style="border: #7f90ff 1px solid; width: 75%; padding: 7px 10px;">' . $data['date'] . '</td>
		            </tr>
		            <tr>
		                <td style="border: 1px solid #7f90ff; width: 25%; padding: 7px 10px;">Time:</td>
		                <td style="border: 1px solid #7f90ff; width: 75%; padding: 7px 10px;">' . $data['time'] . '</td>
		            </tr>
		            <tr>
		                <td style="border: 1px solid #7f90ff; width: 25%; padding: 7px 10px;">Note:</td>
		                <td style="border: 1px solid #7f90ff; width: 75%; padding: 7px 10px;">' . $data['note'] . '</td>
		            </tr>
		        </tbody>
		        </table>';

		    $subject = "Doctor Appointment";
		    
		    $this->email->from('mitul.bhadeshiya@gmail.com');
		    $this->email->to($to);
		    $this->email->message($msg);
		    $this->email->subject($subject);

		    $result = $this->email->send();
		    
		    return 1;
		    
		}  
		
		public function get_name($table, $id)
		{
			$data = $this->db->select('fullname')
					 		 ->where('id' , $id)
		 			         ->get($table)->row();
		    return $data->fullname;
		}
		
		
	}//main class
