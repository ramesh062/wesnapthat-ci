<?php 

class Page extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('authentication_model');
        $this->load->model('appointments_model');
	}

	public function index($slug = "")
	{
		$data=[];
		if($slug){
			$data=$this->db->where("slug='".$slug."'")->get("cms_pages")->row();
		}
		$this->load->view('page',$data);	
	}
}
