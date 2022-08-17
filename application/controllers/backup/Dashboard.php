<?php 

class Dashboard extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('authentication_model');
        $this->load->model('appointments_model');
        $this->load->helper('form');
	}

    public function index($type = '')
    {
    	if(isset($_SESSION["id"])){

            if($type != ""){
                if($type == 0){
                    $ts = strtotime(date('Y-m-d'));
                    $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
                    $start_date = date('Y-m-d', $start);
                    $end_date = date('Y-m-d', strtotime('next saturday', $start));

                }else if($type == 1){
                    $previous_week = strtotime("-1 week +1 day");
                    $start_week = strtotime("last sunday midnight",$previous_week);
                    $end_week   = strtotime("next saturday",$start_week);

                    $start_date = date("Y-m-d",$start_week);
                    $end_date   = date("Y-m-d",$end_week);

                }else if($type == 2){            
                    $start_date = date("Y-n-j", strtotime("first day of previous month"));
                    $end_date   = date("Y-n-j", strtotime("last day of previous month"));
                
                }
                
            }else{
                $ts = strtotime(date('Y-m-d'));
                $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
                $start_date = date('Y-m-d', $start);
                $end_date = date('Y-m-d', strtotime('next saturday', $start));
                $type = 0;
            }

            $data['type'] = $type; 
            $this->db->select('DISTINCT(date)');
            $this->db->where('date BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" AND "' . date('Y-m-d', strtotime($end_date)) . '"');
            $this->db->order_by("date", "asc");
            $distinct_date = $this->db->get('appointments')->result_array();
            
            $chart = [];
            foreach ($distinct_date as $key => $value) {
                $this->db->select('COUNT(date) AS count,date');
                $this->db->where('date',$value['date']);
                $date = $this->db->get('appointments')->row();
                array_push($chart, $date);
            }

            $data['chart'] = $chart;
            $data['appointments'] = $this->appointments_model->get(); 
            
            $day = date('D');
            $data['today_doctor_count'] = $this->db->query("SELECT COUNT(id) AS count FROM `doctors` WHERE weekly_off_days Not LIKE '%$day%'")->row();
            
            $this->db->select('COUNT(id) AS count');
            $this->db->where('date',date('Y-m-d'));
            $data['today_appt_count'] = $this->db->get('appointments')->row();

            $data['total_appt_count'] = $this->appointments_model->count_appointments();
            $data['doctors'] = $this->appointments_model->get_doctors();
    		$data['PageTitle'] = "Dashboard";
            $data['PageName']  = "index";
    		$this->load->view('admin/dashboard',$data);	
    	}else{
    		redirect('admin/authentication');
    	}
    }

    public function time_management($id = "")
    {
        if(isset($_SESSION["id"])){
            if($id != ""){
                $this->db->where('doctor_id' , $id);
                $this->db->where('type','doctor');
                $data['consultation_time'] = $this->db->get('consultation_hours')->result_array();

                $this->db->where('id' , $id);
                $data['doctor_details'] = $this->db->get('doctors')->row();
                $data['doctor_id'] = $id;
            }else{
                $this->db->where('type','hospital');
                $data['consultation_time'] = $this->db->get('consultation_hours')->result_array();
            }
            
            $data['PageTitle'] = "Time Management";
            $data['PageName']  = "timing";
            $data['doctors']   = $this->db->get('doctors')->result_array();
            $this->load->view('admin/timing',$data); 
        }else{
            redirect('admin/authentication');
        }
    }

    public function add_consultation_hours($id = "")
    {
        $data = $this->input->post();
    
        if($id != ""){
            $this->db->where('doctor_id' , $id);
            $this->db->where('type','doctor');
            $this->db->delete('consultation_hours');
            
            $data1['doctor_id']  = $id;
            $data1['type']       = 'doctor';

            $data2 = array(
                'appointment_time_slots' => $data['appointment_time_slots'],                 
                'weekly_off_days'        => $data['weekly_off_days'] 
            );

            $this->db->where('id' , $id);
            $this->db->update('doctors',$data2);
        }else{
            $this->db->where('type','hospital');
            $this->db->delete('consultation_hours');

            $data1['type']      = 'hospital';
        }
        
        foreach ($data['from_hour'] as $key => $value) {

            $data1['from_hour'] = $value;
            $data1['from_min']  = $data['from_min'][$key];
            $data1['from_type'] = $data['from_type'][$key];
            $data1['to_hour']   = $data['to_hour'][$key];
            $data1['to_min']    = $data['to_min'][$key];
            $data1['to_type']   = $data['to_type'][$key];

            $this->db->insert('consultation_hours',$data1);
            $insert_id = $this->db->insert_id();
        }

        if($insert_id > 0){
            echo json_encode(['status'=>1,'message'=>'success']);exit;
        }else{
            echo json_encode(['status'=>0,'message'=>'Somthing went wrong.']);exit;
        }
    }

    public function settings()
    {
        $data['PageTitle'] = "Settings";
        $data['PageName']  = "settings";
        $data['admin']     = $this->db->get('admin')->row();
        $this->load->view('admin/settings',$data); 
    }
}