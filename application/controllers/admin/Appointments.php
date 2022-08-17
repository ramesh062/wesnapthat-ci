<?php 

class Appointments extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('authentication_model');
        $this->load->model('appointments_model');
		if(empty($_SESSION['id'])){
			redirect('admin/authentication');
		}
	}

	public function get_appt($type)
	{
		if(isset($_SESSION["id"])){
			
			if($type == 'all'){
				$data['PageTitle'] = 'Appointments';	
			}else if($type == 'upcoming'){
				$data['PageTitle'] = 'Upcoming Appointments';
			}else if($type == 'completed'){
				$data['PageTitle'] = 'Completed Appointments';
			}
			
			$data['PageName']  = $type;
			$data['type']      = $type;
			$data['appointments'] = $this->appointments_model->get_by_status($type); 
			$data['doctors_appt'] = $this->appointments_model->doctors_appt(); 
			$data['doctor_id'] = "";
			$data['doctor'] = [];
			$this->db->select('COUNT(id) AS count');
	    	$data['appt_count'] = $this->db->get('appointments')->row();
	    	
	    	$data['admin']  = $this->db->get('admin')->row();
	    	
			$this->load->view('admin/doctor_appoinment_table',$data);
		}else{
    		redirect('admin/authentication');
    	}	
	}

	public function doctor_apptmnt($id)
	{	
		if(isset($_SESSION["id"])){

			if(isset($_GET['type']) && $_GET['type'] != ""){
				$type = $_GET['type'];
			}else{
				$type = 'all';
			}

			$data['PageTitle'] = 'Appointments';
			$data['PageName']  = 'all';
			$data['type']      = $type;
			$data['doctor_id'] = $id;
			$this->db->where('id' , $id);
			$data['doctor'] = $this->db->get('doctors')->row();
			
			$data['appointments'] = $this->appointments_model->get_apptmnt_by_doctor($id,$type);

			$data['doctors_appt'] = $this->appointments_model->doctors_appt(); 

			$this->db->select('COUNT(id) AS count');
	    	$data['appt_count'] = $this->db->get('appointments')->row();
            
            $data['admin']  = $this->db->get('admin')->row();
            
			$this->load->view('admin/doctor_appoinments',$data);
		}else{
    		redirect('admin/authentication');
    	}
	}

	public function view_appointment($id)
	{
		$this->db->select('appointments.id,patients.fullname as patient_name,patients.profile_photo as patient_photo,doctors.fullname as doctor_name,appointments.status,appointments.time,appointments.date,appointments.note');
		$this->db->from('appointments');
		$this->db->join('patients','patients.id=appointments.patient_id');
		$this->db->join('doctors','doctors.id=appointments.doctor_id');
		$this->db->where('appointments.id' , $id);
		$appointment = $this->db->get()->row();

		$appointment->date = date('d M,Y',strtotime($appointment->date));
		$appointment->time = date('h:i A',strtotime($appointment->time));
		
		echo json_encode(['status'=>0,'data'=>$appointment]);exit;
	}	
	
	public function change_status()
	{
		$id = $_GET['id'];
		$status = $_GET['status'];
		
		if($id != ""){
			$this->db->where('id' , $id)
		         ->set('status', $status)
		         ->update('appointments');	
		}
		redirect('admin/appointments/get_appt/all');
	}
	
	public function add_appointment($id = "")
	{
		$data['PageTitle'] = 'Appointment';
		$data['PageName']  = 'add_appointment';
		
		if($id != ""){
			$data['doctor_id'] = $id;
		}else{
			$data['doctor_id'] = "";
		}

		$this->db->where('status' , 'active');
		$data['doctors']   = $this->db->get('doctors')->result_array();
        $data['admin']  = $this->db->get('admin')->row();
		$this->load->view('admin/book_appoinment',$data);	
	}
}
