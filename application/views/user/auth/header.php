<?php
unset($_SESSION['d_txn_id']);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="fast2sms" content="p1ZicHySeAhjizMQQeizMA9SivOKP0i1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= @$title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="icon" href="<?= base_url(SITEICON) ?>" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css?v=' . VERSION) ?>" />
       <link rel="manifest" href="<?=base_url('assets/manifest.json?v=' . VERSION)?>">


</head>

<body style='background-image: url(<?= base_url("assets/images/background.jpg?") ?>);'>
<div style="display:none">
<audio id="notsound" controls>
        <source id="source" src="<?=base_url('assets/notify.wav')?>" type="audio/wav">
        Your browser does not support the audio element.
    </audio>
    <audio id="clock" controls>
        <source id="source" src="<?=base_url('assets/beep.wav')?>" type="audio/wav">
        Your browser does not support the audio element.
    </audio>
  </div>
  
    <div id="loader" style="display: none;">
        <div id="loading">
            <img src="<?= base_url('assets/images/loading.svg') ?>" />
        </div>
    </div>

<?php
$notification=false;
if($user->notifications>0){
    $notification = $this->db->where('(user=0 OR user='.$user->id.')')->limit(1,$user->notifications-1)->order_by('id','desc')->get('notifications')->row();
}

if($user->notifications>0 && $notification){
$this->db->where('id',$notification->id)->set('seen_by','seen_by+1',FALSE)->update('notifications');
    ?>
 <div id="notification">
        <div id="loading2">
            <div class="bg-black text-gold p-2 rounded w-75 border border-2 border-warning">
<div class="text-center fw-bold"><span class="d-inline-block animate__animated animate__swing animate__infinite"><i class="bi bi-bell  "></i></span> Notification <span class="d-inline-block animate__animated animate__swing animate__infinite"><i class="bi bi-bell  "></i></span></div>
<div class="border border-1 border-warning my-1"></div>
<div class="text-center">
<?=$notification->message?>
</div>
<div class="small opacity-75 text-center mt-3">
<?= date('d M,Y h:i a', $notification->created_at) ?>
</div>
<a href="" class="showloader btn btn-warning btn-sm w-100 mt-1">MARK AS READ</a>
             </div>
        </div>
</div>
    <?php
    $this->db->where('id',$user->id)->update('users',[
    "notifications"=>$user->notifications-1
]);
}


?>

    <div class="col-md-5 mx-auto">