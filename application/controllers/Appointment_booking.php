<?php 

class Appointment_booking extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('authentication_model');
        $this->load->model('appointments_model');
		$this->load->model('api_model');
	}

	public function new_appointment($id = "")
	{
		$data['PageTitle'] = 'Appointment';
		$data['PageName']  = 'new appoinments';
		
		if($id != ""){
			$data['doctor_id'] = $id;
		}else{
			$data['doctor_id'] = "";
		}

		$this->db->where('status' , 'active');
		$data['doctors']   = $this->db->get('doctors')->result_array();
        $data['admin']  = $this->db->get('admin')->row();
		$this->load->view('admin/new_appoinments',$data);	
	}

// 	public function add_new_appointment()
// 	{
// 		$data = $this->input->post();

// 		if(!empty($data)){

// 			$count = $this->db->select('count(*) AS cnt')
// 	 			->from('patients')
// 	 			->where('email' , $data['email'])
// 	 			->get()
// 	 			->row_array();

// 	 		if($count['cnt'] > 0){
// 	 			echo json_encode(['status' => 0,'message' => 'Email already exist..']);exit;
// 	 		}else{
// 	 			$this->db->insert('patients',[
// 	 						'email'    => $data['email'],
// 	 						'fullname' => $data['fullname'],
// 	 						'mobile'   => $data['mobile'],
// 	 						'age'      => $data['age'],
// 	 						'gender'   => $data['gender'],
// 	 						'type'     => 'guest'
// 	 			]);

// 	 			$insert_id = $this->db->insert_id();

// 	 			if($insert_id > 0){
// 	 				$this->db->insert('appointments',[
// 	 							'patient_id' => $insert_id,
// 	 							'doctor_id'  => $data['doctor_id'],
// 	 							'date'       => date('Y-m-d' , strtotime($data['date'])),
// 	 							'time'       => date('H:i:s' , strtotime($data['time'])),
// 	 							'note'       => $data['note'],
// 	 							'added_date' => date('Y-m-d H:i:s'),
// 	 							'status'     => 'upcoming'
// 	 				]);
// 	 				$appt_id = $this->db->insert_id();
	 				
// 	 				//send mail to patient - START
// 	 				$data1 = array(
// 	 						'date' => date('d-m-Y' , strtotime($data['date'])),
// 	 						'time' => date('h:i A' , strtotime($data['time'])),
// 	 						'doctor_id' => $data['doctor_id'],
// 	 						'email'=> $data['email'],
// 	 						'note' => $data['note']
// 	 				);
// 	 				$this->appointments_model->send_appointment_mail($data1);
// 	 				//send mail to patient - END

