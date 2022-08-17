<?php 
session_start();

class Authentication_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

     public function login($data)
    {
        $this->db->select('id, email');
        $this->db->where('email', $data['email']);
        $this->db->where('password', md5($data['password']));

        $admin = $this->db->get('admin')->row();

        if($admin != ''){
            $_SESSION["id"] = $admin->id;
            return $admin;
        }else{
            return false;
        }
    }

    public function send_otp($email)
    {
        $this->db->select('id, email');
        $this->db->where('email', $email);

        $admin = $this->db->get('admin')->row();

        if($admin == ''){
            return 0;
        }else{
            $this->db->where('email',$admin->email);
            $this->db->delete('otp');

            $digits = 4;
            $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);

            $this->db->insert('otp', [
                'email'         => $admin->email,
                'otp'           => $otp,
                'date' => date('Y-m-d H:i:s'),
            ]);

            $to = $admin->email;
            $msg = "OTP to reset your password.\n OTP : " . $otp;
            $subject = "Email Verifiaction to set new password";
            
            $this->email->from('sangitabagada.cci@gmail.com');
            $this->email->to($to);
            $this->email->message($msg);
            $this->email->subject($subject);
            $result = $this->email->send();
            
            if($result){
                return $admin;
            }else{
                return 1;
            }
        }
    }

    public function check_otp($data)
    {
        $this->db->where('email', $data['email']);
        $this->db->where('otp', $data['otp']);

        $otp = $this->db->get('otp')->row();
        
        if($otp != ''){
            return true;
        }else{
            return false;
        }
    }

    public function set_password($data)
    {
        if(empty($data['email'])){
            return 0;
        }else {
            $this->db->where('id', $data['id']);
            $admin = $this->db->get('admin')->row();

            if($admin->password == md5($data['new_password'])){
                return 2;
            }else{
                $this->db->where('email', $data['email']);
                $this->db->update('admin', [
                    'password'  => md5($data['new_password']),
                ]);

                if($this->db->affected_rows() > 0){
                    return 2;
                }else{
                    return 1;
                }
            }
        }
    }

}
?>