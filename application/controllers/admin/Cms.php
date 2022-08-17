<?php

class Cms extends CI_Controller
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
	
	public function index(){
		$data=[];
		$data['cms'] = $this->db->select('*')
			->get('cms_pages')->result_array();
		$data['PageTitle'] = 'Pages';
		$data['PageName']  = 'cms';
		$data['doctor_id'] = "";		
		$data['admin']  = $this->db->get('admin')->row();
		$this->load->view('admin/cms_page' , $data);	
	}
	
	public function add_cms(){
		$data=[];
		$data['PageTitle'] = 'Pages';
		$data['PageName']  = 'cms';
		$data['doctor_id'] = "";	
		$data['admin']  = $this->db->get('admin')->row();
		$this->load->view("admin/cms_form",$data);
	}
	
	public function edit_cms($id){
		$data=[];
		$data['PageTitle'] = 'Pages';
		$data['PageName']  = 'cms';
		$data['doctor_id'] = "";
		$data['admin']  = $this->db->get('admin')->row();
		$data["cms"]=$this->db->select("*")->where("id=".$id."")->get("cms_pages")->row();
		$this->load->view('admin/cms_form' , $data);
	}	
	
	public function save_cms(){
		$data = $this->input->post();
    	if(!empty($data["id"])){
    		$data['last_updated'] = date('Y-m-d H:i:s');
    		$this->db->set('content' , $data['content'])
					->set('page_name' , $data['page_name'])
    		         ->where('id' , $data['id'])
    		         ->update('cms_pages');
		}else{
			$cms=$this->db->select("*")->where("page_name='".$data['page_name']."'")->get("cms_pages")->row();
			$data['reg_date'] = date('Y-m-d H:i:s');
			unset($data["content"],$data["id"]);
			$data["slug"]=str_replace(" ","-",$data["page_name"]);
			$this->db->insert('cms_pages',$data);
			$insert_id = $this->db->insert_id();
		}	
		redirect(base_url('/admin/cms/index'), 'refresh');
	}
	public function delete_cms($id){
		if($id>0){
			$this->db->delete("cms_pages",["id"=>$id]);
		}
		redirect(base_url('/admin/cms/index'), 'refresh');
	}
	
    public function privacy_policy()
    {
    	//if(isset($_SESSION["id"])){
    // 		if($page_id == 2){
				// $data['PageTitle'] = "Terms & Conditions";
		  //      $data['PageName']  = "cms";
		        
		  //  }else if($page_id == 3){
    //  			$data['PageTitle'] = "Privacy Policy";
    //  	        $data['PageName']  = "cms";
		     	          
		  //  }

		    $data['cms'] = $this->db->select('id AS page_id,page_name,slug,content')
								    ->where('id' , 3)
								    ->get('cms_pages')->row();
								
		    $this->load->view('admin/cms_page' , $data);
    // 	}else{
    // 		redirect('admin/authentication');
    // 	}
    }
}
