<?php 

class Doctors extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('authentication_model');
        $this->load->model('doctors_model');
        $this->load->helper('form');
		if(empty($_SESSION['id'])){
			redirect('admin/authentication');
		}
	}

	public function index()
	{
		if(isset($_SESSION['id'])){

			$data['doctors'] = $this->doctors_model->get_doctors();
			$data['PageTitle']   = 'Manage Doctors';
			$data['PageName']    = 'manage_doctors';
			
			$data['admin']  = $this->db->get('admin')->row();
			
			$this->load->view('admin/doctor_list',$data);
		}else{
			redirect('admin/authentication');
		}
	}

	public function view_doctor($id = "")
	{
		if($id != ""){
			$this->db->where('id' , $id);
			$data['doctor'] = $this->db->get('doctors')->row();

			$this->db->where('doctor_id' , $id);
			$hours = $this->db->get('consultation_hours')->result_array();
			$temp = [];
			foreach ($hours as $key => $each) {
				$time = date('h:i A', strtotime($each['from_time'])) .' To '. date('h:i A', strtotime($each['to_time']));;

				array_push($temp, $time);
			}
			$data['hours']  = implode(" , ", $temp);
			
			$days = [];
			$weekly_off_days = explode(',',$data['doctor']->weekly_off_days);
			foreach ($weekly_off_days as $value) {
				$temp = date('l', strtotime($value));
				array_push($days, $temp);
			}

			$data['days'] = implode(",", $days);
	
			echo json_encode(['status'=>1,'data'=>$data]);exit;
		}
	}

	public function add_doctor($id = "")
	{
		if($this->input->post()){
			$data = $this->input->post();
			
			$this->db->where('email',$data['email']);
			$this->db->where('status!="deleted"');
			$doctor = $this->db->get('doctors')->row();

			$valid = true;
			if($id != "" && $doctor != ""){
				if($id == $doctor->id){
					$valid = true;
				}else{
					$valid = false;
				}
			}else if($id == "" && $doctor != ""){
				$valid = false;
			}
			
			if($valid == false){
				echo json_encode(['status'=>0,'message'=>'Email already exist..']);exit;
			}else{
				$temp = [];
				array_push($temp, $data['from_time']);	
				array_push($temp, $data['to_time']);	
		
				unset($data['from_time']);	
				unset($data['to_time']);		
				
				if(isset($data['password']) && $data['password'] != ""){
					$data['password']    = md5($data['password']);	
				}else{
					unset($data['password']);
				}

				unset($data['mon']);
				unset($data['tue']);
				unset($data['wed']);
				unset($data['thu']);
				unset($data['fri']);
				unset($data['sat']);
				unset($data['sun']);
				$data['last_updated'] = date('Y-m-d H:i:s');
				if($id != ""){
					$data['last_updated'] = date('Y-m-d H:i:s');
					if(isset($data['full']))
						unset($data['full']);
					$this->db->where('id' , $id);
					$this->db->update('doctors',$data);
					
					$insert_id = $id;
					
				}else{
					$data['reg_date'] = date('Y-m-d H:i:s');
					if(isset($data['full']))
						unset($data['full']);
					$this->db->insert('doctors',$data);
					$insert_id = $this->db->insert_id();
					
				}

				//add consultation hours
				$this->db->where('doctor_id' , $insert_id);
				$this->db->where('type','doctor');
				$this->db->delete('consultation_hours');
				
				$data1['type']       = 'doctor';
				$data1['doctor_id']  = $insert_id;
				foreach ($temp[0] as $key => $value) {

				    $data1['from_time'] = date("H:i", strtotime($value));
	            	$data1['to_time']   = date("H:i", strtotime($temp[1][$key]));

				    $this->db->insert('consultation_hours',$data1);
				   // $insert_id = $this->db->insert_id();
				}
				//add consultation hours

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
				        echo json_encode(array('status'=>0,'data'=>array(),'message'=>'This type of file not allowed'));exit;
				    }
				    
				    $filename  = date('dmyHis').'_'.$_FILES['profile_image']['name'];
				    $file = $image_path . $filename;

				    copy($path, $file);

				    $this->db->where('id' , $insert_id);
				    $this->db->set('profile_photo' , $filename);
				    $this->db->update('doctors');
				    
				}

				if($insert_id > 0){
					echo json_encode(['status'=>1,'message'=>'To doctors save successfully on system.']);exit;
				}else{
					echo json_encode(['status'=>0,'message'=>'Somthing Went Wrong.']);exit;
				}	
			}

		}else{
			if(isset($_SESSION['id'])){
				$data['PageTitle']   = 'Add Doctor';
				$data['PageName']    = 'manage_doctors';
				
				$data['admin']  = $this->db->get('admin')->row();
				
				$this->load->view('admin/add_doctor',$data);
			}else{
				redirect('admin/authentication');
			}	
		}			
	}


	public function edit_doctor($id)
	{
		$this->db->where('id' , $id);
		$data['doctors'] = $this->db->get('doctors')->row();

		$this->db->where('doctor_id' , $id);
		$this->db->where('type','doctor');
		$data['consultation_time'] = $this->db->get('consultation_hours')->result_array();
		
		$data['PageTitle'] = 'Edit Doctor';
		$data['PageName'] = 'manage_doctors';
        
        $data['admin']  = $this->db->get('admin')->row();
        
		$this->load->view('admin/edit_doctor',$data);
	}

	public function change_doctor_status($id)
	{
		$this->db->where('id' , $id);
		$this->db->set('status' , 'deleted');
		$this->db->update('doctors');
        
        $data['admin']  = $this->db->get('admin')->row();
		
		$this->db->flush_cache();
		$this->db->where('doctor_id' , $id);
		$this->db->set('status' , 'deleted');
		$this->db->update('appointments');

		redirect('admin/doctors');
	}
}
