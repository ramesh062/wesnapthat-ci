<?php 

class Doctors extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('authentication_model');
        $this->load->model('doctors_model');
        $this->load->helper('form');
	}

	public function index()
	{
		if(isset($_SESSION['id'])){
			$data['doctors'] = $this->doctors_model->get_doctors();
			$data['PageTitle']   = 'Manage Doctors';
			$data['PageName']    = 'manage_doctors';
			$this->load->view('admin/doctor_list',$data);
		}else{
			redirect('admin/authentication');
		}
	}

	public function add_doctor($id = "")
	{
		if($this->input->post()){
			$data = $this->input->post();
			$temp = [];
			array_push($temp, $data['from_hour']);	
			array_push($temp, $data['from_min']);	
			array_push($temp, $data['from_type']);	
			array_push($temp, $data['to_hour']);	
			array_push($temp, $data['to_min']);	
			array_push($temp, $data['to_type']);	
			

			unset($data['from_hour']);	
			unset($data['from_min']);	
			unset($data['from_type']);	
			unset($data['to_hour']);	
			unset($data['to_min']);	
			unset($data['to_type']);	
			
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

			if($id != ""){
				$data['last_update'] = date('Y-m-d H:i:s');

				$this->db->where('id' , $id);
				$this->db->update('doctors',$data);
				$insert_id = $id;
				
			}else{
				$data['reg_date'] = date('Y-m-d H:i:s');

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

			    $data1['from_hour'] = $value;
			    $data1['from_min']  = $temp[1][$key];
			    $data1['from_type'] = $temp[2][$key];
			    $data1['to_hour']   = $temp[3][$key];
			    $data1['to_min']    = $temp[4][$key];
			    $data1['to_type']   = $temp[5][$key];

			    $this->db->insert('consultation_hours',$data1);
			    $insert_id = $this->db->insert_id();
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
				echo json_encode(['status'=>1,'message'=>'Success...']);exit;
			}else{
				echo json_encode(['status'=>0,'message'=>'Somthing Went Wrong.']);exit;
			}

		}else{
			if(isset($_SESSION['id'])){
				$data['PageTitle']   = 'Add Doctor';
				$data['PageName']    = 'manage_doctors';
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

		$this->load->view('admin/edit_doctor',$data);
	}

	public function change_doctor_status($id){
		$this->db->where('id' , $id);
		$this->db->set('status' , 'deleted');
		$this->db->update('doctors');

		redirect('admin/doctors');
	}
}