<?php 

class Patients extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('authentication_model');
        $this->load->model('doctors_model');
		$this->load->model('api_model');
        $this->load->helper('form');
		$this->load->library('form_validation');
		if(empty($_SESSION['id'])){
			redirect('admin/authentication');
		}
	}

	public function index()
	{
		if(isset($_SESSION['id'])){
			$this->db->where("type!='deleted'");
			$data['patients'] = $this->db->get('patients')->result_array();
			$data['PageTitle']   = 'Patients';
			$data['PageName']    = 'patients';
			
			$data['admin']  = $this->db->get('admin')->row();

			$this->load->view('admin/patients_list',$data);
		}else{
			redirect('admin/authentication');
		}
	}

	public function view_patient($id)
	{
		if($id != ""){
			$this->db->where('id' , $id);
			$data['patient'] = $this->db->get('patients')->row();
			echo json_encode(['status'=>1,'data'=>$data]);exit;
		}
	}
	
	public function patient_apptmnts($id)
	{
		if(isset($_SESSION['id'])){

			$this->db->select('appointments.id,patients.fullname as patient_name,patients.profile_photo as patient_photo,doctors.fullname as doctor_name,appointments.status,appointments.time,appointments.date');
	    	$this->db->from('appointments');
	    	$this->db->join('patients','patients.id=appointments.patient_id');
	    	$this->db->join('doctors','doctors.id=appointments.doctor_id');
	    	$this->db->where('appointments.patient_id',$id);
			$this->db->where('patients.type!="deleted"');
			$this->db->where('appointments.status!="deleted"');

	    	$data['apptmnts'] = $this->db->get()->result_array();
			
			$data['PageTitle']   = 'Patients';
			$data['PageName']    = 'patients';
			
			$data['doctor'] = [];
					
			$data['admin']  = $this->db->get('admin')->row();

			$this->load->view('admin/patient_appointments' , $data);		     						 
		
		}else{
			redirect('admin/authentication');		
		}

	}
	
	public function change_status()
	{
		$id = $_GET['id'];
		$status = $_GET['status'];
		
		if($id != ""){
			$this->db->where('id' , $id)
		         	 ->set('status', $status)
		             ->update('appointments');
		    
		    $data = $this->db->select('patient_id')
		    				 ->where('id' , $id)
		    				 ->get('appointments')->row();	
		}

		redirect('admin/patients/patient_apptmnts/'.$data->patient_id);
	}
	public function add_patient(){
		$data['PageTitle']   = 'Manage Doctors';
		$data['PageName']    = 'patients';
		$data['admin']  = $this->db->get('admin')->row();
		$this->load->view('admin/patient_form',$data);
	}
	
	public function save_patient(){
		$this->form_validation->set_rules('fullname', 'Fullname', 'required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
		$this->form_validation->set_rules('age', 'Age', 'required|numeric');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|matches[password]');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['PageTitle']   = 'Add Patient';
			$data['PageName']    = 'patients';
			$data['admin']  = $this->db->get('admin')->row();
			$this->load->view('admin/patient_form',$data);
		}
		else
		{
			$data = $this->input->post();
			$data1['fullname'] = $data['fullname'];
			$data1['email']    = isset($data['email']) ? $data['email'] : '';
			$data1['mobile']   = $data['mobile'];
			$data1['age']      = $data['age'];
			$data1['gender']   = $data['gender'];
			$data1['password'] = $data['password'];
			$data1['countrycode'] = !empty($data['countrycode'])?"+".$data['countrycode']:"+1";
			
			$id = $this->api_model->patient_signup($data1);
			if($id == false){
				$_SESSION['error_message'] = 'Mobile number is already exists';
				redirect("admin/patients/add_patient");
			}else{
				$user = $this->api_model->get_user('patients',$id);
				if($user['profile_photo'] != ""){
					$user['profile_photo'] = PATIENT_PIC_URL.$user['profile_photo'];
				}
				//DO CODE HERE
				$isOTPSent =  $this->api_model->otp_mobile('send', $data['mobile'] , $data['countrycode']);
				$user['otp'] = "";

				if($isOTPSent){
					$OTPData = $this->api_model->get('otp', "otp" , array('mobile'=>$data['mobile'] , 'countrycode'=>$data['countrycode']));
					if($OTPData) {
						$user['otp'] = $OTPData;							
					}
				}
				
				$settings = $this->db->select('admin.hospital_name,admin.address,admin.phone,currency_table.name as currency_name,currency_table.sign as currency_sign')
									 ->from('admin')
									 ->join('currency_table' ,'admin.currency = currency_table.id')
									 ->get()->row();

				$settings =  array('info'=>$settings ,'booking_url'=> base_url('appointment_booking/new_appointment'));
				
				$_SESSION['success_message'] = 'Patient is registered successfully';
				redirect("admin/patients");
			}
		}
	}
	
	public function booking($id = "")
	{
		$data['PageTitle'] = 'Appointments';
		$data['PageName']  = 'appointments';
		
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
	
	public function change_patient_status($id)
	{
		$this->db->where('id' , $id);
		$this->db->set('type' , 'deleted');
		$this->db->update('patients');
        
        $data['admin']  = $this->db->get('admin')->row();
		
		$this->db->flush_cache();
		$this->db->where('patient_id' , $id);
		$this->db->set('status' , 'deleted');
		$this->db->update('appointments');

		redirect('admin/patients');
	}
}
