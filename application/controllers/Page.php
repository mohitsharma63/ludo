<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Page extends CI_Controller
{

    public function manifest(){
       
        $data['name']=COMPANY_NAME;
        $data['short_name']=COMPANY_NAME;
        $data["icons"] = array([
            "src"=>base_url(APP_ICON),
            "type"=>"images/png",
            "sizes"=>"512x512",
             "purpose"=> "any"
        ],
        [
            "src"=>base_url(APP_ICON_2),
            "type"=>"images/png",
            "sizes"=>"144x144",
            "purpose"=> "any"
        ]
        );
        $data['id']="/?source=pwa";
        $data['start_url']=base_url();
        $data['background_color']='#34495E';
        $data['display']="standalone";
        $data['scope']="/";
        $data['theme_color']="#34495E";
        $data['orientation']="portrait";
        $data['description']="developed by devninja";


        


header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);
    }


    public function autologin()
    {
        
        
        if(isset($_SESSION['UserAuth'])) redirect(base_url('home'));
   
       
        if (isset($_COOKIE['_access_token']) && !isset($_SESSION['UserAuth'])) {
            $authId = $this->secure('decrypt', $_COOKIE['_access_token']);

            $user = $this->db->where('id', $authId)->get('users')->row();

          
            if ($user) {
                $_SESSION['UserAuth'] = $_COOKIE['_access_token'];
                setcookie('_access_token', $_SESSION['UserAuth'], time() + (86400 * 30), "/");
                redirect(base_url('home'));
            } else {
                setcookie('_access_token', null, time() - (86400 * 30), "/");
            }
        }
    }


   



    function secure($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'xxxxxxxxxxxxxxxxxxxxxxxx';
        $secret_iv = 'xxxxxxxxxxxxxxxxxxxxxxxxx';
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes 
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    protected function unset_unreg()
    {
        unset($_SESSION['unreg-userdata']);
        unset($_SESSION['otp']);
    }
    public function index()
    {
        $this->autologin();
        $this->unset_unreg();
        $data['title'] = COMPANY_NAME;
        $this->load->view('user/common/header', $data);
        $this->load->view('user/public/info', $data);
        $this->load->view('user/public/homepage', $data);
        $this->load->view('user/common/footer', $data);
    }

    public function login()
    {
        $this->autologin();
        $this->unset_unreg();
        $data['title'] = COMPANY_NAME . ' | Login';
        $this->load->view('user/common/header', $data);
        $this->load->view('user/public/login', $data);
        $this->load->view('user/common/footer', $data);
    }

    


    public function signup($refercode='')
    {
       
        $this->autologin();
        $this->unset_unreg();

       
$ref = $this->db->where('referral_code',$refercode)->get('users')->row();
if($refercode && $ref){
    $data['rc'] = strtoupper($refercode);
}

        $data['title'] = COMPANY_NAME . ' | Signup';
        
        $this->load->view('user/common/header', $data);
        $this->load->view('user/public/signup', $data);
        $this->load->view('user/common/footer', $data);
    }

    public function verify_otp()
    {
        $this->autologin();
        if (!isset($_SESSION['unreg-userdata'])) redirect(base_url());
        $data['title'] = COMPANY_NAME . ' | Verify Otp';
        $data['mobile_no'] = $_SESSION['unreg-userdata']['mobile_no'];
        $this->load->view('user/common/header', $data);
        $this->load->view('user/public/verify_otp', $data);
        $this->load->view('user/common/footer', $data);
    }
}
