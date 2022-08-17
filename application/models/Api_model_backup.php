<?php 
	class API_model extends CI_Model
	{
		public function __construct()
		{
			$this->load->database();
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

	 	public function set_user_device($data)
	 	{	
	 		$fields = array();

	 		$fields['udid'] 		= $data['udid'];
	 		$fields['type'] 		= $data['type'];
	 		$fields['device_type'] 	= $data['device_type'];
	 		$fields['os_version'] 	= $data['os_version'];
	 		$fields['handset'] 		= $data['handset'];
	 		$fields['ip_address'] 	= $data['ip_address'];
	 		// Check if user is already exists
	 		$newId = $this->model->get('user_devices', 'user', array('user'=>$data['user']));

	 		// Update record
	 		if($newId > 0){
	 			$this->db->update('user_devices', $fields, array("user" => $data['user']));
	 		// Insert data
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
					 			->where('email' ,$data['email'])
					 			->get()
					 			->row_array();
	
	 		if($patient['id'] > 0){

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
	 				 ->set('password', md5($data['password']))
	 				 ->update($table);
	 		$count = $this->db->affected_rows();
	 		return $count > 0 ? true : false;
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
            $subject 	= "DBS :: Email Verification OTP";
            $msg 		= "OTP to reset your password.\n OTP : " . $otp;
            
            $this->email->from('sangitabagada.cci@gmail.com');
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
	 		if($data['type'] == 'upcoming' || $data['type'] == 'completed'){
	 		    $this->db->where('appointments.status',$data['type']);
	 		
	 		}else if($data['type'] == 'date'){
	 			$date = date('Y-m-d' , strtotime($data['date']));
	 			$this->db->where('appointments.date',$date);

	 		}

	 		$this->db->select('appointments.id,patients.fullname as patient_name,appointments.status,appointments.time,appointments.date');
	 		$this->db->from('appointments');
	 		$this->db->join('patients','patients.id=appointments.patient_id');
	 		$this->db->where('appointments.doctor_id' , $data['doctor_id']);
	 		$this->db->where('appointments.status !=' , 'cancel');

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

	 	public function view_apptmnt($id)
	 	{
	 		$this->db->select('appointments.id,patients.fullname as patient_name,appointments.status,appointments.time,appointments.date,patients.profile_photo,patients.email,patients.mobile,patients.age,patients.gender');
	 		$this->db->from('appointments');
	 		$this->db->join('patients','patients.id=appointments.patient_id');
	 		$this->db->where('appointments.id' , $id);
	 		$appointments = $this->db->get()->row();

	 		return $appointments;
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
	 		if($data['type'] == 'upcoming' || $data['type'] == 'completed'){
	 		    $this->db->where('appointments.status',$data['type']);
	 		
	 		}else if($data['type'] == 'date'){
	 			$date = date('Y-m-d' , strtotime($data['date']));
	 			$this->db->where('appointments.date',$date);

	 		}

	 		$this->db->select('appointments.id,doctors.fullname as doctor_name,appointments.status,appointments.time,appointments.date');
	 		$this->db->from('appointments');
	 		$this->db->join('doctors','doctors.id=appointments.doctor_id');
	 		$this->db->where('appointments.patient_id' , $data['patient_id']);
	 		$this->db->where('appointments.status !=' , 'cancel');
	 		$appointments = $this->db->get()->result_array();
	 		return $appointments;
	 	}

	 	public function get_doctors_list()
	 	{
	 		$doctors = $this->db->where('status' , 'active')
	 							->get('doctors')->result_array();
	 		return $doctors;					
	 	}

	 	public function get_doctor_details($id)
	 	{
	 		$doctor = $this->db->where('id' , $id)
	 						   ->get('doctors')->row();
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

	}//main class