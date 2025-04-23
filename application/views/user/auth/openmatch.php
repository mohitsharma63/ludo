<div class="mt-4 mx-3">
    <div class=" bg-gold p-2 rounded">
        <div class="fw-bold d-flex justify-content-between align-items-center">
            <div><?= $game->game_name ?> | Match Id #<?= $match->id ?></div>
            <div>
                <a href="<?= base_url('user/creatematch/' . $fn->secure('encrypt', $game->id)) ?>" class="text-decoration-none fw-bold btn btn-sm btn-dark showloader"><i class="bi bi-arrow-left-circle"></i></a>
            </div>
        </div>
        <div class="border border-1 border-dark my-1"></div>
        <?php
if($match->room_code==''){
    if($match->host_id==$user->id){
?>
 <?= form_open('user/saveroomcode/' . User::secure('encrypt', $match->id), ["class" => "showloader-form mt-3"]) ?>
 <div class="d-flex justify-content-between align-items-center text-white mb-2">
 <h5 class="fw-bold text-dark">Enter Room Code</h5>
 <div id="timer" class="fs-4 fw-bold bg-danger px-3 rounded rounded-4" style="background-color:red !important"></div>
    </div>
<div class="input-group mb-3">


    <input type="number" class="input-1 form-control border-gold " placeholder="room code" name="room_code" required>


    <button type="submit" class="input-group-text btn btn-dark" id="basic-addon1">SUBMIT</button>
</div>

<?= form_close() ?>
<?php
    }else{
        ?>
         <div class="d-flex justify-content-center align-items-center text-white mb-2">

 <div id="timer" class="fs-4 fw-bold bg-danger px-3 rounded rounded-4" style="background-color:red !important"></div>
    </div>
 <div class="bg-black rounded mx-2 my-2">
            
            <div class=" text-center text-gold fs-4 opacity-75 py-3 d-flex align-items-center gap-2 justify-content-center"><img src="<?=base_url('assets/images/loading.svg')?>" height="50px" width="50px">Waiting For Room Code</div>
            <div class="border border-1 border-warning my-1"></div>


        </div>
        <?php
    }
}else{
    ?>
 <div class="bg-black rounded mx-2 my-2">
            <div class="text-gold fs-1 fw-bold text-center"><?= $match->room_code ?></div>
            <div class=" text-center text-gold fs-4 opacity-75">Room Code</div>
            <div class="border border-1 border-warning my-1"></div>


        </div>
    <?php
}
        ?>
       
       



    </div>

    <?php
    if($user->id==$match->joiner_id){
        $result='joiner_result';
        }elseif($user->id==$match->host_id){
        $result='host_result';
        
        }

if(!$creq){
    if($match->$result==0){
    
    ?>

<div class="d-flex gap-3 justify-content-between my-3 w-100">
        <button data-text="<?= $match->room_code ?>" class="copy fw-bold text-nowrap btn btn-sm btn-warning w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-clipboard"></i> Copy Code</button>
       
       
       
        
<div class="modal fade" id="cancelreq" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 border-2 border-dark bg-black">
                <div class=" fw-bold text-white w-100" id="exampleModalLabel">Request Match Cancel</div>
                <button type="button" class="btn-close btn-sm text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body bg-gold  rounded-bottom">
                
            <?= form_open('user/submitcancellation/'.$matchid, ["class" => "showloader-form"]) ?>
    
        <div class="d-flex flex-column gap-2">
  <?php
$reasons=['Room Code Not Working','Other Player Not Joining',"Don't Want To Play"]
  ?>
        <select type="text" class="input-1 form-control border-gold text-start" placeholder="bank name" value="" name="reason" aria-label="Username" aria-describedby="basic-addon1" required>
        <option value="">Select Reason</option>
        <?php
foreach($reasons as $bn){
    ?>
<option value="<?=$bn?>"><?=$bn?></option>
    <?php
}
        ?>
</select>
        
</div>
  
    <div class="small mb-3 mt-1">
<b>Note:</b> once you submit the cancellation request you cannot submit game result .
    </div>
<div class="text-center">
    <button type="submit" class="btn btn-dark bg-black w-100 fw-bold"> Submit Cancellation Request</button>
</div>
    <?= form_close() ?>

            </div>

        </div>
    </div>
</div>
       
        <button data-bs-toggle="modal" data-bs-target="#cancelreq" class="fw-bold text-nowrap btn btn-sm btn-dark w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-x-circle"></i> Request Cancel</button>
    </div>


    <?php
    }
}else{
    ?>

    <?php
}
    ?>

    <?php
    $host = $this->db->where('id', $match->host_id)->get('users')->row();
    $joiner = $this->db->where('id', $match->joiner_id)->get('users')->row();
    if ($host->id == $user->id) {
        $player1 = 'You';
        $player2 = '@' . $joiner->username;
    } else {
        $player1 = '@' . $host->username;
        $player2 = 'You';
    }
    ?>
    <div class="rounded bg-gold mb-3 mt-3">
        <div>
            <div class="d-flex justify-content-between align-items-center p-2 border-bottom border-dark" style="font-size:16px;">
                <div class="fw-bold w-100 small">Entry Fee : ₹ <?= $fn->amount($match->amount) ?></div>

                <div class="fw-bold w-100 text-end small">Prize : ₹ <?= $match->prize ?></div>

            </div>

            <div class="d-flex justify-content-between align-items-center py-2 px-2">
                <div class="fw-bold text-center">
                    <div><img src="<?= base_url('assets/images/avatars/avatar' . $host->profile . '.png') ?>" height="35px" width="35px" /></div>
                    <div style="font-size:13px;"><?= $player1 ?></div>
                </div>
                <div class="w-100 text-center">


                    <img src="<?= base_url('assets/images/vs.png') ?>" height="40px" width="40px" />


                </div>
                <div class="fw-bold text-center">
                    <div><img src="<?= base_url('assets/images/avatars/avatar' . $joiner->profile . '.png') ?>" height="40px" width="40px" /></div>
                    <div style="font-size:13px;"><?= $player2 ?></div>
                </div>
            </div>



        </div>
    </div>
