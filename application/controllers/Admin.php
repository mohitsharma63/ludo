<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    protected $admin;

    function auth(){
        if(isset($_SESSION['AdminAuth'])){
        $this->admin = $this->db->where('id',$_SESSION['AdminAuth'])->get('admins')->row();
        if($this->admin->status==0) redirect(base_url('admin/logout2'));
        }else{
        redirect(base_url('admin/login'));
        }
    }

 public function fix(){
        $this->auth();
        $txns = $this->db->select('*,COUNT(*) as wins')->having('wins >',1)->where('tag','WIN_REWARD')->group_by('match_id')->get('txns')->result();
        
        foreach($txns as $txn){
            $match = $this->db->where('id',$txn->match_id)->get('matches')->row();
            $txn_s = $this->db->where('tag','WIN_REWARD')->where('match_id',$match->id)->get('txns')->result();
            $delete=[];
            $validtxn=[];
           
            foreach($txn_s as $t){
                if(!$validtxn){
                     if($match->winner_id==$t->user_id){
                         $validtxn[]=$t;
                     }else{
                          $delete[]=$t;
                     }
                }else{
                    $delete[]=$t;
                }
            }
           
         
            foreach($delete as $delt){
                
                $this->db->where('id',$delt->id)->delete('txns');
            }
         
        }
        
        
      
        
        
 }

    public static function secure($action, $string)
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

    function nonauth(){
        if(isset($_SESSION['AdminAuth'])){
        redirect(base_url('admin'));
        }
    }

    public function checklogin(){
        $req = $this->input->post();
        if(!$req) redirect(basee_url('admin'));
        
        $access['email_id'] = $req['email_id'];
        $access['password'] = $this->secure('encrypt',$req['password']);
       
$admin = $this->db->where($access)->get('admins')->row();

if($admin){

    if($admin->status==1){
        $_SESSION['AdminAuth']=$admin->id;
        $_SESSION['AdminEmail']=$admin->email_id;
        $this->log($admin->email_id.' logged in successfully');
        $response['status'] = true;
    }else{
        $this->log($req['email_id'].' try to logged in & failed because account status is inactive');
        $response['status'] = false;
        $response['msg'] = 'your admin account is inactive';
        $response['status'] = false;

    }
    
}else{
    $this->log($req['email_id'].' try to logged in & failed with password '.$req['password']);
    $response['status'] = false;
    $response['msg'] = 'incorrect email id or password';
}

       

        echo json_encode($response);
    }

    function ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function txnid()
    {
        
       
        $lat=$this->db->order_by('id', 'desc')->get('txns')->row();
        if($lat) $last_txn_id=$lat->txnid;
        else $last_txn_id = TXN_UID.'txn14271427142';
        
        $last_txn_id = str_replace(TXN_UID.'txn', '', $last_txn_id);


        return TXN_UID.'txn' . $last_txn_id + 1;
    }

    public function addtxn(){
        $this->auth();
        $req=$this->input->post();
        $userid=$this->secure('decrypt',$req['user']);

        $user=$this->db->where('id',$userid)->get('users')->row();

        if(isset($req['type']) && isset($req['amount'])){
            $response['status'] = true;
            $response['msg'] = 'transaction added !';

                $txn['user_id']=$userid;
                $txn['txnid']=$this->txnid();
                $txn['amount']=$req['amount'];
                $txn['created_at']=time();
                $txn['updated_at']=time();
                $txn['status']=2;


                

            if($req['type']=='TDM'){
                $txn['remarks']='Deposit to Wallet By Admin';
                $txn['type']='CREDIT';
                $txn['tag']='DEPOSIT';
                $this->db->insert('txns',$txn);
                $this->log($this->admin->email_id.' deposited ₹'.$txn['amount'].' to '.$user->mobile_no.' wallet');

            }elseif($req['type']=='TP'){
                $txn['remarks']='Penalty By Admin';
                $txn['type']='DEBIT';
                $txn['tag']='PENALTY';
                $this->db->insert('txns',$txn);
                $this->log($this->admin->email_id.' added penalty of ₹'.$txn['amount'].' to '.$user->mobile_no);
            }else{
                $response['status'] = false;
                $response['msg'] = 'please select valid transaction type';
            }
        }else{
            $response['status'] = false;
            $response['msg'] = 'please provide valid details';
        }

        echo json_encode($response);
        
        
    }

    public function deleteadmin($id){
        $this->auth();
        $id=$this->secure('decrypt',$id);
        if($id<2){
 $_SESSION['error-msg']='FUCK YOU';
redirect(base_url('admin/manageadmins/'));
        }

$ad = $this->db->where('id',$id)->get('admins')->row();
$this->db->where('id',$id)->delete('admins');
$this->log($this->admin->email_id.' deleted admin user  ('.$ad->email_id.')');
$_SESSION['done-msg']='admin deleted!';
redirect(base_url('admin/manageadmins/'));

        
    }



    public function addnewadmin(){
        $this->auth();
        $req=$this->input->post();

        $adminindb=$this->db->where('email_id',$req['email_id'])->get('admins')->row();
        if($adminindb){
            $_SESSION['error-msg']='email id is already used';
redirect(base_url('admin/manageadmins/'));
        }

$admin['email_id']=$req['email_id'];
$admin['full_name']=$req['full_name'];

$admin['password']=$this->secure('encrypt',$req['password']);
$admin['full_name']=$req['full_name'];
$admin['status']=$req['status'];
if(isset($req['permission'])){
    $admin['permissions']=implode('#',$req['permission']);
}else{
    $admin['permissions']='';
}

$admin['created_at']=time();
$admin['updated_at']=time();


$this->db->insert('admins',$admin);
$this->log($this->admin->email_id.' added new admin ('.$admin['email_id'].')');
$_SESSION['done-msg']='new admin added !';
redirect(base_url('admin/manageadmins/'));

        
    }

