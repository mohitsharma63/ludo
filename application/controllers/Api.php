<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function login()
    {
        $req = $this->input->post();
        if (!$req) redirect(base_url());
        $user = $this->db->where('mobile_no', $req['mobile_no'])->get('users')->row();

        if (!isset($req['mobile_no'])) {
            $response['status'] = false;
            $response['msg'] = 'please enter 10 digit mobile no';
        } elseif (!$this->checkIfMobileNoIsValid($req['mobile_no'])) {
            $response['status'] = false;
            $response['msg'] = 'please enter a 10 digit valid mobile no';
        } elseif (!$user) {
            $response['status'] = false;
            $response['msg'] = 'mobile no is not registered';
        } elseif ($user->status == 0) {
            $response['status'] = false;
            $response['msg'] = 'your account is banned by admin, please contact support for more information';
        } else {
            $otp_api_response = $this->sendOtpToMobile($req['mobile_no']);
            $_SESSION['unreg-userdata'] = $req;
            $response['otp_api'] = $otp_api_response;

            if (!isset($otp_api_response->return) || $otp_api_response->return != true) {
                $response['status'] = false;
                $response['msg'] = 'Fast2SMS : ' . (isset($otp_api_response->message) ? implode(', ', (array)$otp_api_response->message) : 'Unknown error');
            } else {
                $response['status'] = true;
                $_SESSION['info-msg'] = 'please enter 6 digit otp, sent to your mobile no';
            }
        }

        echo json_encode($response);
    }

    public function resend()
    {
        $req = $_SESSION['unreg-userdata'];
        if (!$req) redirect(base_url());
        $otp_api_response = $this->sendOtpToMobile($req['mobile_no']);
        $_SESSION['unreg-userdata'] = $req;
        $response['otp_api'] = $otp_api_response;

        if (!isset($otp_api_response->return) || $otp_api_response->return != true) {
            $response['status'] = false;
            $response['msg'] = 'Fast2SMS : ' . (isset($otp_api_response->message) ? implode(', ', (array)$otp_api_response->message) : 'Unknown error');
        } else {
            $response['status'] = true;
            $_SESSION['info-msg'] = 'please enter 6 digit otp, sent to your mobile no';
        }

        echo json_encode($response);
    }

    public function signup()
    {
        $req = $this->input->post();
        if (!$req) redirect(base_url());
        $user = $this->db->where('mobile_no', $req['mobile_no'])->get('users')->row();

        if (isset($req['referral_code']) && $req['referral_code']) {
            $ref = $this->db->where('referral_code', strtoupper($req['referral_code']))->get('users')->row();
            if (!$ref) {
                $response['status'] = false;
                $response['msg'] = 'invalid referral code';
                echo json_encode($response);
                die();
            } else {
                unset($req['referral_code']);
                $req['refer_by'] = $ref->referral_code;
            }
        }

        if (!isset($req['full_name']) || !isset($req['mobile_no'])) {
            $response['status'] = false;
            $response['msg'] = 'please enter the details';
        } elseif ($this->checkIfValueIsNotEmpty($req['full_name'] ?? '')) {
            $response['status'] = false;
            $response['msg'] = 'please enter valid name';
        } elseif (!$this->checkIfMobileNoIsValid($req['mobile_no'])) {
            $response['status'] = false;
            $response['msg'] = 'please enter a 10 digit valid mobile no';
        } elseif ($user) {
            $response['status'] = false;
            $response['msg'] = 'mobile no already registered !';
        } else {
            $otp_api_response = $this->sendOtpToMobile($req['mobile_no']);
            $_SESSION['unreg-userdata'] = $req;
            $response['otp_api'] = $otp_api_response;

            if (!isset($otp_api_response->return) || $otp_api_response->return != true) {
                $response['status'] = false;
                $response['msg'] = 'Fast2SMS : ' . (isset($otp_api_response->message) ? implode(', ', (array)$otp_api_response->message) : 'Unknown error');
            } else {
                $response['status'] = true;
                $_SESSION['info-msg'] = 'please enter 6 digit otp, sent to your mobile no';
            }
        }

        echo json_encode($response);
    }

    public function verifyotp()
    {
        $req = $this->input->post();
        if (!$req) redirect(base_url());
        if (!isset($req['otp']) || $req['otp'] != $_SESSION['otp']) {
            $response['status'] = false;
            $response['msg'] = 'invalid otp';
        } else {
            $user = $this->db->where('mobile_no', $_SESSION['unreg-userdata']['mobile_no'])->get('users')->row();
            if (!$user) {
                // Sign up new user
                $data = $_SESSION['unreg-userdata'];
                $data['referral_code'] = strtoupper(substr(md5(time()), 0, 6));
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('users', $data);
                $user = $this->db->where('mobile_no', $data['mobile_no'])->get('users')->row();
            }

            $_SESSION['user'] = $user;
            $response['status'] = true;
            $response['msg'] = 'otp verified successfully';
        }

        echo json_encode($response);
    }

    public function secure()
    {
        if (!isset($_SESSION['user'])) {
            redirect(base_url());
        }
    }

    public function createDeviceFingerprint()
    {
        $req = $this->input->post();
        if (!$req || !isset($_SESSION['user'])) {
            $response['status'] = false;
            $response['msg'] = 'unauthorized access';
        } else {
            $req['user_id'] = $_SESSION['user']->id;
            $req['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('devices', $req);
            $response['status'] = true;
            $response['msg'] = 'device fingerprint saved';
        }

        echo json_encode($response);
    }

    public function sendOtpToMobile($number)
    {
        $otp = rand(100000, 999999);
        $this->session->set_userdata('otp', $otp);
    
        $url = 'https://www.fast2sms.com/dev/bulkV2';
        $headers = [
            "authorization: 5OVEnyx2gWrbDPC9cI3qFHA6JuYS8jzvelRGtspBQkwZMKh01a8qT9N5Ij1ABizR2xYVh7ukwrZ0Ddl6",
            "Content-Type: application/json"
        ];
    
        $payload = [
            "route" => "otp",
            "variables_values" => "$otp",
            "numbers" => $number
        ];
    
        $response = $this->sendPostRequest($url, $headers, 'post', json_encode($payload));
        return json_decode($response);
    }
    


    protected function sendPostRequest($url, $headers, $method, $data)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


    protected function checkIfMobileNoIsValid($number)
    {
        return preg_match('/^[6-9]\d{9}$/', $number);
    }

    protected function checkIfValueIsNotEmpty($value)
    {
        return trim($value) === '';
    }
}
