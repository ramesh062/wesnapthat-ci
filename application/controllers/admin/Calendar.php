<?php 

class Calendar extends CI_Controller
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

    public function index()
    {
    	if(isset($_SESSION["id"])){
            $data['PageTitle'] = "Calendar";
            $data['PageName']  = "calendar";
            
            $data['admin']  = $this->db->get('admin')->row();
            
    		$this->load->view('admin/calendar',$data);	
    	}else{
    		redirect('admin/authentication');
    	}
    }

    public function get_calendar_data($date =  "")
    {
        $this->db->select('patients.fullname AS title,appointments.date AS start,appointments.time AS time,patients.profile_photo');
        $this->db->join('patients','patients.id = appointments.patient_id');
        if($date != ""){
            $this->db->where('appointments.date' , $date);
        }else{
            $this->db->where('appointments.date' , date('Y-m-d'));
        }
        $data = $this->db->get('appointments')->result_array(); 
        
        $data1 = [];
        foreach ($data as $key => $each) {

            $temp = [];
            $temp['title'] = $each['title']." ".date('h:i', strtotime($each['time']));
            $temp['start'] = $each['start']." ".$each['time'];
            $temp['time']  = $each['time'];
            $temp['resourceId'] = 'day';
            if($each['profile_photo'] != ""){
                $temp['imageurl'] = base_url('uploads/patients_profile_images/'. $each['profile_photo']);
            }else{
                $temp['imageurl'] = SITE_IMAGES ."default_user.jpg";
            }
            array_push($data1, $temp);            
        }
        
        echo json_encode($data1);
    }   
}