// 	 				echo json_encode(['status' => 1,'data'=>$appt_id,'message' => 'Appointment added successfully..']);exit;				
// 	 			}else{
// 	 				echo json_encode(['status' => 0,'message' => 'Somthing went wrong..']);exit;
// 	 			}
// 	 		}
// 		}
// 	}
    
	public function add_new_appointment()
	{
		$data = $this->input->post();

		if(!empty($data)){
			$count=[];

			if(!empty($data['email']) && !empty($data['mobile'])){
				$count = $this->db->select('type,id')
					->from('patients')
					->where('email' , $data['email'])
					->where('mobile' , $data['mobile'])
					->get()
					->row_array();
			}
			else{
				$count = $this->db->select('type,id')
					->from('patients')
					->where('mobile' , $data['mobile'])
					->get()
					->row_array();
			}

	 		if(!empty($count['id']) && $count['id'] > 0){
	 			if($count['type'] == 'guest'){
	 				$this->db->where('id' , $count['id']);
	 				$this->db->update('patients',[
	 							'fullname' => $data['fullname'],
	 							'mobile'   => $data['mobile'],
	 							'age'      => $data['age'],
	 							'gender'   => $data['gender'],
	 							'last_updated' => date('Y-m-d H:i:s')
	 				]);
	 			}
	 			$insert_id = $count['id'];
				$data['patient_id']=$insert_id;
	 		}else{
	 			$this->db->insert('patients',[
	 						'email'    => $data['email'],
	 						'fullname' => $data['fullname'],
	 						'mobile'   => $data['mobile'],
	 						'age'      => $data['age'],
	 						'gender'   => $data['gender'],
							'password'=>md5('123456'),
							'otp_varified'=>'0',
							'profile_photo'=>'',
							'reg_date'=>date('Y-m-d H:i:s'),
							'last_updated'=>null,
							'countrycode'=> !empty($data['countrycode'])?$data['countrycode']:"+1",
	 						'type'     => 'guest'
	 			]);

	 			$insert_id = $this->db->insert_id();
				$data['patient_id']=$insert_id;
	 		}

	 		if($insert_id > 0){
				 $status=!empty($data["status"])?$data["status"]:"pending";
	 			$this->db->insert('appointments',[
	 						'patient_id' => $insert_id,
	 						'doctor_id'  => $data['doctor_id'],
	 						'date'       => date('Y-m-d' , strtotime($data['date'])),
	 						'time'       => date('H:i:s' , strtotime($data['time'])),
	 						'note'       => $data['note'],
	 						'added_date' => date('Y-m-d H:i:s'),
	 						'status'     => $status
	 			]);
	 			$appt_id = $this->db->insert_id();

	 			//send mail to patient - START
	 			$data1 = array(
	 					'date' => date('d-m-Y' , strtotime($data['date'])),
	 					'time' => date('h:i A' , strtotime($data['time'])),
	 					'doctor_id' => $data['doctor_id'],
	 					'email'=> $data['email'],
	 					'note' => $data['note']
	 			);
	 			$this->appointments_model->send_appointment_mail($data1);
	 			//send mail to patient - END
				 
				//Notification
				if($appt_id>0){
					
				   //send notification to admin
				   $patient_name     = $this->api_model->get_name('patients', $data['patient_id']);	
				   $doctor_name      = $this->api_model->get_name('doctors', $data['doctor_id']);   					
				   $data3['message']   = $patient_name ." book appointment with doctor ".$doctor_name." for time  ". date('d-m-Y' , strtotime($data['date'])) ." ". date('h:i A' , strtotime($data['time']));
				   
				   $data3['title']   = "New Appointment";
				   $data3['user'] = 1;
				   $data3['type'] = "admin";
				   $data3['status']  = 'add';
				   $data3['url']  = base_url('admin/appointments/get_appt/all');
				   $this->api_model->send_push_notification($data3);

				   //send notification to doctor
				   $isNotify = $this->api_model->get_notify('doctors' , $data['doctor_id']);

				   if($isNotify){
					   $data1['topic'] = 'New appointment';
					   $data1['message'] = $patient_name ." book appointment for the time ". date('d-m-Y' , strtotime($data['date'])) ." ". date('h:i A' , strtotime($data['time']));
					   $data1['user'] = $data['doctor_id'];
					   $data1['type'] = 'doctor';
					   $data1['reference_id'] = $appt_id;
					   $data1['appt_id'] = $appt_id;
					   
					   $isSet = $this->api_model->set_notification($data1);

					   if($isSet){
						   $data2['user'] = $data['doctor_id'];
						   $data2['type'] = 'doctor';
						   $data2['message'] = $patient_name ." book appointment for the time ". date('d-m-Y' , strtotime($data['date'])) ." ". date('h:i A' , strtotime($data['time']));
						   $data2['title']   = 'New appointment';
						   $data2['reference_id'] = $data['patient_id'];
						   $data2['status']  = 'add';
						   $this->api_model->send_push_notification($data2);
					   }
				   }
				}
	 			echo json_encode(['status' => 1,'data'=>$appt_id,'message' => 'Appointment added successfully..']);exit;				
	 		}else{
	 			echo json_encode(['status' => 0,'message' => 'Somthing went wrong..']);exit;
	 		}
		}
	}

	public function get_doctor_date()
	{
		$data = $this->input->post();
		
		if($data['date'] != "" && $data['doctor_id'] != "")
		{
			$day = date('D',strtotime($data['date']));
            $count = $this->db->query("SELECT COUNT(id) AS count FROM `doctors` WHERE `weekly_off_days` LIKE '%$day%' AND `id` =".$data['doctor_id'])->row();
          
            if($count->count > 0){
            	echo json_encode(['status'=>0,'message'=>'Doctor not available on this date.']);exit;
            }

		}
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
		    $data['appntmt'] = $temp2;

			echo json_encode(['status' => 1,'data' => $data]);exit;
		}
	}
	
	public function booked_appointment($id)
	{
		$data['apptmt'] = $this->db->select('appointments.date,appointments.time,doctors.fullname')
								   ->from('appointments')
								   ->join('doctors','doctors.id = appointments.doctor_id')
				 		           ->where('appointments.id',$id)
				 		           ->get()->row();
		$data['admin']  = $this->db->get('admin')->row();
		$this->load->view('admin/appoinment_booked',$data);
	}

	public function get_apptmnt()
	{
		$data = $this->input->post();
		
		if($data['time'] != "" && $data['doctor_id'] != "" && $data['date'] != "")
		{
			$time = date('H:i:s',strtotime($data['time']));
			$date = date('Y-m-d',strtotime($data['date']));
            $count = $this->db->select('COUNT(id) As count')
            				  ->where('doctor_id' , $data['doctor_id'])
            				  ->where('time' , $time)
            				  ->where('date' , $date)
            				  ->get('appointments')->row();
         
            if($count->count > 0){
            	echo json_encode(['status'=>0,'message'=>'This time slot not available on this date.']);exit;
            }
		}
	}
	
	public function get_doctor_consultation_hours()
	{
		$data = $this->input->post();
		
		if($data['time'] != "" && $data['doctor_id'] != "")
		{
			$time = date('H:i:s',strtotime($data['time']));

            $count = $this->db->select('COUNT(id) As count')
            				  ->where('doctor_id' , $data['doctor_id'])
            				  ->where(' "'.$time.'" BETWEEN `from_time` AND `to_time`')
            				  ->where('to_time >' ,$time)
            				  ->get('consultation_hours')->row();
         	
            if($count->count == 0){
            	echo json_encode(['status'=>0,'message'=>'Doctor not available on this time.']);exit;
            }
		}		
	}

	public function get_apptmnt_bydate()
	{
		$data = $this->input->post();
		
		if($data['doctor_id'] != "" && $data['date'] != "")
		{
			$this->db->where('id' , $data['doctor_id']);
			$this->db->select('appointment_time_slots AS time');
			$time_slot = $this->db->get('doctors')->row();

			$time = [];
			$date = date('Y-m-d',strtotime($data['date']));
            $data = $this->db->select('time')
            				  ->where('doctor_id' , $data['doctor_id'])
            				  ->where('date' , $date)
            				  ->where('status' , 'upcoming')
            				  ->get('appointments')->result_array();

            foreach ($data as $each) {
            	$time1 = strtotime($each['time']);
            	$endTime = date("h:ia", strtotime('+'.$time_slot->time.'minutes', $time1));
            	
            	$temp = [date('h:ia',strtotime($each['time'])),$endTime];
            	array_push($time, $temp);
            }
            
            if(!empty($time)){
            	echo json_encode(['status'=>1,'data'=>$time]);exit;
            }
		}
	}

}