public function getPermissions(){
    $permissions['p_mu']='Manage Users';
$permissions['p_snsu']='Send Notification';
$permissions['p_bu']='Ban User';
$permissions['p_at']='Add Transaction';

$permissions['p_mkr']='Manage KYCs Requests';
$permissions['p_mwr']='Manage Withdraws Requests';
$permissions['p_mcr']='Manage Cancellation Requests';
$permissions['p_mc']='Manage Conflicts Requests';
$permissions['p_mpmr']='Manage Pending Results';
$permissions['p_mhd']='Match History & Data';
return $permissions;
}



public function updateconfig(){
    $this->auth();
    $req=$this->input->post();

$this->db->where('id',1)->update('config',$req);
//   $_SESSION['error-msg']='you are not allowed, to this action';
$_SESSION['done-msg']='updated !';
$this->log($this->admin->email_id.' updated configuration');
redirect(base_url('admin/config/'));

    
}

public function updatesuperadmin(){
    //   $_SESSION['error-msg']='you are not allowed, to this action';
    $this->auth();
    $req=$this->input->post();
$req['password']=$this->secure('encrypt',$req['password']);
$this->db->where('id',1)->update('admins',$req);
 
$_SESSION['done-msg']='updated !';
$this->log($this->admin->email_id.' updated superadmin');
redirect(base_url('admin/config/'));

    
}


    public function updateadmin($id){
        $this->auth();
        $req=$this->input->post();

        $id=$this->secure('decrypt',$id);

        $adminindb=$this->db->where('id !=',$id)->where('email_id',$req['email_id'])->get('admins')->row();
        if($adminindb){
            $_SESSION['error-msg']='email id is already used';
redirect(base_url('admin/manageadmins/'));
        }

$admin['email_id']=$req['email_id'];
$admin['full_name']=$req['full_name'];

$admin['password']=$this->secure('encrypt',$req['password']);
$admin['full_name']=$req['full_name'];
$admin['status']=$req['status'];
if(isset($req['permission'])){
    $admin['permissions']=implode('#',$req['permission']);
}else{
    $admin['permissions']='';
}


$admin['updated_at']=time();


$this->db->where('id',$id)->update('admins',$admin);
$this->log($this->admin->email_id.' updated admin ('.$admin->email_id.')');
$_SESSION['done-msg']='admin updated !';
redirect(base_url('admin/manageadmins/'));

        
    }

    public function sendnotification(){
        $this->auth();
        $req=$this->input->post();
        $userid=$this->secure('decrypt',$req['user']);

        $not['message']= htmlspecialchars($req['message']);
        $not['user']= htmlspecialchars($userid);
        $not['created_at']= time();
        $this->db->insert('notifications',$not);


        if($userid>0){
        $_SESSION['done-msg']='notfication sended to this user only';
        $this->db->where('id',$userid)->set('notifications','notifications+1',FALSE)->update('users');
        redirect(base_url('admin/openuser/'.$req['user']));
        }else{
            $this->db->set('notifications','notifications+1',FALSE)->update('users');
        $_SESSION['done-msg']='notfication sended to all the users';
        redirect(base_url('admin/managenotifications/'));

        }
        
    }

    public function rejectkyc($id){
        $this->auth();
        $req=$this->input->post();
        $userid=$this->secure('decrypt',$id);

        $kyc['remarks']= htmlspecialchars($req['remarks']);
        $kyc['status']= 0;

      
        $this->db->where('user_id',$userid)->update('kyc',$kyc);

        $user=$this->db->where('id',$userid)->get('users')->row();
        $this->log($this->admin->email_id.' rejected kyc of '.$user->full_name.' ('.$user->mobile_no.')');

        $_SESSION['done-msg']='kyc rejected !';
        redirect(base_url('admin/managekyc/'));

        
    }




    public function approvekyc($id){
        $this->auth();
        $req=$this->input->post();
        $userid=$this->secure('decrypt',$id);

        $kyc['remarks']= 'kyc approved by admin';
        $kyc['status']= 2;

      
        $this->db->where('user_id',$userid)->update('kyc',$kyc);

        $user=$this->db->where('id',$userid)->get('users')->row();
$this->log($this->admin->email_id.' approved kyc of '.$user->full_name.' ('.$user->mobile_no.')');

        $_SESSION['done-msg']='kyc approved !';
        redirect(base_url('admin/managekyc/'));

        
    }


    public function submitresult($id){
        $this->auth();
        $req=$this->input->post();
        $mid=$this->secure('decrypt',$id);
        if(!$req['winner']) redirect(base_url('admin/pendingresult'));

      
        $match = $this->db->where('id',$mid)->where('((host_result>0 AND joiner_result=0) OR (host_result=0 AND joiner_result>0))')->where('status',2)->get('matches')->row();
        if(!$match) redirect(base_url('admin/pendingresult'));

        

        $host=$this->db->where('id',$match->host_id)->get('users')->row();
        $joiner=$this->db->where('id',$match->joiner_id)->get('users')->row();

        $winner = $req['winner'];
        if($winner==$host->id){
            $looser = $joiner->id;
        }elseif($winner==$joiner->id){
            $looser = $host->id;
        }

      
        
        $win_txn['user_id']=$winner;
        $win_txn['txnid']=$this->txnid();
        $win_txn['amount']=$match->prize;
        $win_txn['created_at']=$win_txn['updated_at']=time();
        $win_txn['type']='CREDIT';
        $win_txn['tag']='WIN_REWARD';
        $win_txn['status']=2;
        $win_txn['remarks']='Match Winned !';
        $win_txn['match_id']=$match->id;
        $this->db->insert('txns',$win_txn);

        
   
        

        $wu = $this->db->where('id',$winner)->get('users')->row();

        $refer = $this->db->where('referral_code',$wu->refer_by)->get('users')->row();

        if($refer){
            $reward['user_id']=$refer->id;
            $reward['txnid']=$this->txnid();
            $reward['amount']=$this->getRefBonus($match->amount);
            $reward['created_at']=time();
            $reward['updated_at']=time();
            $reward['type']='CREDIT';
            $reward['tag']='REFERRAL_BONUS';
            $reward['status']=2;
            $reward['data']=$winner;
            $reward['remarks']='Referral Bonus';
            $reward['match_id']=$match->id;

            $this->db->insert('txns',$reward);
        }



$matchup['winner_id']=$winner;
$matchup['looser_id']=$looser;
$matchup['status']=4;

$this->db->where('id',$match->id)->update('matches',$matchup);

$this->log($this->admin->email_id.' updated pending result of match #'.$match->id);
$_SESSION['done-msg']='match result submitted !';
redirect(base_url('admin/pendingresult'));






    }



 public function resethost($id=0){
        $this->auth();
        $matchid=$this->secure('decrypt',$id);
        $match=$this->db->where('id',$matchid)->where('status',2)->get('matches')->row();
        if($match){
            $this->db->where('id',$match->id)->update('matches',['host_result'=>0]);
            $_SESSION['done-msg']='lost result reseted';
              $this->log($admin->email_id.' reseted host lost result of Match #'.$match->id);
redirect(base_url('admin/openmatch/'.$id));
        }else{
redirect(base_url('admin'));
        }
    }
    
     public function resetjoiner($id=0){
        $this->auth();
        $matchid=$this->secure('decrypt',$id);
        $match=$this->db->where('id',$matchid)->where('status',2)->get('matches')->row();
        if($match){
            $this->db->where('id',$match->id)->update('matches',['joiner_result'=>0]);
            $_SESSION['done-msg']='lost result reseted';
            $this->log($admin->email_id.' reseted joiner lost result of Match #'.$match->id);
redirect(base_url('admin/openmatch/'.$id));
        }else{
redirect(base_url('admin'));
        }
    }
    
    

 public function resolveconflict($id){
        $this->auth();
        $req=$this->input->post();
        $cid=$this->secure('decrypt',$id);
        if(!$req['winner']) redirect(base_url('admin'));

         $conflict = $this->db->where('status',1)->where('id',$cid)->get('conflicts')->row();
        
        if(!$conflict){
            $_SESSION['info-msg']='conflict already resolved';
            redirect(base_url('admin/manageconflicts'));
        } 
        
        $match = $this->db->where('status',2)->where('id',$conflict->match_id)->get('matches')->row();
            if(!$match){
            $_SESSION['info-msg']='conflict already resolved';
            redirect(base_url('admin/manageconflicts'));
        } 
        
        $host=$this->db->where('id',$match->host_id)->get('users')->row();
        $joiner=$this->db->where('id',$match->joiner_id)->get('users')->row();

        $winner = $req['winner'];
        if($winner==$host->id){
            $looser = $joiner->id;
        }elseif($winner==$joiner->id){
            $looser = $host->id;
        }

        $this->db->where('id',$conflict->id)->update('conflicts',['status'=>2,'updated_at'=>time()]);
        
        $win_txn['user_id']=$winner;
        $win_txn['txnid']=$this->txnid();
        $win_txn['amount']=$match->prize;
        $win_txn['created_at']=$win_txn['updated_at']=time();
        $win_txn['type']='CREDIT';
        $win_txn['tag']='WIN_REWARD';
        $win_txn['status']=2;
        $win_txn['remarks']='Match Winned !';
        $win_txn['match_id']=$match->id;
        $this->db->insert('txns',$win_txn);

        $p_txn['user_id']=$looser;
        $p_txn['txnid']=$this->txnid();
        $p_txn['amount']=WRONG_RESULT_PENALTY;
        $p_txn['created_at']=$p_txn['updated_at']=time();
        $p_txn['type']='DEBIT';
        $p_txn['tag']='PENALTY';
        $p_txn['status']=2;
        $p_txn['remarks']='Penalty for wrong result';
        $p_txn['match_id']=$match->id;
        $this->db->insert('txns',$p_txn);

   
        

        $wu = $this->db->where('id',$winner)->get('users')->row();

        $refer = $this->db->where('referral_code',$wu->refer_by)->get('users')->row();

        if($refer){
            $reward['user_id']=$refer->id;
            $reward['txnid']=$this->txnid();
            $reward['amount']=$this->getRefBonus($match->amount);
            $reward['created_at']=time();
            $reward['updated_at']=time();
            $reward['type']='CREDIT';
            $reward['tag']='REFERRAL_BONUS';
            $reward['status']=2;
            $reward['data']=$winner;
            $reward['remarks']='Referral Bonus';
            $reward['match_id']=$match->id;

            $this->db->insert('txns',$reward);
        }



$matchup['winner_id']=$winner;
$matchup['looser_id']=$looser;
$matchup['status']=4;

$this->db->where('id',$match->id)->update('matches',$matchup);

$this->log($this->admin->email_id.' resolved conflict & updated result of match #'.$match->id);
$_SESSION['done-msg']='conflict resolved !';
redirect(base_url('admin/manageconflicts'));






    }

    public function getRefBonus($amount, $matchid = 0)
    {
        $prize = ($amount * ($this->db->get('config')->row()->referral_bonus/100));
        if (fmod($prize, 1) == 0) {
            $prize = floor($prize);
        }

        return $prize;
    }


    public function rejectcancel($id){
        $this->auth();
        $req=$this->input->post();
        $cid=$this->secure('decrypt',$id);
       
    
        $cancel = $this->db->where('id',$cid)->where('status',1)->get('cancel_reqs')->row();
        if(!$cancel) redirect(base_url('admin/cancelrequest'));
       
    
       
        $this->db->where('id',$cancel->id)->update('cancel_reqs',['status'=>0,'updated_at'=>time()]);
        
        
    
    $this->log($this->admin->email_id.' rejeted cancellation request of match #'.$cancel->match_id);
    $_SESSION['done-msg']='cancellation request rejected !';
    redirect(base_url('admin/cancelrequest'));
    
    
    
    
    
    
    }

 public function approvecancel($id){
    $this->auth();
    $req=$this->input->post();
    $cid=$this->secure('decrypt',$id);
   

    $cancel = $this->db->where('id',$cid)->where('status',1)->get('cancel_reqs')->row();
    if(!$cancel) redirect(base_url('admin/cancelrequest'));

    $match = $this->db->where('id',$cancel->match_id)->where('status',2)->get('matches')->row();
    if(!$match) redirect(base_url('admin/cancelrequest'));

    if($match->host_result || $match->joiner_result){
        $_SESSION['done-msg']='1 of the player already submitted the result, cancel the request';

       redirect(base_url('admin/cancelrequest'));
    }



    $conflict = $this->db->where('match_id',$match->id)->get('conflicts')->row();
$_SESSION['done-msg']='conflict created on this match, reject the cancel request or resolve the conflict';

    if($conflict) redirect(base_url('admin/cancelrequest'));

    $host=$this->db->where('id',$match->host_id)->get('users')->row();
    $joiner=$this->db->where('id',$match->joiner_id)->get('users')->row();

   
    $this->db->where('id',$cancel->id)->update('cancel_reqs',['status'=>2,'updated_at'=>time()]);
    
    $win_txn['user_id']=$host->id;
    $win_txn['txnid']=$this->txnid();
    $win_txn['amount']=$match->amount;
    $win_txn['created_at']=$win_txn['updated_at']=time();
    $win_txn['type']='CREDIT';
    $win_txn['tag']='MATCH_REFUND';
    $win_txn['status']=2;
    $win_txn['remarks']='match cancelled !';
    $win_txn['match_id']=$match->id;
    $this->db->insert('txns',$win_txn);

    $win_txn['user_id']=$joiner->id;
    $win_txn['txnid']=$this->txnid();
    
    $this->db->insert('txns',$win_txn);


    



$matchup['remarks']='cancelled by admin';
$matchup['status']=3;

$this->db->where('id',$match->id)->update('matches',$matchup);

$this->log($this->admin->email_id.' accepted cancellation request of match #'.$match->id);
$_SESSION['done-msg']='match cancelled and money is refunded to their wallet';
redirect(base_url('admin/cancelrequest'));






}

    public function approvewithdraw($id){
        $this->auth();
        $req=$this->input->post();
        $wid=$this->secure('decrypt',$id);

        $withdraw = $this->db->where('id',$wid)->get('withdraws')->row();
        $user= $this->db->where('id',$withdraw->user_id)->get('users')->row();


        $wd['data']= 'money transferred by admin';
        $wd['status']= 2;

        $dir = './assets/images/withdraws/' . $user->mobile_no . '/';
        $screenshot = $this->do_upload('screenshot', $dir);
      

        if (isset($screenshot['upload_data']) && isset($screenshot['upload_data'])) {

            $wd['screenshot'] = $screenshot['upload_data']['file_name'];
            $wd['updated_at'] = time();
            $this->db->where('id',$withdraw->id)->update('withdraws',$wd);

            $txn['status']=2;
            $txn['updated_at']=time();
            $this->db->where('txnid',$withdraw->txnid)->update('txns',$txn);

            $this->log($this->admin->email_id.' approved withdraw request of '.$user->full_name.' ('.$user->mobile_no.') of ₹ '.$withdraw->total_amount);

        $_SESSION['done-msg']='withdraw request approved';
        redirect(base_url('admin/withdraws/'));

           
            
        } else {

            $_SESSION['error-msg'] = 'please upload a valid image , size should be 2mb or less';
            redirect(base_url('admin/withdraws/'));
        }


    }


    public function rejectwithdraw($id){
        $this->auth();
        $req=$this->input->post();
        $wid=$this->secure('decrypt',$id);

        $withdraw = $this->db->where('id',$wid)->get('withdraws')->row();
        $user= $this->db->where('id',$withdraw->user_id)->get('users')->row();


        $wd['data']= $req['remarks'];
        $wd['status']= 0;

       
      

     
            $wd['updated_at'] = time();

          
            $this->db->where('id',$withdraw->id)->update('withdraws',$wd);

            $txn['status']=0;
            $txn['updated_at']=time();
            $this->db->where('txnid',$withdraw->txnid)->update('txns',$txn);

            $this->log($this->admin->email_id.' rejected withdraw request of '.$user->full_name.' ('.$user->mobile_no.') of ₹ '.$withdraw->total_amount);

        $_SESSION['done-msg']='withdraw request rejected';
        redirect(base_url('admin/withdraws/'));

           
            
      


    }

    public function do_upload($file, $dir)
    {

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $config['upload_path']          = $dir;
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 2048;
        $config['encrypt_name'] = true;


        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($file)) {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());

            return $data;
        }
    }

    function log($activity){
        $log['activity']=$activity;
        $log['created_at']=time();
        $log['ipaddress']=$this->ip();
        $log['device']=$_SERVER['HTTP_SEC_CH_UA_PLATFORM'];
        $this->db->insert('admin_logs',$log);
    }

    public function logout2(){
     
        $_SESSION['done-msg']=" logged out by superadmin";
        $this->log($_SESSION['AdminEmail']." logged out automatically because superadmin set account as inactive");

        unset($_SESSION['AdminAuth']);
        unset($_SESSION['AdminEmail']);

        redirect(base_url('admin/login'));
    }

    public function logout(){
        $this->auth();
        $_SESSION['done-msg']=" logged out successfully";
        $this->log($_SESSION['AdminEmail']." logged out successfully");

        unset($_SESSION['AdminAuth']);
        unset($_SESSION['AdminEmail']);

        redirect(base_url('admin/login'));
    }

    public static function amount($amount)
    {

        if (fmod($amount, 1) == 0) {
            $amount = floor($amount);
        }

        return $amount;
    }

    public function time($day){
        $data = new stdClass();
        
        if($day==1){
            $data->start = strtotime(date('d F Y',time()).' 12:00 am');
            $data->end = strtotime(date('d F Y',time()).' 11:59:59 pm');
        }elseif($day==0){
            $data->start=0;
            $data->end=strtotime(date('d F Y',time()).' 11:59:59 pm');
        }else{
            $data->start = strtotime($day['start'].' 12:00 am');
            $data->end = strtotime($day['end'].' 11:59:59 pm');
        }
    

 
return $data;
    }

    public function format($time){
        return strtoupper(date('d M, Y h:i a',$time));
    }

    public function getWalletBalance($userid)
    {
        $this->auth();
        $credit = $this->db->select('SUM(amount) as amount')->where('status', 2)->where('type', 'CREDIT')->where('user_id', $userid)->get('txns')->row()->amount;
        $debit = $this->db->select('SUM(amount) as amount')->where('status', 2)->where('type', 'DEBIT')->where('user_id', $userid)->get('txns')->row()->amount;
        $withdraw = $this->db->select('SUM(total_amount) as amount')->where('status', 1)->where('user_id', $userid)->get('withdraws')->row()->amount;

        $balance = ($credit - $debit-$withdraw);
        return $this->amount($balance);
    }

    public function getWalletBalanceAll()
    {
        $this->auth();
        $credit = $this->db->select('SUM(amount) as amount')->where('status', 2)->where('type', 'CREDIT')->get('txns')->row()->amount;
        $debit = $this->db->select('SUM(amount) as amount')->where('status', 2)->where('type', 'DEBIT')->get('txns')->row()->amount;
        $withdraw = $this->db->select('SUM(total_amount) as amount')->where('status', 1)->get('withdraws')->row()->amount;

        $balance = ($credit - $debit-$withdraw);
        return $this->amount($balance);
    }

    public function newusers($start,$end,$page)
    {
        $this->auth();

        $timecondition="created_at BETWEEN  ".$start." AND ".$end;
        $offset = ($page - 1) * 8;
        $data['users'] = $this->db->where($timecondition)->order_by('id', 'desc')->limit(8,$offset)->get('users')->result();
        $data['fn']=$this;
        $this->load->view('admin/auth/newusers', $data);
    }


    public function fetchmatches($userid){
        $this->auth();
        $id=$this->secure('decrypt',$userid);
        $req=$this->input->post();

        $where=array();

        if($req['type']=='active'){
        $where['status <']=3;
        $where['status >']=-1;
        }elseif($req['type']=='cancel'){
            $where['status']=3;  
        }elseif($req['type']=='win'){
            $where['winner_id']=$id;
        }elseif($req['type']=='lose'){
            $where['looser_id']=$id;
        }

        $data['items']=$items=$this->db->where($where)->where('(host_id='.$id.' OR joiner_id='.$id.')')->order_by('id', 'desc')->get('matches')->result();
        if(!$items) die();
        $data['fn']=$this;
        $data['user']=$this->db->where('id',$id)->get('users')->row();
        $this->load->view('admin/auth/f_matches', $data);

    }
    

    // public function fetchadminlogs($start,$end,$page)
    // {
    //     $this->auth();

    //     $timecondition="created_at BETWEEN  ".$start." AND ".$end;
    //     $offset = ($page - 1) * 8;
    //     $data['items'] = $this->db->where($timecondition)->order_by('id', 'desc')->limit(8,$offset)->get('admin_logs')->result();
    //     $data['fn']=$this;
    //     $this->load->view('admin/auth/f_logs', $data);
    // }

    public function fetchmatchlist($mobileno,$page){
        $this->auth();

        if($mobileno){
            $timecondition="(id LIKE '$mobileno%')";
        }else{
            $timecondition=[];
        }
       
        $offset = ($page - 1) * 8;
        $data['items'] = $items=$this->db->where($timecondition)->order_by('id', 'desc')->limit(8,$offset)->get('matches')->result();
        $data['fn']=$this;
        if(!$items) die();
        $this->load->view('admin/auth/f_matchhistory', $data);

    }

    public function fetchconflicts($mobileno,$page){
        $this->auth();

        if($mobileno){
            $timecondition="(match_id LIKE '$mobileno%')";
        }else{
            $timecondition=[];
        }
       
        $offset = ($page - 1) * 8;
        $data['items'] = $items=$this->db->where($timecondition)->order_by('created_at', 'desc')->limit(8,$offset)->get('conflicts')->result();
        $data['fn']=$this;
        if(!$items) die();
        $this->load->view('admin/auth/f_manageconflicts', $data);

    }

    public function fetchcancels($mobileno,$page){
        $this->auth();

        if($mobileno){
            $timecondition="(match_id LIKE '$mobileno%')";
        }else{
            $timecondition=[];
        }
       
        $offset = ($page - 1) * 8;
        $data['items'] = $items=$this->db->where($timecondition)->order_by('created_at', 'desc')->limit(8,$offset)->get('cancel_reqs')->result();
        $data['fn']=$this;
        if(!$items) die();
        $this->load->view('admin/auth/f_managecancels', $data);

    }

    public function fetchpendingmatchlist($mobileno,$page){
        $this->auth();

        if($mobileno){
            $timecondition="(id LIKE '$mobileno%')";
        }else{
            $timecondition=[];
        }
       
        $offset = ($page - 1) * 8;
        $data['items'] = $items=$this->db->where($timecondition)->where('status',2)->where('((host_result>0 AND joiner_result=0) OR (host_result=0 AND joiner_result>0))')->order_by('id', 'desc')->limit(8,$offset)->get('matches')->result();
        $data['fn']=$this;
        if(!$items) die();
        $this->load->view('admin/auth/f_pendingmatchhistory', $data);

    }

    public function fetchtxns($userid){
        $this->auth();
        $id=$this->secure('decrypt',$userid);
        $req=$this->input->post();

        $where['user_id']=$id;

        if($req['type']!='ALL'){
        $where['tag']=$req['type'];
        }

        $data['items']=$items=$this->db->where($where)->order_by('id', 'desc')->get('txns')->result();
        if(!$items) die();
        $data['fn']=$this;
        $data['user']=$this->db->where('id',$id)->get('users')->row();
        $this->load->view('admin/auth/f_txns', $data);

    }

    public function fetchwithdraws($mobileno,$page)
    {
        $this->auth();

        if($mobileno>0){
            $timecondition="u.mobile_no LIKE '$mobileno%'";
        }else{
            $timecondition=[];
        }
        
        $offset = ($page - 1) * 8;
        $data['items'] = $this->db
        ->select('u.full_name,u.mobile_no,u.profile,w.*')
        ->from('withdraws as w')
        ->where($timecondition)
        ->join('users as u','w.user_id=u.id','LEFT')
        ->order_by('w.created_at', 'desc')
        ->limit(8,$offset)
        ->get()->result();
        
        $data['fn']=$this;
        $this->load->view('admin/auth/f_withdraws', $data);
    }

    public function fetchkycusers($mobileno,$page)
    {
        $this->auth();

        if($mobileno>0){
            $timecondition="u.mobile_no LIKE '$mobileno%'";
        }else{
            $timecondition=[];
        }
        
        $offset = ($page - 1) * 8;
        $data['items'] = $this->db
        ->select('u.full_name,u.mobile_no,u.profile,k.*')
        ->from('kyc as k')
        ->where($timecondition)
        ->join('users as u','k.user_id=u.id','LEFT')
        ->order_by('k.created_at', 'desc')
        ->limit(8,$offset)
        ->get()->result();
        
        $data['fn']=$this;
        $this->load->view('admin/auth/f_kyc', $data);
    }

    public function fetchusers($mobileno,$page)
    {
        $this->auth();

        if($mobileno>0){
            $timecondition="mobile_no LIKE '$mobileno%'";
        }else{
            $timecondition=[];
        }
        
        $offset = ($page - 1) * 8;
        $data['items'] = $this->db->where($timecondition)->order_by('id', 'desc')->limit(8,$offset)->get('users')->result();
        $data['fn']=$this;
        $this->load->view('admin/auth/f_users', $data);
    }

    public function fetchnotifications($page)
    {
        $this->auth();

      
        $offset = ($page - 1) * 8;
        $data['items'] = $this->db->order_by('id', 'desc')->limit(8,$offset)->get('notifications')->result();
        $data['fn']=$this;
        $this->load->view('admin/auth/f_notification', $data);
    }

    public function fetchadminlogs($start,$end,$page)
    {
        $this->auth();

        $timecondition="created_at BETWEEN  ".$start." AND ".$end;
        $offset = ($page - 1) * 8;
        $data['items'] = $this->db->where($timecondition)->order_by('id', 'desc')->limit(8,$offset)->get('admin_logs')->result();
        $data['fn']=$this;
        $this->load->view('admin/auth/f_logs', $data);
    }

    public function newdeposits($start,$end,$page)
    {
        $this->auth();

        $timecondition="created_at BETWEEN  ".$start." AND ".$end;
        $offset = ($page - 1) * 8;
        $data['deposits'] = $this->db->where($timecondition)->where(["status"=>2,"tag"=>'DEPOSIT'])->order_by('id', 'desc')->limit(8,$offset)->get('txns')->result();
        $data['fn']=$this;
        $this->load->view('admin/auth/newdeposits', $data);
    }

    public function changeuserstatus($id,$status){
        $this->auth();
        $uid = $this->secure('decrypt',$id);
        $this->db->where('id',$uid)->update('users',["status"=>$status]);
        $user=$this->db->where('id',$uid)->get('users')->row();
        
        $_SESSION['done-msg']='User '.($status==1?'Unbanned':'Banned').' Successfully !';

        $this->log($this->admin->email_id.' '.($status==1?'Unbanned':'Banned').' '.$user->full_name.' ('.$user->mobile_no.')');
        redirect(base_url('admin/openuser/'.$id));
    }

    public function getstat($user){
        $this->auth();
        
        $users=$this->db->where('refer_by',$user->referral_code)->get('users')->num_rows();

        $earnings = $this->db->select('SUM(amount) as amount')->where('type','CREDIT')->where('tag','REFERRAL_BONUS')->where('user_id',$user->id)->get('txns')->row()->amount;
        $stat = new stdClass();

        $earnings = $this->db->select('SUM(amount) as amount')->where('type','CREDIT')->where('tag','REFERRAL_BONUS')->where('user_id',$user->id)->get('txns')->row()->amount;

        $stat->referedUsers = $users;
        $stat->referralBonus = $this->amount($earnings);



       $earnings = $this->db->select('SUM(amount) as amount')->where('type','CREDIT')->where('tag','WIN_REWARD')->where('user_id',$user->id)->get('txns')->row()->amount;
       $stat->winRewards = $this->amount($earnings);

       $earnings = $this->db->select('SUM(amount) as amount')->where('type','DEBIT')->where('tag','PENALTY')->where('user_id',$user->id)->get('txns')->row()->amount;
       $stat->penalties = $this->amount($earnings);

       $earnings = $this->db->where('status',4)->where('(host_id='.$user->id.' OR joiner_id='.$user->id.')')->get('matches')->num_rows();
       $stat->playedMatches = $earnings;

       $earnings = $this->db->where('status',4)->where('winner_id',$user->id)->where('(host_id='.$user->id.' OR joiner_id='.$user->id.')')->get('matches')->num_rows();
       $stat->wonMatches = $earnings;
$this->fix();
        return $stat;
    }
     



    public function login(){
        $this->nonauth();
        $data['title']='Admin Panel Login | '.COMPANY_NAME;
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/public/login',$data);
        $this->load->view('admin/common/footer',$data);


    }


    public function index(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Dashboard';
        $data['admin']=$this->admin;


        $req=$this->input->post();
        
        if($req){
            $time=$req;
            $data['customdate']=$this->time($time);
        }else{
            $time=1;
        }



        $timecondition="created_at BETWEEN  ".$this->time($time)->start." AND ".$this->time($time)->end;
        $data['newusers']=$this->db->where($timecondition)->get('users')->result();
        $data['deposits']=$this->db->where($timecondition)->where(["status"=>2,"tag"=>'DEPOSIT'])->get('txns')->result();

        $data['depositmoney']=$this->db->select("SUM(amount) as amount")->where($timecondition)->where(["status"=>2,"tag"=>'DEPOSIT'])->get('txns')->row()->amount;

        $data['matches']=$this->db->where($timecondition)->where("status",4)->get('matches')->num_rows();

        //earning from withdraw charges
        $data['admin_earnings']=$this->db->select("SUM(transfer_fee) as amount")->where($timecondition)->where(["status"=>2])->get('withdraws')->row()->amount;

        //earning from matches reward commision
        $matchdata=$this->db->select("SUM(amount) as bet,SUM(prize) as prize")->where($timecondition)->where(["status"=>4])->get('matches')->row();
        $data['admin_earnings']+=($matchdata->bet*2)-$matchdata->prize;

        //earning from matches penalty
        $data['admin_earnings']+=$this->db->select("SUM(amount) as amount")->where($timecondition)->where(["status"=>2,'tag'=>"PENALTY"])->get('txns')->row()->amount;

        //earning loss from referral bonus
        $data['admin_earnings']-=$this->db->select("SUM(amount) as amount")->where($timecondition)->where(["status"=>2,'tag'=>"REFERRAL_BONUS"])->get('txns')->row()->amount;

        $data['withdraws']=$this->db->select("SUM(transfer_amount) as amount")->where($timecondition)->where(["status"=>2])->get('withdraws')->row()->amount;
        $data['withdrawsc']=$this->db->select("count(transfer_amount) as amount")->where($timecondition)->where(["status"=>2])->get('withdraws')->row()->amount;
        $data['uc']=$this->db->select("count(id) as amount")->get('users')->row()->amount;


        $data['balance']=$this->db->select("SUM(transfer_amount) as amount")->where(["status"=>2])->get('withdraws')->row()->amount;


        $data['i_load_url']=base_url('admin/newusers/'.$this->time($time)->start.'/'.$this->time($time)->end);
        $data['i_load_url2']=base_url('admin/newdeposits/'.$this->time($time)->start.'/'.$this->time($time)->end);

        $data['time']=$time;

        $data['fn']=$this;

        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);

        if($this->admin->id==1){
            $this->load->view('admin/auth/date',$data);
        }
      

        $this->load->view('admin/auth/dashboard',$data);
        

        $this->load->view('admin/common/footer',$data);


    }

    public function logs(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Admin Logs';
        $data['admin']=$this->admin;

        if($this->admin->id>1){
            redirect(base_url('admin'));
        }

        $req=$this->input->post();
        if($req){
            $time=$req;
            $data['customdate']=$this->time($time);
        }else{
            $time=1;
        }

      
        $data['i_load_url']=base_url('admin/fetchadminlogs/'.$this->time($time)->start.'/'.$this->time($time)->end);
      

        $data['time']=$time;
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);
        $this->load->view('admin/auth/date',$data);
        $this->load->view('admin/auth/logs',$data);
        

        $this->load->view('admin/common/footer',$data);


    }



    public function pendingresult(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Pending Results';
        $data['admin']=$this->admin;
     


        $req=$this->input->post();
       
        $keyword=0;
       if($req){
         $keyword=$req['mobileno'];
       }
         $data['i_load_url']=base_url("admin/fetchpendingmatchlist/$keyword");
       
 
        if($keyword){
         $data['keyword']=$keyword;
        }

      
       

        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);
      
        $this->load->view('admin/auth/pendingmatchhistory',$data);
        

        $this->load->view('admin/common/footer',$data);


    }


    public function matchhistory(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Match History';
        $data['admin']=$this->admin;
     


        $req=$this->input->post();
       
        $keyword=0;
       if($req){
         $keyword=$req['mobileno'];
       }
         $data['i_load_url']=base_url("admin/fetchmatchlist/$keyword");
       
 
        if($keyword){
         $data['keyword']=$keyword;
        }

      
       

        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);
      
        $this->load->view('admin/auth/matchhistory',$data);
        

        $this->load->view('admin/common/footer',$data);


    }

    public function cancelrequest(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Cancel Requests';
        $data['admin']=$this->admin;
     


        $req=$this->input->post();
       
        $keyword=0;
       if($req){
         $keyword=$req['mobileno'];
       }

         $data['i_load_url']=base_url("admin/fetchcancels/$keyword");
       
 
        if($keyword){
         $data['keyword']=$keyword;
        }

      
       

        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);
      
        $this->load->view('admin/auth/cancels',$data);
        

        $this->load->view('admin/common/footer',$data);


    }


    public function manageconflicts(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Manage Conflicts';
        $data['admin']=$this->admin;
     


        $req=$this->input->post();
       
        $keyword=0;
       if($req){
         $keyword=$req['mobileno'];
       }

         $data['i_load_url']=base_url("admin/fetchconflicts/$keyword");
       
 
        if($keyword){
         $data['keyword']=$keyword;
        }

      
       

        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);
      
        $this->load->view('admin/auth/conflicts',$data);
        

        $this->load->view('admin/common/footer',$data);


    }

    public function stat(){
        $this->auth();
        $response = new stdClass();

        $response->onlineusers = $this->db->where('online',1)->get('users')->num_rows();
        $response->withdraws = $this->db->where('status',1)->get('withdraws')->num_rows();
        $response->conflicts = $this->db->where('status',1)->get('conflicts')->num_rows();
        $response->cancels = $this->db->where('status',1)->get('cancel_reqs')->num_rows();

        $response->kycs = $this->db->where('status',1)->get('kyc')->num_rows();
        $response->activematches = $this->db->where('status <',3)->get('matches')->num_rows();

        echo json_encode($response);





    }
    public function openmatch($id){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Match Info';
        $data['admin']=$this->admin;

        $matchid = $this->secure('decrypt',$id);
        $data['match']=$match=$this->db->where('id',$matchid)->get('matches')->row();
        if(!$match) redriect(base_url('admin'));

        $data['cancels']=$this->db->where('match_id',$matchid)->get('cancel_reqs')->result();
        $data['conflicts']=$this->db->where('match_id',$matchid)->get('conflicts')->result();
        $data['txns']=$this->db->where('match_id',$matchid)->get('txns')->result();
        $data['host']=$this->db->where('id',$match->host_id)->get('users')->row();
        $data['joiner']=$this->db->where('id',$match->joiner_id)->get('users')->row();
        $data['game']=$this->db->where('id',$match->game_id)->get('game')->row();

        $data['fn']=$this;





        
       
      

      
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);
        $this->load->view('admin/auth/openmatch',$data);
        $this->load->view('admin/common/footer',$data);


    }

    public function manageusers(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Manage Users';
        $data['admin']=$this->admin;
        $req=$this->input->post();
       
       $keyword=0;
      if($req){
        $keyword=$req['mobileno'];
      }
        $data['i_load_url']=base_url("admin/fetchusers/$keyword");
      

       if($keyword>0){
        $data['keyword']=$keyword;
       }
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);

        $this->load->view('admin/auth/manageusers',$data);
        

        $this->load->view('admin/common/footer',$data);


    }

    public function withdraws(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='User Withdraws';
        $data['admin']=$this->admin;
        $req=$this->input->post();
       
       $keyword=0;
      if($req){
        $keyword=$req['mobileno'];
      }
        $data['i_load_url']=base_url("admin/fetchwithdraws/$keyword");
      

       if($keyword>0){
        $data['keyword']=$keyword;
       }
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);

        $this->load->view('admin/auth/managewithdraws',$data);
        

        $this->load->view('admin/common/footer',$data);


    }

    public function managekyc(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='User KYC';
        $data['admin']=$this->admin;
        $req=$this->input->post();
       
       $keyword=0;
      if($req){
        $keyword=$req['mobileno'];
      }
        $data['i_load_url']=base_url("admin/fetchkycusers/$keyword");
      

       if($keyword>0){
        $data['keyword']=$keyword;
       }
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);

        $this->load->view('admin/auth/managekyc',$data);
        

        $this->load->view('admin/common/footer',$data);


    }


    public function managenotifications(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Manage Notifications';
        $data['admin']=$this->admin;
        if($this->admin->id>1){
            redirect(base_url('admin'));
        }
        $data['i_load_url']=base_url("admin/fetchnotifications");
      

      
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);

        $this->load->view('admin/auth/managenotification',$data);
        

        $this->load->view('admin/common/footer',$data);


    }


    public function manageadmins(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Manage Admins';
        $data['admin']=$this->admin;
        
        if($this->admin->id>1){
            redirect(base_url('admin'));
        }
 
        $data['admins']=$this->db->where('id >',1)->get('admins')->result();
        $data['fn']=$this;

      
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);

        $this->load->view('admin/auth/manageadmins',$data);
        

        $this->load->view('admin/common/footer',$data);


    }

    public function config(){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Configuration';
        $data['admin']=$this->admin;
        
        if($this->admin->id>1){
            redirect(base_url('admin'));
        }
 
        $data['admins']=$this->db->where('id >',1)->get('admins')->result();
        $data['fn']=$this;
        $data['config']=$this->db->get('config')->row();
     
      
        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);

        $this->load->view('admin/auth/config',$data);
        

        $this->load->view('admin/common/footer',$data);


    }


    

    public function openuser($id=0){
        $this->auth();
        $data['title']='Admin Panel | '.COMPANY_NAME;
        $data['bartitle']='Manage Users';
        $data['admin']=$this->admin;

        $userid = $this->secure('decrypt',$id);
        $user=$this->db->where('id',$userid)->get('users')->row();
        if(!$user) redirect(base_url('admin/manageusers'));

        $data['user']=$user;
        $data['fn']=$this;

        $req=$this->input->get();
        if($req){
          $data['menu']=$req['menu'];
        }else{
            $data['menu']='Dashboard';
        }



        $this->load->view('admin/common/header',$data);
        $this->load->view('admin/auth/sidebar',$data);
        $this->load->view('admin/auth/topbar',$data);
        $this->load->view('admin/auth/openuser',$data);
        $this->load->view('admin/common/footer',$data);


    }


}


