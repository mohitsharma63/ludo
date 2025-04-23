<?php
    if($admin->permissions){
      $access = explode("#",$admin->permissions);
    }else{
      $access=[];
    }

    if(!in_array('p_mu',$access)) redirect(base_url('admin'));
    ?>
<div class="container-fluid">

      <div class="page-header py-5 border-radius-xl " style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
          <div class="col-auto">
            <div class="avatar avatar-xl rounded-circle position-relative">
              <img src="<?=base_url("assets/images/avatars/avatar".$user->profile.".png")?>" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
                <?=$user->full_name?>
              </h5>
              <p class="mb-0 font-weight-bold text-sm">
              <?=$user->mobile_no?>
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
            <div class="nav-wrapper position-relative end-0">
              <ul class="nav nav-pills nav-fill p-1 bg-transparent on-resize" role="tablist">
                
                <li class="nav-item" role="presentation">
                <?= form_open('', ["method"=>"get","class" => "showloader-form"]) ?>
                <input type="hidden" name="menu" value="Dashboard"/>
                  <button type="submit" class="nav-link mb-0 px-0 py-1 <?=$menu=='Dashboard'?'bg-primary text-white':''?> " data-bs-toggle="tab"  role="tab" aria-selected="true">
                    <span class="ms-1">Dashboard</span>
                  </button>
                  <?=form_close()?>
                </li>


                <li class="nav-item" role="presentation">
                <?= form_open('', ["method"=>"get","class" => "showloader-form"]) ?>
                <input type="hidden" name="menu" value="Transactions"/>
                  <button type="submit" class="nav-link mb-0 px-0 py-1 <?=$menu=='Transactions'?'bg-primary text-white':''?> " data-bs-toggle="tab"  role="tab" aria-selected="true">
                    <span class="ms-1">Transactions</span>
                  </button>
                  <?=form_close()?>
                </li>


                <li class="nav-item" role="presentation">
                <?= form_open('', ["method"=>"get","class" => "showloader-form"]) ?>
                <input type="hidden" name="menu" value="Matches"/>
                  <button type="submit" class="nav-link mb-0 px-0 py-1 <?=$menu=='Matches'?'bg-primary text-white':''?> " data-bs-toggle="tab"  role="tab" aria-selected="true">
                    <span class="ms-1">Matches</span>
                  </button>
                  <?=form_close()?>
                </li>

</ul>
              


              

                
              
            </div>
          </div>
        </div>
      </div>
    </div>




