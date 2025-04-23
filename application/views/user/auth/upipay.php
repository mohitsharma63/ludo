<?php



$note=$user->mobile_no.' | '.$txnid ;


$url="upi://pay?pa=".$this->db->get('config')->row()->pb_vpa."&pn=&am=$amount&tn=$note&tr=$txnid";
$url2=$url;
$url=urlencode($url);


$qrurl="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=$url&choe=UTF-8&chld";

// // $qrcode = imagecreatefrompng(file_get_contents($qrurl));
// // print_r($qrcode);
// $image=file_get_contents($qrurl);
// $qrname=rand(11111111,999999999).'_'.str_shuffle('abcdefghizxczx').'_'.time();
// file_put_contents('./assets/images/qrcodes/'.$qrname.'.png', $image);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UPI Payment</title>
    <link rel="icon" href="<?= base_url(SITEICON) ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="<?=base_url('assets/css/main.css')?>" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>

.container{
    width:100%;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}
</style>
</head>
  <body class="bg-gold">
   <div class="container">
   <div class="p-3 rounded shadow bg-white">
    <div class="d-flex gap-2 align-items-center justify-content-center">
<img src="<?= base_url(SITELOGO) ?>" height="70px" />
<div class="border-start border-dark border-2 px-2">
<h5><?= COMPANY_NAME ?></h2>
<h5 class="fw-bold">UPI PAYMENT</h2>

</div>
</div>


<img src="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=<?=$url?>" width="300px" height="300px" class="my-2"/>
	   <div class="text-center small">Please Scan The QR Code Using Any UPI<br> App & Add ₹ <?=$amount?> In Your Wallet Instantly</div>
      <div class="text-center mt-1"> <a href="<?=base_url('user/canceldeposit')?>" class="btn btn-danger btn-sm w-75 mx-auto">Cancel Payment</a> </div>

<hr>
<div id="paymentpendingmsg">
<div class="text-center fs-5 d-flex align-items-center justify-content-center gap-2 fw-bold text-secondary">
<img src="<?=base_url('assets/images/loading2.svg')?>" height="40px"/> Waiting for Payment
</div>
</div>
<div id="paymentsuccessmsg" style="display:none">
<div class="text-center fs-5 d-flex align-items-center justify-content-center gap-2 fw-bold text-secondary">
<i class="bi bi-patch-check-fill text-success"></i> Payment Successfull
</div>
</div>
   </div>
   </div>

   <div id="loading" style="display:none;top:0;bottom:0;z-index:+99999999999999999999;position:fixed">
<div style="color:white;display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;width:100vw;background-color:rgba(0,0,0,0.8)">
<img src="<?=base_url('assets/images/loading2.svg')?>" width="50"/>
<h5>please do not refresh or close this window</h5>
</div>
</div>
   <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

   <script src="<?= base_url('assets/js/functions.js?v=' . time()) ?>"></script>
   <script src="<?= base_url('assets/js/verifypayment.js?v=' . time()) ?>"></script>
 
  </body>
</html>