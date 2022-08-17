<?php 

class Authentication extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('authentication_model');
	}

    public function index()
    {
        if(isset($_SESSION["id"])){
            redirect('admin/dashboard');   
        }else{
            $data['hospital_details'] = $this->db->get('admin')->row();
            $data['PageTitle'] = "Login";
            $data['PageName']  = "login";
            $this->load->view('admin/login_form',$data);
        }
        
    }

	public function login()
    {
        $data = $this->input->post();

        if(empty($data['email']) || empty($data['password'])){
            echo json_encode(['status' => 0,'message'=> 'Please Provide email and password both to login.']);
            
        }else{
            $admin = $this->authentication_model->login($data);

            if($admin){
                if(isset($data['remember_me'])){
                    setcookie('DBS_admin_email', $data['email'], time() + (86400 * 30), "/");
                    setcookie('DBS_admin_password', $data['password'], time() + (86400 * 30), "/");

                }else{
                    setcookie('DBS_admin_email', "", time() - (86400 * 30), "/");
                    setcookie('DBS_admin_password', "", time() - (86400 * 30), "/");
                    
                }
                echo json_encode(['status'=>1,'data'=>$admin,'message'=>'Login Successfull.']);
                
            }else{
                echo json_encode(['status'=>0,'message'=>'Username or password incorrect.']);
                
            }
        }
    }
    
    public function set_device_info()
    {
        $data = $this->input->post();
        if(!empty($data['udid'])){
            
            $count = $this->db->select('COUNT("user") AS count')
                              ->where('user' , 1)
                              ->where('type','admin')
                              ->get('user_devices')->row();
            if($count->count > 0){
                $this->db->set('udid' , $data['udid'])
                         ->where('user' , 1)
                         ->where('type' , 'admin')
                         ->update('user_devices');
            }else{
                $this->db->insert('user_devices',[
                                'user' => 1,
                                'type' => 'admin',
                                'udid' => $data['udid']
                           ]);
            }
        }
        echo json_encode(['status'=>1]);exit;
    }
    
    
    public function do_logout()
    {
        unset($_SESSION["id"]);
        redirect('admin/authentication');
    }

    public function forgot_password()
    {
        $email = $this->input->post('email');

        $admin = $this->authentication_model->send_otp($email);

        if(is_object($admin)){
            echo json_encode(['status'=>1,'data'=>$admin,'message'=>'OTP sent.']);
        }else {
            if($admin == 0){
               echo json_encode(['status'=>0,'data'=>array(),'message'=>'Provide valid email to set password.']);
            }else if($admin == 1){
               echo json_encode(['status'=>0,'data'=>array(),'message'=>'We are having some error to send you OTP in email confirmation.']);
            }
        }
    }

    public function verify_otp()
    {
        $data = $this->input->post();

        if(empty($data['email'])){
            echo json_encode(['status'=>0,'data'=>array(),'message'=>'Invalid user id.']);
        }else if(empty($data['otp'])){
            echo json_encode(['status'=>0,'data'=>array(),'message'=>'Please provide otp.']);
        }else{
            $admin = $this->authentication_model->check_otp($data);

            if($admin){
                echo json_encode(['status'=>1,'data'=>$admin,'message'=>'Set new Password.']);
            }else{  
                echo json_encode(['status'=>0,'data'=>array(),'message'=>'Invalid OTP.']);
            }
        }
    }

    public function set_password()
    {
        $data = $this->input->post();

        if(empty($data['new_password']) || empty($data['confirm_password'])){
            echo json_encode(['status'=>0,'message'=>'Password is not matching']);   
        }else{
            $id = $this->authentication_model->set_password($data);

            if($id == 0){
                echo json_encode(['status'=>0,'message'=>'Invalid email id.']);       
            }else if($id == 1){
                echo json_encode(['status'=>0,'message'=>'Something went wrong while updating password']);   
            }else if($id == 2){
                echo json_encode(['status'=>1,'message'=>'Password Updated.']);   
            }
        }
    }

}
?>