<?php
if($menu=='Transactions'){
?>
<div class="card mx-4 mt-3">
<div class="d-flex gap-2 flex-wrap p-3 justify-content-between">

<?= form_open('admin/fetchtxns/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform","id"=>'allform']) ?>
<input type="hidden" name="type" value="ALL" />
<button type="submit" class="btn btn-primary btn-sm filter">ALL</button>
<?=form_close()?>
<script>
  $(function(){
    $("#allform").submit();
  })

  </script>

<?= form_open('admin/fetchtxns/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="DEPOSIT" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">DEPOSIT</button>
<?=form_close()?>

<?= form_open('admin/fetchtxns/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="WITHDRAW" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">WITHDRAW</button>
<?=form_close()?>

<?= form_open('admin/fetchtxns/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="PENALTY" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">PENALTY</button>
<?=form_close()?>

<?= form_open('admin/fetchtxns/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="WIN_REWARD" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">WINNINGS</button>
<?=form_close()?>

<?= form_open('admin/fetchtxns/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="REFERRAL_BONUS" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">REFERRALS</button>
<?=form_close()?>

<?= form_open('admin/fetchtxns/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="CREATE_MATCH" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">MATCHES</button>
<?=form_close()?>

<?php
if(in_array('p_at',$access)){
?>

<button class="btn btn-sm btn-success bg-gradient-success" data-bs-toggle="modal" data-bs-target="#addtxn">₹ ADD TRANSACTION</button>


<!-- Modal -->
<div class="modal fade" id="addtxn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Transaction</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <?= form_open('admin/addtxn', ["class" => "ajaxform",'id'=>'addtxnform']) ?>
      <input type="hidden" name="user" value="<?=Admin::secure('encrypt',$user->id)?>" />
      
      <select class="form-control mb-2" name="type" required>
<option value="TDM">Deposit Money</option>
<option value="TP">Penalty</option>

</select>
      <input type="number" name="amount" class="form-control" placeholder="enter amount" required/>
        

  


    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Add Transaction</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>
</div>
<?php
}
?>

</div>

<div id="fetchloader" class="text-center" style="display:none">
<img src="<?= base_url('assets/images/loading2.svg') ?>" width="50px"/>
</div>

<div id="i_show_fetch_data">

</div>

</div>
<?php
}elseif($menu=='Matches'){
?>
<!-- ################################# -->

<div class="card mx-4 mt-3">
<div class="d-flex gap-2 flex-wrap p-3 justify-content-between">

<?= form_open('admin/fetchmatches/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform","id"=>'allform']) ?>
<input type="hidden" name="type" value="ALL" />
<button type="submit" class="btn btn-primary btn-sm filter">ALL MATCHES</button>
<?=form_close()?>
<script>
  $(function(){
    $("#allform").submit();
  })

  </script>

<?= form_open('admin/fetchmatches/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="active" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">ACTIVE MATCHES</button>
<?=form_close()?>

<?= form_open('admin/fetchmatches/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="win" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">WINNED MATCHES</button>
<?=form_close()?>

<?= form_open('admin/fetchmatches/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="lose" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">LOST MATCHES</button>
<?=form_close()?>

<?= form_open('admin/fetchmatches/'.Admin::secure('encrypt',$user->id), ["class" => "fetchform"]) ?>
<input type="hidden" name="type" value="cancel" />
<button type="submit" class="btn btn-outline-primary btn-sm filter">CANCELLED MATCHES</button>
<?=form_close()?>





</div>

<div id="fetchloader" class="text-center" style="display:none">
<img src="<?= base_url('assets/images/loading2.svg') ?>" width="50px"/>
</div>

<div id="i_show_fetch_data">

</div>

</div>

<!-- ################################# -->
<?php
}else{

?>


    <!-- //Details -->
     <div class="card mx-4 mt-3">
    <?php
    $deposit = $this->db->select('SUM(amount) as amount')->where('tag','DEPOSIT')->where('user_id',$user->id)->where('status',2)->get('txns')->row()->amount;
    $withdraws = $this->db->select('SUM(amount) as amount')->where('tag','WITHDRAW')->where('user_id',$user->id)->where('status',2)->get('txns')->row()->amount;

 $refer=null;
 if($user->refer_by){
     $refer=$this->db->where('referral_code',$user->refer_by)->get('users')->row();
 }
$stat = $fn->getstat($user);
 $kyc=$ukyc=$this->db->where('user_id',$user->id)->get('kyc')->row();
 if(!$kyc) $kyc=404;
 else $kyc=$kyc->status;



    ?>

    <div class=" p-2 d-flex gap-2 justify-content-between flex-wrap">

    <div class="d-flex gap-2 flex-wrap">
    <div>


    
  <?php
if($user->online==1){
  ?>
<span class="badge badge-sm bg-gradient-success">Online</span>

  <?php
}else{
  ?>
<span class="badge badge-sm bg-gradient-secondary">Offline</span>

  <?php
}
?>
</div>


<div>
    <?php
if($kyc==0){
    $kyct='Rejected';
  ?>
<span class="badge badge-sm bg-gradient-danger">KYC Rejected</span>

  <?php
}elseif($kyc==1){
    $kyct='Submitted';

  ?>
<span class="badge badge-sm bg-gradient-warning">KYC Submitted</span>

  <?php
}elseif($kyc==2){
    $kyct='Completed';

    ?>
  <span class="badge badge-sm bg-gradient-success">KYC Completed</span>

    <?php
  }else{
    $kyct='Not Submitted';
    
    ?>
  
    <span class="badge badge-sm bg-gradient-secondary">KYC Not Submitted</span>

  <?php }
?>
</div>

  </div>

<div class="d-flex gap-2 flex-wrap">
   
<span class="badge badge-sm bg-gradient-success"><i class="fas fa-wallet"></i> &nbsp; <?=$fn->getWalletBalance($user->id)?> ₹</span>

<?php
if(in_array('p_snsu',$access)){
?>

<span class="badge badge-sm bg-gradient-primary splbtn" data-bs-toggle="modal" data-bs-target="#sendnotification"><i class="ni ni-notification-70"></i> SEND NOTIFICATION</span>

<!-- Modal -->
<div class="modal fade" id="sendnotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Notification</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Enter Notification Content</h6>
      <?= form_open('admin/sendnotification', ["class" => "showloader-form"]) ?>
      <input type="hidden" name="user" value="<?=Admin::secure('encrypt',$user->id)?>" />
    <textarea class="form-control" name="message" required></textarea>

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Send</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>
</div>
<?php
}
?>


<?php
if(in_array('p_bu',$access)){
?>
<a href="<?=base_url('admin/changeuserstatus/'.Admin::secure('encrypt',$user->id).'/'.($user->status==1?0:1))?>" class="badge showloader badge-sm bg-gradient-danger splbtn"><i class="ni ni-circle-08"></i> <?=$user->status==1?'BAN USER':'UNBAN USER'?></a>
<?php
}
?>



 
</div>


</div>




  </div>

  <div class="card mx-4 mt-4 p-3">
    <h5 class="text-center">Player Statistics & Information</h5>
    <hr class="horizontal dark mt-0">
    <div class="d-flex justify-content-between flex-wrap">
  <ul class="list-group col-md-6">

  <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Username:</strong> &nbsp; <?=$user->username?></li>
  <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Mobile No:</strong> &nbsp; <?=$user->mobile_no?></li>


                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Registered On:</strong> &nbsp; <?=$fn->format($user->created_at)?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Last Active:</strong> &nbsp; <?=$fn->format($user->online_date)?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Status:</strong> &nbsp; <?=$user->online==1?'Online':'Offline'?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Wallet Balance:</strong> &nbsp; <?=$fn->getWalletBalance($user->id)?> ₹</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Account Status:</strong> &nbsp; <?=$user->status==1?'Active':'Banned'?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">KYC Status:</strong> &nbsp; <?=$kyct?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Total Deposit:</strong> &nbsp; <?=$fn->amount($deposit)?> ₹</li>

 </ul>
 <ul class="list-group col-md-6">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Winnings:</strong> &nbsp; <?=$stat->winRewards?> ₹</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Referral Bonus:</strong> &nbsp; <?=$stat->referralBonus?> ₹</li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Total Referrals:</strong> &nbsp; <?=$stat->referedUsers?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Played Matches:</strong> &nbsp; <?=$stat->playedMatches?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Won Matches:</strong> &nbsp; <?=$stat->wonMatches?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Lost Matches:</strong> &nbsp; <?=$stat->playedMatches-$stat->wonMatches?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Referral Code:</strong> &nbsp; <?=$user->referral_code?></li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Refered By:</strong> &nbsp; 
                

                <?php

if($refer){
?>
  <?=$refer->full_name?> (<?=$refer->mobile_no?>)
<?php
}else{
    ?>
None
    <?php
}
                ?>
              
            
            </li>
            <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Total Withdraws:</strong> &nbsp; <?=$fn->amount($withdraws)?> ₹</li>








               
              </ul>
  </div>
  </div>

  <?php } ?>