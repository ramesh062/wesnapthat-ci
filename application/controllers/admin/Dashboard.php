<?php 

class Dashboard extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('authentication_model');
        $this->load->model('appointments_model');
		$this->load->helper('form');
        if(empty($_SESSION['id'])){
			redirect('admin/authentication');
		}
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
            
            $data['admin']  = $this->db->get('admin')->row();
			
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
                $data['doctor_id'] = "";
                $this->db->where('type','hospital');
                $data['consultation_time'] = $this->db->get('consultation_hours')->result_array();
            }
            
            $data['PageTitle'] = "Time Management";
            $data['PageName']  = "timing";
            $this->db->where('status','active');
            $data['doctors']   = $this->db->get('doctors')->result_array();
            
            $data['admin']  = $this->db->get('admin')->row();
            
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
        
        foreach ($data['from_time'] as $key => $value) {

            $data1['from_time'] = date("H:i", strtotime($value));
            $data1['to_time']   = date("H:i", strtotime($data['to_time'][$key]));
            
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
        $data['currency']  = $this->db->get('currency_table')->result_array();
        
        $data['admin']  = $this->db->get('admin')->row();
        $this->load->view('admin/settings',$data); 
    }

    public function update_admin()
    {
        $data = $this->input->post();    
        
        if(isset($data['password']) && $data['password'] != ""){
            $data['password'] = md5($data['password']);
        }else{
            unset($data['password']);
        }

        $data['last_update'] = date('Y-m-d H:i:s');

        $this->db->update('admin' , $data);
        $row = $this->db->affected_rows();

        if($row > 0){
            echo json_encode(['status' => 1 , 'message' => 'Data updated successfully']);exit;
        }else{
            echo json_encode(['status' => 1 , 'message' => 'Somthing went wrong!!']);exit;
        }
    }
    
    public function developers()
    {
        if(isset($_SESSION["id"])){
            $data['PageTitle'] = "Developers";
            $data['PageName']  = "developers";
            $data['admin']     = $this->db->get('admin')->row();

            $data['one_signals'] = $this->db->get('onesignals')->row();
            $this->load->view('admin/developers',$data);
        }else{
            redirect('admin/authentication');
        }
    }

    public function update_onesignals()
    {
        $data = $this->input->post();

        $row  = $this->db->get('onesignals')->row_array();

        if(empty($row)){
            $this->db->insert('onesignals' , $data);
        }else{
            $this->db->update('onesignals' , $data);
        }
        
        echo json_encode(['status' => 1,'message' => 'Onesignals updated.']);
        
    }
	
	public function get_dashboard(){
		
        $data = $this->input->post();
		$type=!empty($data["chart_type"])?$data["chart_type"]:0;
		$doctor_id=!empty($data["doctor_id"])?$data["doctor_id"]:0;
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
		if($doctor_id>0){
			$this->db->where('doctor_id='.$doctor_id);
		}
		$this->db->order_by("date", "asc");
		$distinct_date = $this->db->get('appointments')->result_array();
		$chart = [];
		if($type==2){
			foreach ($distinct_date as $key => $value) {
				$this->db->select('COUNT(date) AS count,DATE_FORMAT(date,"%M %d") as day');
				$this->db->where('date',$value['date']);
				if($doctor_id>0){
					$this->db->where('doctor_id='.$doctor_id);
				}
				$date = $this->db->get('appointments')->row();
				array_push($chart, $date);
			}
			$data['chart']=array_combine(array_column($chart,"day"),array_column($chart,"count"));
		}
		else{
			foreach ($distinct_date as $key => $value) {
				$this->db->select('COUNT(date) AS count,DATE_FORMAT(date,"%a") as day');
				$this->db->where('date',$value['date']);
				if($doctor_id>0){
					$this->db->where('doctor_id='.$doctor_id);
				}
				$date = $this->db->get('appointments')->row();
				array_push($chart, $date);
			}
			$chart_data=array_combine(array_column($chart,"day"),array_column($chart,"count"));
			$dayName=['Mon'=>0, 'Tue'=>0, 'Wed'=>0, 'Thu'=>0, 'Fri'=>0, 'Sat'=>0,'Sun'=>0];
			foreach($dayName as $day=>$value){
				if(!empty($chart_data[$day]))
					$data['chart'][$day]=$chart_data[$day];
				else
					$data['chart'][$day]=0;
			}
		}
		$data['appointments'] = $this->appointments_model->get(); 
		$day = date('D');
		$where="";
		if($doctor_id>0)
			$where=" AND id=$doctor_id";
		$data['today_doctor_count'] = $this->db->query("SELECT COUNT(id) AS count FROM `doctors` WHERE weekly_off_days Not LIKE '%$day%' $where")->row();
		$this->db->select('COUNT(id) AS count');
		$this->db->where('date',date('Y-m-d'));
		if($doctor_id>0)
			$this->db->where('doctor_id',$doctor_id);
		$data['today_appt_count'] = $this->db->get('appointments')->row();
		$data['total_appt_count'] = $this->appointments_model->count_appointments();
		echo json_encode($data);
	}
}