<?php
if(!$creq){
    ?>

    <?php
    


if($match->$result==0){
    if($match->room_code!=''){
?>


 <div class="d-flex gap-3 justify-content-between my-3 w-100">


 <div class="modal fade" id="iwon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 border-2 border-dark bg-black">
                <div class=" fw-bold text-white w-100" id="exampleModalLabel">Submit Result</div>
                <button type="button" class="btn-close btn-sm text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body bg-gold  rounded-bottom">
                
            <?= form_open_multipart('user/submitresult/'.$matchid, ["class" => "showloader-form"]) ?>
           <input type="hidden" name="result" value="winner" />
      
            <label class="fw-bold text-black w-100 mt-2">
            Winning Screenshot
        </label>
        <input type="file" id="target" name="screenshot" accept="image/*" class=" input-1 form-control border-gold my-2"  required />

  
    <div class="small mb-3 mt-1">
<b>Note:</b> ₹ <?=WRONG_RESULT_PENALTY?> will be charged on wrong result submit.
    </div>
<div class="text-center">
    <button type="submit" class="btn btn-dark bg-black w-100 fw-bold button-41"><i class="bi bi-hand-thumbs-up-fill"></i> Submit Result As Winner</button>
</div>
    <?= form_close() ?>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="ilost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 border-2 border-dark bg-black">
                <div class=" fw-bold text-white w-100" id="exampleModalLabel">Submit Result</div>
                <button type="button" class="btn-close btn-sm text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body bg-gold  rounded-bottom">
                
            <?= form_open_multipart('user/submitresult/'.$matchid, ["class" => "showloader-form"]) ?>
           <input type="hidden" name="result" value="looser" />
      
          
    <div class="small mb-3 mt-1">
<b>Note:</b> ₹ <?=WRONG_RESULT_PENALTY?> will be charged on wrong result submit.
    </div>
<div class="text-center">
    <button type="submit" class="btn btn-dark bg-black w-100 fw-bold button-42"><i class="bi bi-hand-thumbs-down-fill"></i> Submit Result As Looser</button>
</div>
    <?= form_close() ?>

            </div>

        </div>
    </div>
</div>

        <button data-bs-toggle="modal" data-bs-target="#iwon" class="btn fw-bold button-41 w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-hand-thumbs-up-fill"></i> I WON</button>
        <button data-bs-toggle="modal" data-bs-target="#ilost" class="btn fw-bold button-42 w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-hand-thumbs-down-fill"></i> I LOSE</button>
    </div>

    <?php
}
}else{
    ?>
<div class="my-3 bg-black rounded p-2 fw-bold animate__animated animate__pulse animate_slower animate__infinite text-center text-white">
 You subitted result as <?=$match->$result==1?'Winner':'Looser'?>
</div>
    <?php
}
    ?>


<?php
}else{
    ?>
<div class="my-3 bg-danger rounded p-2 fw-bold animate__animated animate__pulse animate_slower animate__infinite text-center text-white">
<i class="bi bi-exclamation-triangle"></i> You subitted cancellation request
</div>
    <?php
}

if($acreq){
    ?>
<div class="my-3 bg-gold rounded p-2 fw-bold animate__animated animate__pulse animate_slower animate__infinite text-center text-dark">
 Another Player Requested game cancellation
 <div>

 <?= form_open('user/submitcancellation/'.$matchid, ["class" => "showloader-form"]) ?>
   <input type="hidden" name="reason" value="Accepted another player cancellation request" /> 
<div class="text-center">
<button type="submit" class="mt-1 fw-bold text-nowrap btn btn-sm btn-dark w-100 d-flex align-items-center justify-content-center gap-1">Cancel Game</button>
</div>
<?= form_close() ?>

</div>
</div>
    <?php
}
?>


<div class="mt-3 p-2 rounded bg-gold">
<b>Note:</b> Game हारने के बाद ( i lost ) पर click करके submitted करे ऐसा नही करने पर ₹<?=WRONG_RESULT_PENALTY?> fine होगा
</div>
 
<div class="mt-3 p-2 rounded bg-gold">
<b>Note:</b> <?=COMPANY_NAME?> पर Ludo खेलने के लिए आपके mobile में : LUDO KING  APP होना चाहिए क्युकी <?=COMPANY_NAME?> मे Manual Room Code दिया जाता हैं
</div>

<div class="mt-3 p-2 rounded bg-gold">
<b>Note:</b> केवल Classic Room Code को valid माना जाएगा, popular code देने पर balance 00 और I'D को भी block किया जा सकता हैं।
</div>




</div>

<?php
if($match->room_code==''){
    ?>
<script>

var countDownDate = new Date("<?=date('M d, Y H:i:s',$match->joiner_time+180)?>").getTime();;


// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  if(seconds<10){
    seconds='0'+seconds
  }

             document.getElementById('clock').play();
  document.getElementById("timer").innerHTML = '0'+ minutes + ":" + seconds ;
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "Times Up";
    $("#loader").show();
    location.reload();
  }
}, 1000);


</script>
    <?php
}
?>
