<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    protected $user;

    public function onlyforauth()
    {
        
        if (isset($_SESSION['UserAuth'])) {
            $authId = $this->secure('decrypt', $_SESSION['UserAuth']);
            $user = $this->db->where('id', $authId)->get('users')->row();
            if($user->status==0){
                $_SESSION['info-msg'] = 'your account is banned by admin, please contact support for more information';
                redirect(base_url('user/logout'));
            }
            
            if ($user) {
                $this->user = $user;
                if($this->deviceFingerprint()!=$user->device_id){
                    $_SESSION['info-msg'] = 'you cannot log in in multiple devices';
                    redirect(base_url('user/logout'));
                }
                // $this->user->balance = $this->getWalletBalance();
            } else {
                setcookie('_access_token', null, time() - (86400 * 30), "/");
                redirect(base_url('user/logout'));
            }
        } else {
            // $_SESSION['info-msg'] = 'please login to your account';
            redirect(base_url('login'));
        }
    }

  public function username()
    {
        $string = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string = str_shuffle($string);
        $loop = true;
        $unique_referral_code = null;

        while ($loop) {
            $string = str_shuffle($string);
            $referral_code = str_split($string, 8)[0];
            $user = $this->db->where('username', $referral_code)->get('users')->row();
            if (!$user) {
                $unique_referral_code = $referral_code;
                $loop = false;
            }
        }



        return $unique_referral_code;
    }
    
    public function forall()
    {
        if (isset($_SESSION['UserAuth'])) {
            $authId = $this->secure('decrypt', $_SESSION['UserAuth']);
            $user = $this->db->where('id', $authId)->get('users')->row();
            if ($user) {
                $this->user = $user;
            }
        }
    }

    public function online(){
        $this->onlyforauth();
        $this->db->where('id',$this->user->id)->update('users',["online"=>1,"online_date"=>time()]);
    }

    public function offline(){
       
        $this->db->update('users',["online"=>0]);
    }
    public function logout()
    {
       
        unset($_SESSION['UserAuth']);
        setcookie('_access_token', null, time() - (86400 * 30), "/");
        redirect(base_url('login'));

    }

    public function updateprofile($avatar = 0)
    {
        $this->onlyforauth();
        if ($avatar < 1 || $avatar > 20) {
            $_SESSION['error-msg'] = 'invalid avatar, please try again';
        } else {
            $this->db->where('id', $this->user->id)->update('users', ['profile' => $avatar]);
            $_SESSION['done-msg'] = 'avatar updated !';
        }
        redirect(base_url('user/account'));
    }

    public function updatename()
    {
        $this->onlyforauth();
        $req = $this->input->post();
        if(!$req) redirect(base_url());

        if (!isset($req['full_name']) || $this->checkIfValueIsNotEmpty($req['full_name'] ?? '')) {
            $response['status'] = false;
            $response['msg'] = 'please enter valid name';
        } else {
            $this->db->where('id', $this->user->id)->update('users', ['full_name' => $req['full_name']]);
            $response['status'] = true;
            $response['msg'] = 'name updated !';
        }



        echo json_encode($response);
    }

    public function updatebank()
    {
        $this->onlyforauth();
        $req = $this->input->post();
if(!$req) redirect(base_url());
       
        $bank = $this->db->where('user_id',$this->user->id)->get('bank_details')->row();
        $req['updated_at']=time();
        $req['user_id']=$this->user->id;


        

        
        if (!isset($req['name']) || $this->checkIfValueIsNotEmpty($req['name'])) {
            $response['status'] = false;
            $response['msg'] = 'please enter valid name';
        } elseif (!isset($req['account_no']) || $this->checkIfValueIsNotEmpty($req['account_no'])) {
            $response['status'] = false;
            $response['msg'] = 'please enter a valid account no';
        } if (!isset($req['bank']) || $this->checkIfValueIsNotEmpty($req['bank'])) {
            $response['status'] = false;
            $response['msg'] = 'please select your bank';
        } if (!isset($req['ifsc_code']) || $this->checkIfValueIsNotEmpty($req['ifsc_code'])) {
            $response['status'] = false;
            $response['msg'] = 'please enter valid ifsc code';
        }else {
            if(!$bank){
                $this->db->insert('bank_details',$req);
            }else{
                $this->db->where('id',$bank->id)->update('bank_details',$req);
            }

            $response['status'] = true;
            $response['msg'] = 'bank details updated !';
        }

        



        echo json_encode($response);
    }
    
     public function updateupi()
    {
        $this->onlyforauth();
        $req = $this->input->post();
if(!$req) redirect(base_url());
       
        $bank = $this->db->where('user_id',$this->user->id)->get('bank_details')->row();
        $req['updated_at']=time();
        $req['user_id']=$this->user->id;


        

        
        if (!isset($req['upi']) || $this->checkIfValueIsNotEmpty($req['upi'])) {
            $response['status'] = false;
            $response['msg'] = 'please enter valid upi id';
        }else {
            if(!$bank){
                $this->db->insert('bank_details',$req);
            }else{
                $this->db->where('id',$bank->id)->update('bank_details',$req);
            }

            $response['status'] = true;
            $response['msg'] = 'bank details updated !';
        }

        



        echo json_encode($response);
    }

    protected function checkIfUsernameExists($username)
    {
        if ($this->db->where('username', $username)->get('users')->row()) return true;
        return false;
    }

    public function getWalletBalance()
    {
        $this->onlyforauth();
        $credit = $this->db->select('SUM(amount) as amount')->where('status', 2)->where('type', 'CREDIT')->where('user_id', $this->user->id)->get('txns')->row()->amount;
        $debit = $this->db->select('SUM(amount) as amount')->where('status', 2)->where('type', 'DEBIT')->where('user_id', $this->user->id)->get('txns')->row()->amount;
        $withdraw = $this->db->select('SUM(total_amount) as amount')->where('status', 1)->where('user_id', $this->user->id)->get('withdraws')->row()->amount;

        $balance = ($credit - $debit-$withdraw);
        return $this->amount($balance);
    }

    public function getWalletBalanceById($userid)
    {
        $this->onlyforauth();
        $credit = $this->db->select('SUM(amount) as amount')->where('status', 2)->where('type', 'CREDIT')->where('user_id', $userid)->get('txns')->row()->amount;
        $debit = $this->db->select('SUM(amount) as amount')->where('status', 2)->where('type', 'DEBIT')->where('user_id', $userid)->get('txns')->row()->amount;
        $withdraw = $this->db->select('SUM(total_amount) as amount')->where('status', 1)->where('user_id', $userid)->get('withdraws')->row()->amount;

        $balance = ($credit - $debit-$withdraw);
        return $this->amount($balance);
    }

    public function fetchBalance()
    {
        echo $this->getWalletBalance();
    }


    public function txnid()
    {
        
       
        $lat=$this->db->order_by('id', 'desc')->get('txns')->row();
        if($lat) $last_txn_id=$lat->txnid;
        else $last_txn_id = TXN_UID.'txn14271427142';
        
        $last_txn_id = str_replace(TXN_UID.'txn', '', $last_txn_id);


        return TXN_UID.'txn' . $last_txn_id + 1;
    }

    // public function _txnid()
    // {
    //     $this->onlyforauth();

    //     $lat = $this->db->where('user_id',$this->user->id)->order_by('id', 'desc')->get('txns')->row();
    //     if($lat) $last_txn_id=$lat->txnid;
    //     else $last_txn_id = 'txn'.$this->user->id.rand(11,99).'14271427';

    //     $last_txn_id = str_replace('txn', '', $last_txn_id);


    //     return ('txn'.($last_txn_id + 1)+rand(1,999));
    // }


    public function addwithdraw(){
        $this->onlyforauth();
        $req=$this->input->post();
        if(!$req) redirect(base_url());

        if(isset($req['amount']) && $req['amount']>0 && ctype_digit($req['amount'])){
            $bank=$this->db->where('user_id',$this->user->id)->get('bank_details')->row();
            $kyc=$this->db->where('user_id',$this->user->id)->where('status',2)->get('kyc')->row();

            if($req['amount']<$this->db->get('config')->row()->min_withdraw){
                $response['status']=false;
                $response['msg']="you can withdraw minimum ₹".$this->db->get('config')->row()->min_withdraw;
            }elseif($req['amount']>$this->getWalletBalance()){
                $response['status']=false;
                $response['msg']="you don't have ₹".$req['amount']." on your wallet";
            }elseif(!$bank){
                $response['status']=false;
                $response['msg']="please update your payment method details";
            }elseif(!$kyc){
                $response['status']=false;
                $response['msg']="please complete your kyc before placing a withdraw request";
            }elseif($req['method']=='bank' && $bank->account_no==''){
                $response['status']=false;
                $response['msg']="please update your bank details to take withdraw in bank";
            }elseif($req['method']=='upi' && $bank->upi==''){
                $response['status']=false;
                $response['msg']="please update your upi details to take withdraw in upi";
            }else{
                
                $withdraw['method']=$req['method'];
                $withdraw['user_id']=$this->user->id;
                $withdraw['transfer_fee']=$req['amount']*($this->db->get('config')->row()->withdraw_charge/100);
                $withdraw['transfer_amount']=$req['amount']-$withdraw['transfer_fee'];
                $withdraw['total_amount']=$req['amount'];
                $withdraw['created_at']=time();
                $withdraw['updated_at']=time();
                $withdraw['status']=1;

if($req['method']=='bank'){
    $withdraw['name']=$bank->name;
    $withdraw['bank']=$bank->bank;
    $withdraw['ifsc_code']=$bank->ifsc_code;
    $withdraw['account_no']=$bank->account_no;
}else{
    $withdraw['upi']=$bank->upi;
}
               




                $txn['user_id']=$this->user->id;
                $txn['txnid']=$this->txnid();
                $txn['amount']=$req['amount'];
                $txn['created_at']=time();
                $txn['updated_at']=time();
                $txn['type']='DEBIT';
                $txn['tag']='WITHDRAW';
                $txn['status']=1;
                $txn['remarks']='Withdraw of ₹'.$withdraw['transfer_amount'].' (fee:₹'.$withdraw['transfer_fee'].')';

                $withdraw['txnid']=$txn['txnid'];

                $this->db->insert('txns',$txn);
                $this->db->insert('withdraws',$withdraw);

                $response['gotourl']=base_url('user/withdraws');
                $response['status']=true;
                $_SESSION['done-msg']='Withdraw request placed successfully';


            }

            
        
        }else{
            $response['status']=false;
            $response['msg']='enter a valid amount';
        }

        echo json_encode($response);

    }

    public function cancelmatch($game)
    {
        $this->onlyforauth();
        $gameid = $this->secure('decrypt', $game);
        $match = $this->db->where('id', $gameid)->where('status', 1)->where('joiner_id', 0)->where('host_id', $this->user->id)->get('matches')->row();


        if (!$match) {
            $response['status'] = false;
            $response['msg'] = 'invalid match selection, please refresh the page and try again';
        } else {
            $matcho['status'] = 3;
            $this->db->where('id', $match->id)->update('matches', $matcho);

            $this->credit($match->amount, 'MATCH_REFUND',  'match cancelled', $match->id);
            $response['status'] = true;
            $response['msg'] = 'match cancelled and ₹' . $match->amount . ' refunded to your wallet';
        }

        if ($response['status']) {
            $_SESSION['done-msg'] = $response['msg'];
            $this->clearReq($match->id);
        } else {
            $_SESSION['info-msg'] = $response['msg'];
        }
        redirect(base_url('user/creatematch/' . $this->secure('encrypt', $match->game_id)));
    }

    function deviceFingerprint()
    {
        return $_COOKIE['_di']??'';
    }


    public function test(){
echo $this->createDeviceFingerprint();
    }


    public function checkstatus($txnid){
       
        require_once("./application/libraries/encdec_paytm.php");

        $checkSum = "";   

        $paramList = array();
        $paramList["MID"] = $this->db->get('config')->row()->pb_mid; //Provided by Paytm
        $paramList["ORDER_ID"] = $txnid; //unique OrderId for every request

        $checkSum = getChecksumFromArray($paramList,"YOUR KEY");
        $paramList["CHECKSUMHASH"] = urlencode($checkSum);

        $data_string = 'JsonData='.json_encode($paramList);



        $ch = curl_init();                    // initiate curl
        $url = "https://securegw.paytm.in/order/status"; // 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec ($ch); // execute
        $info = curl_getinfo($ch);



        $txninfo=json_decode($output); 



if($txninfo->STATUS=='TXN_SUCCESS'){


$txnup['amount']=$txninfo->TXNAMOUNT;
$txnup['updated_at']=time();
$txnup['data']=json_encode($txninfo);
$txnup['status']=2;
}else{
    $txnup['updated_at']=time();
    $txnup['data']=json_encode($txninfo);
    $txnup['status']=0;
}

$this->db->where('txnid',$txnid)->update('txns',$txnup);


    }

    public function verifyupipayment(){
        $this->onlyforauth();
        $user = $this->user;
        $req = $this->input->post();
        if(!$req) redirect(base_url());

        if(!isset($_SESSION['d_txn_id'])){
            redirect(base_url());
            die();
        }

        $txn = $this->db->where('id',$_SESSION['d_txn_id'])->get('txns')->row();

        require_once("./application/libraries/encdec_paytm.php");

        $checkSum = "";   

        $paramList = array();
        $paramList["MID"] = $this->db->get('config')->row()->pb_mid; //Provided by Paytm
        $paramList["ORDER_ID"] = $txn->txnid; //unique OrderId for every request

        $checkSum = getChecksumFromArray($paramList,"YOUR KEY");
        $paramList["CHECKSUMHASH"] = urlencode($checkSum);

        $data_string = 'JsonData='.json_encode($paramList);



        $ch = curl_init();                    // initiate curl
        $url = "https://securegw.paytm.in/order/status"; // 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $output = curl_exec ($ch); // execute
        $info = curl_getinfo($ch);



        $txninfo=json_decode($output); 



if($txninfo->STATUS=='TXN_SUCCESS'){


$txnup['amount']=$txninfo->TXNAMOUNT;
$txnup['updated_at']=time();
$txnup['data']=json_encode($txninfo);
$txnup['status']=2;

$this->db->where('id',$txn->id)->update('txns',$txnup);

$_SESSION['done-msg'] = 'Money Added To Your Wallet';
$response['status']='success';
}else{
$response['status']='pending';
}

echo json_encode($response);


    }

    public function acceptreq($reqid)
    {
        $this->onlyforauth();
        $reqid = $this->secure('decrypt', $reqid);
        $req = $this->db->where('id',$reqid)->get('join_reqs')->row();
        if(!$req) base_url();
       
        $match = $this->db->where('id', $req->match_id)->where('status', 1)->where('joiner_id', 0)->where('host_id !=', $req->joiner_id)->get('matches')->row();
        $activematch = $this->db->where('(host_id=' . $req->joiner_id . ' OR joiner_id=' . $req->joiner_id . ')')->where('status <=', 2)->get('matches')->row();

        if (!$match) {
            $response['status'] = false;
            $response['msg'] = 'invalid match selection, please refresh the page and try again';
        } elseif ($match->amount > $this->getWalletBalanceById($req->joiner_id)) {
            $response['status'] = false;
            $response['msg'] = "player don't have ₹" . $match->amount . " in his wallet";
        } elseif ($activematch) {
            $response['status'] = false;
            $response['msg'] = 'player is already in a active match';
        } else {

            $matcho['joiner_id'] = $req->joiner_id;
            $matcho['status'] = 2;
            $matcho['joiner_time'] = time();

            $this->db->where('id', $match->id)->update('matches', $matcho);

            $this->db->where('match_id',$req->match_id)->delete('join_reqs');

            $this->debit($req->joiner_id,$match->amount, 'CREATE_MATCH',  'played a match', $match->id);
            $this->clearReq($match->id);
            $this->db->where('joiner_id',$req->joiner_id)->delete('join_reqs');

            $response['status'] = true;
            $response['msg'] = 'you joined a match';
        }

        if ($response['status']) {
            // $_SESSION['done-msg'] = $response['msg'];
        } else {
            $_SESSION['info-msg'] = $response['msg'];
        }
        redirect(base_url('user/creatematch/' . $this->secure('encrypt', $match->game_id)));
    }

    public function clearReq($matchid){
        $this->db->where('match_id',$matchid)->delete('join_reqs');
    }
    public function sendjoinreq($matchid)
    {
        $this->onlyforauth();
        $match_id = $this->secure('decrypt',$matchid);
        $match=$this->db->where('id',$match_id)->where('status',1)->where('joiner_id', 0)->where('host_id !=', $this->user->id)->get('matches')->row();
      

        $jreq=$this->db->where('joiner_id',$this->user->id)->where('match_id',$match->id)->get('join_reqs')->row();

        #################################
     
        
        
        $activematch = $this->db->where('(host_id=' . $this->user->id . ' OR joiner_id=' . $this->user->id . ')')->where('status <=', 2)->get('matches')->row();

        if (!$match) {
            $response['status'] = false;
            $response['msg'] = 'invalid match selection, please refresh the page and try again';
        } elseif ($match->amount > $this->getWalletBalance()) {
            $response['status'] = false;
            $response['msg'] = "you don't have ₹" . $match->amount . " in your wallet";
        } elseif ($activematch) {
            $response['status'] = false;
            $response['msg'] = 'you already have an active match !';
        } else {
 if($match->joiner_id!=0){
    $response['msg']  = 'host accepted another player request';
      
        }elseif($jreq){
            $response['msg'] = 'you can send only 1 join request for a single match';

        }else{
$jreq['match_id']=$match->id;
$jreq['joiner_id']=$this->user->id;
$jreq['created_at']=time();
$jreq['status']=1;
$this->db->insert('join_reqs',$jreq);



        }
           
        }
        ########################
    
        $_SESSION['info-msg'] =$response['msg'];

        redirect(base_url('user/creatematch/' . $this->secure('encrypt', $match->game_id)));
       

    }

    public function saveroomcode($matchid)
    {
        $this->onlyforauth();
        $req = $this->input->post();
        if(!$req) redirect(base_url());

        $matchid = $this->secure('decrypt', $matchid);
        
        $roomcode = $this->db->where('room_code', $req['room_code'])->where('status !=', 3)->get('matches')->row();
     

    if ((!isset($req['room_code']) || $this->checkIfValueIsNotEmpty($req['room_code'] ?? '') || strlen($req['room_code']) > 10) && false) {
            $response['status'] = false;
            $response['msg'] = 'please enter valid room code';
        } elseif ($roomcode && false) {
            $response['status'] = false;
            $response['msg'] = 'room code already used in another match !';
        }else {
           $this->db->where('id',$matchid)->update('matches',['room_code'=>$req['room_code']]);
        }

        if(isset($response['msg'])){
            $_SESSION['info-msg'] =$response['msg'];
        }
        redirect(base_url('user/openmatch/' . $this->secure('encrypt', $matchid)));
      
    }

    public function newmatch($game)
    {
        $this->onlyforauth();
        $req = $this->input->post();
        if(!$req) redirect(base_url());

        $gameid = $this->secure('decrypt', $game);
        $data['game'] = $game = $this->db->where('id', $gameid)->get('game')->row();
        $activematch = $this->db->where('(host_id=' . $this->user->id . ' OR joiner_id=' . $this->user->id . ')')->where('status <=', 2)->get('matches')->row();
        // $roomcode = $this->db->where('room_code', $req['room_code'])->where('status !=', 3)->get('matches')->row();
        $roomcode=0;

        if (!$game) {
            $response['status'] = false;
            $response['msg'] = 'invalid game selection, please refresh the page and try again';
        } elseif ((!isset($req['room_code']) || $this->checkIfValueIsNotEmpty($req['room_code'] ?? '') || strlen($req['room_code']) > 10) && false) {
            $response['status'] = false;
            $response['msg'] = 'please enter valid room code' . ($this->checkIfValueIsNotEmpty($req['room_code'] ?? ''));
        } elseif ($roomcode && false) {
            $response['status'] = false;
            $response['msg'] = 'room code already used in another match !';
        } elseif (!isset($req['amount']) || $this->checkIfValueIsNotEmpty($req['amount'] ?? '')) {
            $response['status'] = false;
            $response['msg'] = 'please enter valid amount';
        } elseif ($req['amount'] > $this->getWalletBalance()) {
            $response['status'] = false;
            $response['msg'] = "you don't have ₹" . $req['amount'] . " in your wallet";
        } elseif ($req['amount'] < $game->min_amount || $req['amount'] > $game->max_amount) {
            $response['status'] = false;
            $response['msg'] = 'please enter a amount between ₹' . $game->min_amount . ' and ₹' . $game->max_amount;
        } elseif ($activematch) {
            $response['status'] = false;
            $response['msg'] = 'you already have an active match !';
        } else {
            // $match['room_code'] = $req['room_code'];
            $match['host_id'] = $this->user->id;
            $match['created_at'] = time();
            $match['game_id'] = $gameid;
            $match['amount'] = $req['amount'];
            $match['status'] = 1;
            $match['prize']=$this->getPrize($match['amount']);
            $this->db->insert('matches', $match);
            $matchid = $this->db->insert_id();
            $this->debit($this->user->id,$req['amount'], 'CREATE_MATCH',  'created a match', $matchid);
            $response['status'] = true;
            $response['msg'] = false;
        }

        echo json_encode($response);
    }


    protected function debit($userid,$amount, $tag, $remark, $matchid = 0)
    {
        $this->onlyforauth();
        $txn['user_id'] = $userid;
        $txn['txnid'] = $this->txnid();
        $txn['tag'] = $tag;
        $txn['remarks'] = $remark;
        $txn['amount'] = $amount;
        $txn['created_at'] = time();
        $txn['updated_at'] = time();
        $txn['type'] = 'DEBIT';
        $txn['status'] = 2;
        $txn['match_id'] = $matchid;
        $this->db->insert('txns', $txn);
    }

    protected function credit($amount, $tag, $remark, $matchid = 0)
    {
        $this->onlyforauth();
        $txn['user_id'] = $this->user->id;
        $txn['txnid'] = $this->txnid();
        $txn['tag'] = $tag;
        $txn['remarks'] = $remark;
        $txn['amount'] = $amount;
        $txn['created_at'] = time();
        $txn['updated_at'] = time();
        $txn['type'] = 'CREDIT';
        $txn['status'] = 2;
        $txn['match_id'] = $matchid;
        $this->db->insert('txns', $txn);
    }

    public function updateusername()
    {
        $this->onlyforauth();
        $req = $this->input->post();
        if(!$req) redirect(base_url());
        $req['username'] = preg_replace("/[^A-Za-z0-9]/", '', $req['username']);
        if (!isset($req['username']) || $this->checkIfValueIsNotEmpty($req['username'] ?? '')) {
            $response['status'] = false;
            $response['msg'] = 'please enter valid username';
        } elseif ($this->checkIfUsernameExists($req['username'])) {
            $response['status'] = false;
            $response['msg'] = '"' . $req['username'] . '" username alread in use';
        } elseif (strlen($req['username']) > 10) {
            $response['status'] = false;
            $response['msg'] = 'enter a username of 10 or less letters';
        } else {

            $this->db->where('id', $this->user->id)->update('users', ['username' => $req['username']]);
            $response['status'] = true;
            $response['msg'] = 'username updated !';
        }



        echo json_encode($response);
    }

    public function submitcancellation($matchid){
        $this->onlyforauth();
        $req = $this->input->post();
        if(!$req) redirect(base_url());
        
        $emid = $matchid;
        $matchid = $this->secure('decrypt',$matchid);

        $match = $this->db->where('(host_id='.$this->user->id.' OR joiner_id='.$this->user->id.')')->where('id', $matchid)->get('matches')->row();
         
        if (!$match) {
            $_SESSION['error-msg'] = 'invalid game selection, please select from the above games';
            redirect(base_url('user/home'));
        }

        $cr = $this->db->where('match_id',$match->id)->where('status',1)->where('user_id',$this->user->id)->get('cancel_reqs')->row();

        if($cr){
            $_SESSION['error-msg'] = 'you already have a pending cancellation request';
            redirect(base_url('user/openmatch/'.$emid));
            die();
        }

        $creq['user_id']=$this->user->id;
        $creq['match_id']=$match->id;
        $creq['reason']=$req['reason'];
        $creq['created_at']=$creq['updated_at']=time();
        $creq['status']=1;
        $this->db->insert('cancel_reqs',$creq);
        $newcid = $this->db->insert_id();

        if($this->user->id==$match->joiner_id){
            $otherid=$match->host_id;
        }else{
            $otherid=$match->joiner_id;
        }
        $_SESSION['info-msg']='cancellation request submitted';

        $othercancel = $this->db->where('match_id',$match->id)->where('status',1)->where('user_id',$otherid)->get('cancel_reqs')->row();

        if($othercancel){
            $this->db->where('id',$match->id)->update('matches',[
                'status'=>3
            ]);

            $this->db->where('id',$newcid)->update('cancel_reqs',[
                'status'=>2,
                'remarks'=>'canceled because both players agree to cancel match'
            ]);

            $this->db->where('id',$othercancel->id)->update('cancel_reqs',[
                'status'=>2,
                'remarks'=>'canceled because both players agree to cancel match'
            ]);

          

            $txn['user_id']=$match->joiner_id;
            $txn['txnid']=$this->txnid();
            $txn['amount']=$match->amount;
            $txn['created_at']=time();
            $txn['updated_at']=time();
            $txn['type']='CREDIT';
            $txn['tag']='CREATE_MATCH';
            $txn['status']=2;
            $txn['remarks']='Match Cancelled';
            $txn['match_id']=$match->id;

            $this->db->insert('txns',$txn);

            $txn['user_id']=$match->host_id;
            $txn['txnid']=$this->txnid();

            $this->db->insert('txns',$txn);



            $_SESSION['info-msg']='match cancelled & money is refunded on your wallet';





        }



        redirect(base_url('user/openmatch/'.$emid));
     





    }


    public function getmatchinfo($matchid){
        $this->onlyforauth();
        $matchid = $this->secure('decrypt',$matchid);

         $match = $this->db->where('(host_id='.$this->user->id.' OR joiner_id='.$this->user->id.')')->where('id', $matchid)->get('matches')->row();
         $cr = $this->db->where('match_id',$match->id)->where('status',1)->where('user_id',$this->user->id)->get('cancel_reqs')->row();
        if($this->user->id==$match->joiner_id){
            $otherid=$match->host_id;
        }else{
            $otherid=$match->joiner_id;
        }
        $othercancel = $this->db->where('match_id',$match->id)->where('status',1)->where('user_id',$otherid)->get('cancel_reqs')->row();
        $conflict = $this->db->where('match_id',$match->id)->where('status',1)->get('conflicts')->row();

        $response=array(
            $match->room_code,$match->status,$match->winner_id,$match->looser_id,$match->host_result,$match->joiner_result,@$cr->status,@$othercancel->status,@$conflict->status
        );

        echo json_encode($response);


    
    }



    protected function checkIfValueIsNotEmpty($value)
    {
        $value = str_replace(' ', '', $value);
        $value = preg_replace('/\s+/', '', $value);
        if (preg_match('/[a-zA-Z0-9]/i', $value)) return false;


        return true;
    }

    protected function checkIfAadharNoIsValid($number)
    {
        if (!ctype_digit($number)) return false;
        if (strlen($number) != 12) return false;
        return true;
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

    public function canceldeposit()
    {
      $this->onlyforauth();
      if(isset($_SESSION['d_txn_id'])){
      $txn = $this->db->where('user_id',$this->user->id)->where('status',1)->where('id',$_SESSION['d_txn_id'])->get('txns')->row();
      if($txn){
    
       $txnup['updated_at']=time();
       $txnup['status']=3;

$this->db->where('id',$txn->id)->update('txns',$txnup);
      }
      }

      $_SESSION['info-msg']='Payment Canceled !';
      redirect(base_url('user/wallet'));

    }


    public function submitresult($matchid)
    {
        $this->onlyforauth();
        $req = $this->input->post();

        if(!$req) redirect(base_url());
        $emid = $matchid;
        $matchid = $this->secure('decrypt',$matchid);

        
        $match = $this->db->where('(host_id='.$this->user->id.' OR joiner_id='.$this->user->id.')')->where('status',2)->where('id', $matchid)->get('matches')->row();
         
        
        if (!$match) {
            $_SESSION['error-msg'] = 'invalid game selection, please select from the above games';
            redirect(base_url('user/home'));
        }

        $dir = './assets/images/screenshots/match_' . $match->id . '/';

      
        if(isset($req['result']) && $req['result']=='winner'){
        $screenshot = $this->do_upload('screenshot', $dir);
       
        if (isset($screenshot['upload_data'])) {
            

            if($match->screenshot==''){
               
              
                $winner['screenshot']=$screenshot['upload_data']['file_name'];
                if($match->host_id==$this->user->id){
                    $winner['host_result']=1;
                    $winner['host_result_time']=time();
                }elseif($match->joiner_id==$this->user->id){
                    $winner['joiner_result']=1;
                    $winner['joiner_result_time']=time();

                }

                $winner['screenshot']=$screenshot['upload_data']['file_name'];

                $this->db->where('id',$matchid)->update('matches',$winner);
                

            }else{
               

                if($match->host_id==$this->user->id){
                    $winner['host_result']=1;
                    $winner['host_result_time']=time();
                }elseif($match->joiner_id==$this->user->id){
                    $winner['joiner_result']=1;
                    $winner['joiner_result_time']=time();

                }

                $winner['conflict_screenshot']=$screenshot['upload_data']['file_name'];

                $this->db->where('id',$matchid)->update('matches',$winner);

                $conflict['match_id']=$match->id;
                $conflict['conflicted_user']=$this->user->id;
                $conflict['created_at']=time();
                $conflict['updated_at']=time();
                $conflict['status']=1;

                $this->db->insert('conflicts',$conflict);

                $_SESSION['info-msg'] = 'both players submitted same result conflict created , match will be reviewed by admin';
                redirect(base_url('user/openmatch/'.$emid));
            }

            
                
            } else {
                $_SESSION['error-msg'] = 'please upload a valid screenshot , size should be 2mb or less';
                redirect(base_url('user/openmatch/'.$emid));
            }


        }elseif(isset($req['result']) && $req['result']=='looser'){

            
            if($match->host_id==$this->user->id){
                $looser['host_result']=2;
                $looser['host_result_time']=time();
            }elseif($match->joiner_id==$this->user->id){
                $looser['joiner_result']=2;
                $looser['joiner_result_time']=time();
            }

            $this->db->where('id',$matchid)->update('matches',$looser);




        }

        $match = $this->db->where('(host_id='.$this->user->id.' OR joiner_id='.$this->user->id.')')->where('status',2)->where('id', $matchid)->get('matches')->row();




        if(($match->host_result==2 && $match->joiner_result==1) || ($match->host_result==1 && $match->joiner_result==2)){ 
         
            if($match->host_result==1 && $match->joiner_result==2){
                $fin['winner_id']=$match->host_id;
                $fin['looser_id']=$match->joiner_id;

            }elseif($match->joiner_result==1 && $match->host_result==2){
                $fin['winner_id']=$match->joiner_id;
                $fin['looser_id']=$match->host_id;
            }

            $fin['status']=4;

            $this->db->where('id',$match->id)->update('matches',$fin);

            $reward['user_id']=$fin['winner_id'];
            $reward['txnid']=$this->txnid();
            $reward['amount']=$match->prize;
            $reward['created_at']=time();
            $reward['updated_at']=time();
            $reward['type']='CREDIT';
            $reward['tag']='WIN_REWARD';
            $reward['status']=2;
            $reward['remarks']='Match Winned !';
            $reward['match_id']=$match->id;

            $this->db->insert('txns',$reward);

            $winner = $this->db->where('id',$reward['user_id'])->get('users')->row();

            $refer = $this->db->where('referral_code',$winner->refer_by)->get('users')->row();

            if($refer){
                $reward['user_id']=$refer->id;
                $reward['txnid']=$this->txnid();
                $reward['amount']=$this->getRefBonus($match->amount);
                $reward['created_at']=time();
                $reward['updated_at']=time();
                $reward['type']='CREDIT';
                $reward['tag']='REFERRAL_BONUS';
                $reward['status']=2;
                $reward['data']=$winner->id;
                $reward['remarks']='Referral Bonus';
                $reward['match_id']=$match->id;
    
                $this->db->insert('txns',$reward);
            }







            redirect(base_url('user/matches'));




        }


        redirect(base_url('user/openmatch/'.$emid));


        
        

       

      
            
           
            
        
    }


    
    public function submitkyc()
    {
        $this->onlyforauth();
        $req = $this->input->post();
        if(!$req) redirect(base_url());
        $kyc = $this->db->where('user_id', $this->user->id)->get('kyc')->row();
        $approvedkyc = $this->db->where('status', 2)->where('user_id', $this->user->id)->get('kyc')->row();
        if ($approvedkyc) {
            $_SESSION['info-msg'] = 'your kyc is already approved and verified !';
            redirect(base_url('user/account'));
        }

        if (!$this->checkIfAadharNoIsValid($req['aadhar_no']) || !isset($req['aadhar_no']) || strlen($req['aadhar_no']) != 12) {
            $_SESSION['error-msg'] = 'please enter a valid 12 digit aadhar no';
            redirect(base_url('user/kyc'));
        } elseif ($this->db->where('aadhar_no', $req['aadhar_no'])->get('kyc')->row()) {
            $_SESSION['info-msg'] = '"' . $req['aadhar_no'] . '" is already used for kyc in another account';
            redirect(base_url('user/kyc'));
        } else {
            $dir = './assets/images/kyc/' . $this->user->mobile_no . '/';
            $aadhar_front = $this->do_upload('aadhar_front', $dir);
            $aadhar_back = $this->do_upload('aadhar_back', $dir);

            if (isset($aadhar_front['upload_data']) && isset($aadhar_back['upload_data'])) {

                $kyc_req['user_id'] = $this->user->id;
                $kyc_req['aadhar_no'] = $req['aadhar_no'];
                $kyc_req['aadhar_front'] = $aadhar_front['upload_data']['file_name'];
                $kyc_req['aadhar_back'] = $aadhar_back['upload_data']['file_name'];
                $kyc_req['created_at'] = time();
                $kyc_req['status'] = 1;
                $kyc_req['remarks'] = 'kyc submitted for approval';





                if ($kyc) {
                    $this->db->where('user_id', $this->user->id)->update('kyc', $kyc_req);
                } else {
                    $this->db->insert('kyc', $kyc_req);
                }

                $_SESSION['done-msg'] = 'KYC Submitted for approval !';
                redirect(base_url('user/account'));
            } else {

                $_SESSION['error-msg'] = 'please upload a valid image , size should be 2mb or less';
                redirect(base_url('user/kyc'));
            }
        }
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


    public function getPrize($amount, $matchid = 0)
    {
        $prize = $amount + ($amount * ($this->db->get('config')->row()->reward/100));
        if (fmod($prize, 1) == 0) {
            $prize = floor($prize);
        }

        return $prize;
    }

    public function getRefBonus($amount, $matchid = 0)
    {
        $prize = ($amount * ($this->db->get('config')->row()->referral_bonus/100));
        if (fmod($prize, 1) == 0) {
            $prize = floor($prize);
        }

        return $prize;
    }

    public function amount($amount)
    {

        if (fmod($amount, 1) == 0) {
            $amount = floor($amount);
        }

        return $amount;
    }

    

    public function getTag($type)
    {
        $tag = '';
        if ($type == 'deposits') {
            $tag = 'DEPOSIT';
        } elseif ($type == 'winnings') {
            $tag = 'WIN_REWARD';
        } elseif ($type == 'penalty') {
            $tag = 'PENALTY';
        } elseif ($type == 'referrals') {
            $tag = 'REFERRAL_BONUS';
        } elseif ($type == 'withdraws') {
            $tag = 'WITHDRAW';
        } elseif ($type == 'matches') {
            $tag = 'CREATE_MATCH';
        }
        return $tag;
    }

    public function loadtxns($type, $page)
    {
        $this->onlyforauth();
        $offset = ($page - 1) * 8;

        $where['user_id'] = $this->user->id;
        if ($this->getTag($type)) {
            $where['tag'] = $this->getTag($type);
        }

        $data['txns'] = $this->db->where($where)->order_by('id', 'desc')->limit(8, $offset)->get('txns')->result();
        $data['fn'] = $this;
        $this->load->view('user/auth/txns', $data);
    }

    public function loadwithdraws($page)
    {
        $this->onlyforauth();
        $offset = ($page - 1) * 8;

        $where['user_id'] = $this->user->id;
        

        $data['txns'] = $this->db->where($where)->order_by('id', 'desc')->limit(8, $offset)->get('withdraws')->result();
        $data['fn'] = $this;
        $this->load->view('user/auth/wds', $data);
    }

    public function mdata($page)
    {
        $this->onlyforauth();
        $data['user'] = $this->user;
        $offset = ($page - 1) * 8;

        $data['matches'] = $this->db->where('(host_id=' . $this->user->id . ' OR joiner_id=' . $this->user->id . ')')->where('(status=2 OR status=4)')->order_by('id', 'desc')->limit(8,$offset)->get('matches')->result();
    
        $data['fn'] = $this;
        $this->load->view('user/auth/mdata', $data);
    }


    public function ndata($page)
    {
        $this->onlyforauth();
        $data['user'] = $this->user;
        $offset = ($page - 1) * 8;

        $data['notifications'] = $this->db->where('(user=0 OR user='.$this->user->id.')')->limit(8,$offset)->order_by('id','desc')->get('notifications')->result();
    
        $data['fn'] = $this;
        $this->load->view('user/auth/ndata', $data);
    }

    public function getstat(){
        $this->onlyforauth();
        $users=$this->db->where('refer_by',$this->user->referral_code)->get('users')->num_rows();

        $earnings = $this->db->select('SUM(amount) as amount')->where('type','CREDIT')->where('tag','REFERRAL_BONUS')->where('user_id',$this->user->id)->get('txns')->row()->amount;
        $stat = new stdClass();

        $earnings = $this->db->select('SUM(amount) as amount')->where('type','CREDIT')->where('tag','REFERRAL_BONUS')->where('user_id',$this->user->id)->get('txns')->row()->amount;

        $stat->referedUsers = $users;
        $stat->referralBonus = $this->amount($earnings);



       $earnings = $this->db->select('SUM(amount) as amount')->where('type','CREDIT')->where('tag','WIN_REWARD')->where('user_id',$this->user->id)->get('txns')->row()->amount;
       $stat->winRewards = $this->amount($earnings);

       $earnings = $this->db->select('SUM(amount) as amount')->where('type','DEBIT')->where('tag','PENALTY')->where('user_id',$this->user->id)->get('txns')->row()->amount;
       $stat->penalties = $this->amount($earnings);

       $earnings = $this->db->where('status',4)->where('(host_id='.$this->user->id.' OR joiner_id='.$this->user->id.')')->get('matches')->num_rows();
       $stat->playedMatches = $earnings;

       $earnings = $this->db->where('status',4)->where('winner_id',$this->user->id)->where('(host_id='.$this->user->id.' OR joiner_id='.$this->user->id.')')->get('matches')->num_rows();
       $stat->wonMatches = $earnings;

        return $stat;
    }
     
  
    // ###############################
    //     PAGES RELATED FUNCTIONS
    // ###############################

    public function home()
    {
        $this->onlyforauth();
        $data['title'] = COMPANY_NAME . ' | Home';
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();
        $data['games'] = $this->db->get('game')->result();
        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/home', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }


    public function matches()
    {
        $this->onlyforauth();
        $data['title'] = COMPANY_NAME . ' | Matches';
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();


        $data['i_load_url'] = base_url('user/mdata');

        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/matchhistory', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }

    public function notifications()
    {
        $this->onlyforauth();
        $data['title'] = COMPANY_NAME . ' | Notifications';
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();


        $data['i_load_url'] = base_url('user/ndata');

        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/notifications', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }

    public function openmatch($matchid)
    {
        $this->onlyforauth();

        $data['matchid']=$matchid;
        $matchid = $this->secure('decrypt', $matchid);

        $conflict = $this->db->where('match_id',$matchid)->get('conflicts')->row();
        if($conflict){
            $_SESSION['info-msg'] = 'both players submitted same result conflict created , match will be reviewed by admin';
            redirect(base_url('user/matches'));
        }

        $data['match'] = $match = $this->db->where('(host_id='.$this->user->id.' OR joiner_id='.$this->user->id.')')->where('id', $matchid)->get('matches')->row();
        if (!$match) {
            $_SESSION['error-msg'] = 'invalid game selection, please select from the above games';
            redirect(base_url('user/home'));
        }

        if($match->status==3){
            $_SESSION['error-msg'] = 'match canceled & money is refunded in your wallet';
            redirect(base_url('user/home'));
        }

        if($match->status==4){
            redirect(base_url('user/matches'));
        }

        $ct = time();
        if($match->room_code=='' && ($ct-$match->created_at)>(60*3)){

            $txn['user_id']=$match->joiner_id;
            $txn['txnid']=$this->txnid();
            $txn['amount']=$match->amount;
            $txn['created_at']=time();
            $txn['updated_at']=time();
            $txn['type']='CREDIT';
            $txn['tag']='CREATE_MATCH';
            $txn['status']=2;
            $txn['remarks']='Match Cancelled / No Room Code';
            $txn['match_id']=$match->id;

            $this->db->insert('txns',$txn);

            $txn['user_id']=$match->host_id;
            $txn['txnid']=$this->txnid();

            $this->db->insert('txns',$txn);
            $this->db->where('id',$match->id)->update('matches',[
                'status'=>3,
                'remarks'=>'auto cancelled because host not submited room code in given time'
            ]);

           

            $this->db->where('match_id',$match->id)->update('cancel_reqs',[
                'status'=>0
            ]);

        }

        $data['game'] = $game = $this->db->where('id', $match->game_id)->get('game')->row();

        
        $data['creq']=$this->db->where('match_id',$match->id)->where('user_id',$this->user->id)->where('status',1)->get('cancel_reqs')->row();

if($match->host_id==$this->user->id){
$aid=$match->joiner_id;
}else{
    $aid=$match->host_id;

}
        $data['acreq']=$this->db->where('match_id',$match->id)->where('user_id ',$aid)->where('status',1)->get('cancel_reqs')->row();

        $data['title'] = COMPANY_NAME . ' | ' . $game->game_name . ' #' . $match->id;
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();
        $data['fn'] = $this;
        

        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/openmatch', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }


    public function account()
    {
        $this->onlyforauth();
        $data['title'] = COMPANY_NAME . ' | Account';
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();
        $data['kyc'] = $kyc = $this->db->where('user_id', $this->user->id)->get('kyc')->row();

        $data['fn']=$this;
        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/account', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }

    public function addmoney()
    {
        $this->onlyforauth();
        $req = $this->input->post();
        if(!$req) redirect(base_url('user/wallet'));
        
        $data['title'] = COMPANY_NAME . ' | Account';

       



        if(isset($req['amount']) && $req['amount']>0 && ctype_digit($req['amount'])){

            if(!isset($_SESSION['d_txn_id'])){
                $txn['user_id']=$this->user->id;
                $txn['txnid']=$this->txnid();
                $txn['amount']=$req['amount'];
                $txn['created_at']=time();
                $txn['updated_at']=time();
                $txn['type']='CREDIT';
                $txn['tag']='DEPOSIT';
                $txn['status']=1;
                $txn['remarks']='Deposit to Wallet';
                $this->db->insert('txns',$txn);
                $_SESSION['d_txn_id']=$this->db->insert_id();
            }
           


            $txnq = $this->db->where('id',$_SESSION['d_txn_id'])->get('txns')->row();






            $data['user'] = $this->user;
            $data['fn']=$this;
            $data['amount']=$req['amount'];
            $data['txnid']=$txnq->txnid;


            $this->load->view('user/auth/upipay', $data);
        }else{
            $_SESSION['error-msg'] = 'enter a valid amount or refresh the page and try again';
            redirect(base_url('user/wallet'));
        }
     

       
       
    }

    public function refer()
    {
        $this->onlyforauth();
        $data['title'] = COMPANY_NAME . ' | Account';
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();
        $data['fn']=$this;
        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/refer', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }

    public function wallet()
    {
        $this->onlyforauth();
        $data['title'] = COMPANY_NAME . ' | Wallet';
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();
        $data['fn']=$this;
        $data['bank']=$this->db->where('user_id',$this->user->id)->get('bank_details')->row();
        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/wallet', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }


    
    public function contact()
    {
        $this->forall();
        $data['title'] = COMPANY_NAME . ' | Contact Us';
        if(isset($this->user) && $this->user){
            $data['user'] = $this->user;
            $data['balance'] = $this->getWalletBalance();
            $this->load->view('user/auth/header', $data);
            $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
            $this->load->view('user/auth/sidebar', $data);
        }else{
            $this->load->view('user/common/header2', $data);
        }
        
      
       
        $this->load->view('user/public/contact', $data);
    

        if(isset($this->user) && $this->user){
            $this->load->view('user/auth/bottombar', $data);
            $this->load->view('user/auth/footer', $data);
        }else{
            $this->load->view('user/common/footer', $data);
        }
    }

    public function terms()
    {
       
        $this->forall();
        $data['title'] = COMPANY_NAME . ' | Terms & Conditions';
        if(isset($this->user) && $this->user){
            $data['user'] = $this->user;
            $data['balance'] = $this->getWalletBalance();
            $this->load->view('user/auth/header', $data);
            $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
            $this->load->view('user/auth/sidebar', $data);
        }else{
            $this->load->view('user/common/header2', $data);
        }
        
      
       
        $this->load->view('user/public/terms', $data);
    

        if(isset($this->user) && $this->user){
            $this->load->view('user/auth/bottombar', $data);
            $this->load->view('user/auth/footer', $data);
        }else{
            $this->load->view('user/common/footer', $data);
        }
    }

    public function privacy()
    {
        $this->forall();
        $data['title'] = COMPANY_NAME . ' | Privacy Policy';
        if(isset($this->user) && $this->user){
            $data['user'] = $this->user;
            $data['balance'] = $this->getWalletBalance();
            $this->load->view('user/auth/header', $data);
            $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
            $this->load->view('user/auth/sidebar', $data);
        }else{
            $this->load->view('user/common/header2', $data);
        }
        
      
       
        $this->load->view('user/public/privacy', $data);
    

        if(isset($this->user) && $this->user){
            $this->load->view('user/auth/bottombar', $data);
            $this->load->view('user/auth/footer', $data);
        }else{
            $this->load->view('user/common/footer', $data);
        }
    }

    public function aboutus()
    {
        $this->forall();
        $data['title'] = COMPANY_NAME . ' | About Us';

        if(isset($this->user) && $this->user){
            $data['user'] = $this->user;
            $data['balance'] = $this->getWalletBalance();
            $this->load->view('user/auth/header', $data);
            $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
            $this->load->view('user/auth/sidebar', $data);
        }else{
            $this->load->view('user/common/header2', $data);
        }
        
      
       
        $this->load->view('user/public/about', $data);
    

        if(isset($this->user) && $this->user){
            $this->load->view('user/auth/bottombar', $data);
            $this->load->view('user/auth/footer', $data);
        }else{
            $this->load->view('user/common/footer', $data);
        }
    }
    




    public function transactions($type = 'all')
    {
        $this->onlyforauth();
        $data['title'] = COMPANY_NAME . ' | Transactions';
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();


        $data['i_load_url'] = base_url('user/loadtxns/' . $type);
        $where['user_id'] = $this->user->id;
        if ($this->getTag($type)) {
            $where['tag'] = $this->getTag($type);
        }

        $data['type'] = $type;

        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/transaction', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }

    public function withdraws()
    {
        $this->onlyforauth();
        $data['title'] = COMPANY_NAME . ' | Withdraws';
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();


        $data['i_load_url'] = base_url('user/loadwithdraws/');
       

        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/withdraws', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }

    public function kyc()
    {
        $this->onlyforauth();
        $data['title'] = COMPANY_NAME . ' | KYC';
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();
        $data['kyc'] = $kyc = $this->db->where('user_id', $this->user->id)->get('kyc')->row();
        if ($kyc && $kyc->status != 0) {
            $_SESSION['info-msg'] = 'kyc submitted or approved !';
            redirect(base_url('user/account'));
        }
        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/kyc', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }






    public function loadmatchdata($gameid)
    {
        $this->onlyforauth();
        $data['user'] = $this->user;
        $data['gameid'] = $gameid = $this->secure('decrypt', $gameid);
        $data['game'] = $game = $this->db->where('id', $gameid)->get('game')->row();
        if (!$game) {
            $_SESSION['error-msg'] = 'invalid game selection, please select from the above games';
            redirect(base_url('user/home'));
        }

        $data['joinedmatches'] = $this->db->where('game_id', $gameid)->where('(host_id=' . $this->user->id . ' OR joiner_id=' . $this->user->id . ')')->where('status', 2)->order_by('id', 'desc')->get('matches')->result();
        $data['createdmatches'] = $this->db->where('game_id', $gameid)->where('host_id', $this->user->id)->where('status', 1)->order_by('id', 'desc')->get('matches')->result();
        $data['openmatches'] = $this->db->where('game_id', $gameid)->where('host_id !=', $this->user->id)->where('status', 1)->order_by('id', 'desc')->get('matches')->result();
        $data['fn'] = $this;

        $data['runningmatches'] = $this->db->where('game_id', $gameid)->where('status', 2)->order_by('id', 'desc')->get('matches')->result();
        $this->load->view('user/auth/matches', $data);
    }

    public function creatematch($gameid)
    {
        $this->onlyforauth();
        $data['gameid'] = $gameid = $this->secure('decrypt', $gameid);
        $data['game'] = $game = $this->db->where('id', $gameid)->get('game')->row();
        if (!$game) {
            $_SESSION['error-msg'] = 'invalid game selection, please select from the above games';
            redirect(base_url('user/home'));
        }
        $data['title'] = COMPANY_NAME . ' | ' . $game->game_name;
        $data['user'] = $this->user;
        $data['balance'] = $this->getWalletBalance();
$data['fn']=$this;


        $this->load->view('user/auth/header', $data);
        $this->load->view('user/public/info', $data);
$this->load->view('user/auth/topbar', $data);
        $this->load->view('user/auth/sidebar', $data);
        $this->load->view('user/auth/creatematch', $data);
        $this->load->view('user/auth/bottombar', $data);
        $this->load->view('user/auth/footer', $data);
    }
}
