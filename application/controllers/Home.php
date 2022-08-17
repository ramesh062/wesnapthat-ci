<?php 

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// $data=["page_name"=>"Home"];
		$this->load->view('home');	
	}
}
