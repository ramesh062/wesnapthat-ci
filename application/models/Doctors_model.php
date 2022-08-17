<?php 

class Doctors_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_doctors()
    {
    	$this->db->where('status','active');
    	$result = $this->db->get('doctors')->result_array();
    	return $result;
    }

}