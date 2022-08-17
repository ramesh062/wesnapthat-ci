<?php 

class Appointments_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get()
    {	
    	$this->db->select('appointments.id,patients.fullname as patient_name,appointments.status,appointments.time,appointments.date');
    	$this->db->from('appointments');
    	$this->db->join('patients','patients.id=appointments.patient_id');
    	$this->db->where('appointments.status','upcoming');
        $this->db->where('appointments.date >=' , date('Y-m-d'));
		if(!empty($_REQUEST["doctor_id"]))
			$this->db->where("appointments.doctor_id",$_REQUEST["doctor_id"]);
        $this->db->limit(5);
    	$appointments = $this->db->get()->result_array();
    	return $appointments;
    }

    public function get_by_status($type)
    {
    	if($type == 'upcoming' || $type == 'completed'){
    		$this->db->where('appointments.status',$type);
    	}

    	$this->db->select('appointments.id,patients.fullname as patient_name,patients.profile_photo as patient_photo,doctors.fullname as doctor_name,appointments.status,appointments.time,appointments.date');
    	$this->db->from('appointments');
    	$this->db->join('patients','patients.id=appointments.patient_id');
    	$this->db->join('doctors','doctors.id=appointments.doctor_id');
    	$appointments = $this->db->get()->result_array();
    	return $appointments;
    }

    public function count_appointments()
    {
		if(!empty($_REQUEST["doctor_id"]))
			$this->db->where("doctor_id",$_REQUEST["doctor_id"]);
       	$appt = $this->db->get('appointments')->num_rows();
  	   	$input = number_format($appt);
		   
	   $input_count = substr_count($input, ',');
	   if($input_count != '0'){
	       if($input_count == '1'){
	           return substr($input, 0, -4).'k';
	       } else if($input_count == '2'){
	           return substr($input, 0, -8).'mil';
	       } else if($input_count == '3'){
	           return substr($input, 0,  -12).'bil';
	       } else {
	           return;
	       }
	   } else {
	       return $input;
	   }
    }

    public function get_doctors()
    {
    	$this->db->where('status','active');
        // $this->db->limit(3);
		$this->db->order_by("fullname");
    	$doctors = $this->db->get('doctors')->result_array();
    	return $doctors;
    }

    public function doctors_appt()
    {
        //$this->db->where('status','active');
    	$this->db->select('DISTINCT(doctors.id),`fullname`,(SELECT COUNT(id) FROM appointments WHERE doctor_id = doctors.id) AS appt_count,`status`');
    	$result = $this->db->get('doctors')->result_array();
    	
    	return $result;
    }

    public function get_apptmnt_by_doctor($id,$type)
    {
        if($type == 'upcoming' || $type == 'completed'){
            $this->db->where('appointments.status',$type);
        }

        $this->db->select('appointments.id,patients.fullname as patient_name,patients.profile_photo as patient_photo,doctors.fullname as doctor_name,appointments.status,appointments.time,appointments.date');
        $this->db->from('appointments');
        $this->db->join('patients','patients.id=appointments.patient_id');
        $this->db->join('doctors','doctors.id=appointments.doctor_id');
        $this->db->where('appointments.doctor_id' , $id);
        $appointments = $this->db->get()->result_array();
        return $appointments;
    }
    
    
    public function send_appointment_mail($data)
    {
        $doctor = $this->db->select('fullname')
                           ->from('doctors')
                           ->where('id',$data['doctor_id'])
                           ->get()->row();
        
        $to = $data['email'];
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
        
        $this->email->from('sangitabagada.cci@gmail.com');
        $this->email->to($to);
        $this->email->message($msg);
        $this->email->subject($subject);

        $result = $this->email->send();
        
        return 1;
        
    }   
    
}
