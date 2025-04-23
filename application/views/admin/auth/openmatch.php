<?php
    if($admin->permissions){
      $access = explode("#",$admin->permissions);
    }else{
      $access=[];
    }
    if(!in_array('p_mhd',$access)) redirect(base_url('admin'));
    
    ?>

<div class="container-fluid">

      <div class="page-header py-5 border-radius-xl " style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
        <span class="mask bg-gradient-primary opacity-6"></span>
      </div>
      <div class="card card-body blur shadow-blur mx-4 mt-n6 ">
        <div class="">
          <div>
<h5 class="text-center">Match Id #<?=$match->id?></h5>
<div class="text-center text-sm"><?=$fn->format($match->created_at)?></div>
<hr class="horizontal dark mt-0">
<div class="d-flex justify-content-between flex-wrap">

<div class="d-flex align-items-center px-2 py-2 bg-gradient-warning text-white rounded w-25">
                          <div>
                            <img src="<?=base_url('assets/images/avatars/avatar'.$host->profile.'.png')?>" class="avatar avatar-sm me-2" alt="xd">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$host->full_name?> 
                            <?=($match->winner_id==$host->id)?'<span class="text-xs fw-bold text-dark">(Winner)</span>':''?>
                            <?=($match->looser_id==$host->id)?'<span class="text-xs fw-bold text-dark">(Looser)</span>':''?>
                        </h6>
                            <div class="" style="font-size:11px"><?=$host->mobile_no?></div>
                          </div>
</div>
<div>
<img src="<?= base_url('assets/images/vs.png') ?>" height="40px" width="40px" />
</div>

<div class="d-flex align-items-center px-2 py-2 text-white bg-gradient-warning rounded w-25">
<?php
if($joiner){
    ?>
 <div>
                            <img src="<?=base_url('assets/images/avatars/avatar'.$joiner->profile.'.png')?>" class="avatar avatar-sm me-2" alt="xd">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$joiner->full_name?>
                            <?=($joiner && $match->winner_id==$joiner->id)?'<span class="text-xs fw-bold text-dark">(Winner)</span>':''?>
                            <?=($joiner && $match->looser_id==$joiner->id)?'<span class="text-xs fw-bold text-dark">(Looser)</span>':''?>
                        </h6>
                            <div class="" style="font-size:11px"><?=$joiner->mobile_no?></div>
                          </div>
    <?php
}elseif($match->status==1){
    ?>
    <div class="text-center w-100">
 <img src="<?= base_url('assets/images/loading2.svg') ?>" height="40px" width="40px" />
</div>
    <?php
}elseif($match->status==3){
    ?>
 <div class="text-center w-100">
No One Joined
</div>
    <?php
}
?>
                         

</div>

</div>
<div class="d-flex justify-content-between flex-wrap mt-2">

<div>
    <div>
Submitted Result : <?=$match->host_result==1?'<span class="badge badge-xs bg-gradient-success">Won</span>':''?>

<?=$match->host_result==2?'<span class="badge badge-xs bg-gradient-danger">Lost</span>':''?>

<?=$match->host_result==0?'<span class="badge badge-xs bg-gradient-dark">Not Submitted</span>':''?>

</div> 
<div class="text-xs"><?=$match->host_result>0?$fn->format($match->host_result_time):''?></div>
<?php
if($match->status==2 && $match->host_result==2){
    ?>
    <div class="mt-2">
         <a href="<?=base_url('admin/resethost/'.$fn->secure('encrypt',$match->id))?>" class="showloader text-decoration-none text-xs bg-dark rounded rounded-4 px-2 py-1 text-white"><i class="fas fa-undo"></i> Reset Result</a>
    </div>
   
    <?php
}
?>

</div>

<div>
    <div>
Submitted Result : <?=$match->joiner_result==1?'<span class="badge badge-xs bg-gradient-success">Won</span>':''?>

<?=$match->joiner_result==2?'<span class="badge badge-xs bg-gradient-danger">Lost</span>':''?>

<?=$match->joiner_result==0?'<span class="badge badge-xs bg-gradient-dark">Not Submitted</span>':''?>

</div> 
<div class="text-xs"><?=$match->joiner_result>0?$fn->format($match->joiner_result_time):''?></div>
<?php
if($match->status==2 && $match->joiner_result==2){
    ?>
    <div class="mt-2">
         <a href="<?=base_url('admin/resetjoiner/'.$fn->secure('encrypt',$match->id))?>" class="showloader text-decoration-none text-xs bg-dark rounded rounded-4 px-2 py-1 text-white"><i class="fas fa-undo"></i> Reset Result</a>
    </div>
   
    <?php
}
?>
</div>


</div>
<hr class="horizontal dark my-3">

<div class="d-flex flex-wrap justify-content-between">
<?=$match->status==1?'<span class="badge badge-xs bg-gradient-success">Open</span>':''?>
                    <?=$match->status==2?'<span class="badge badge-xs bg-gradient-success">Active</span>':''?>

                   
                    <?=$match->status==3?'<span class="badge badge-xs bg-gradient-danger">Cancelled</span>':''?>
                    <?=$match->status==4?'<span class="badge badge-xs bg-gradient-success">Finished</span>':''?>

<span class="badge badge-sm bg-gradient-primary">Room Code : <?=$match->room_code?></span>

<span class="badge badge-sm bg-gradient-dark">BET : ₹ <?=$fn->amount($match->amount)?></span>

<span class="badge badge-sm bg-gradient-dark">prize : ₹ <?=$fn->amount($match->prize)?></span>

<span class="badge badge-sm bg-gradient-warning">Game : <?=$game->game_name?></span>




</div>

</div>
         
        </div>
      </div>
    </div>


   <!-- ############################## -->

   <div class="mx-4 mt-4">
          <div class="card h-100">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="">
                  <h6 class="mb-0">Transactions On Match</h6>
                </div>
                <div class=" d-flex justify-content-end align-items-center">
                </div>
              </div>
            </div>
            <div class="card-body pt-4 p-3 table-responsive">
             <table class="table">
                <thead>
<tr>
<th class="p-2">Txn</th>
<th  class="p-2">Txn Id</th>
<td class="p-2">User</td>
<th  class="p-2">Type</th>
<th  class="p-2">Amount</th>
<th  class="p-2">Status</th>
<tr>
</thead>
                <tbody>
<?php
foreach($txns as $item){
    $tu=$this->db->where('id',$item->user_id)->get('users')->row();
    ?>
      
      <tr>
        <td>
                  <div class="d-flex align-items-center">
                    <?=$item->status==1?' <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-exclamation"></i></button>':''?>

                    <?=$item->status==0?' <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-times"></i></button>':''?>

                    <?=$item->status==2?' <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-check"></i></button>':''?>

                    <?=$item->status==3?' <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-times"></i></button>':''?>
                   
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm"><?=$item->remarks?></h6>
                      <span class="text-xs"><?=$fn->format($item->created_at)?></span>
                    </div>
                  </div>
</td>
<td>
    <?=$item->txnid?>
</td>
<td>
<div class="d-flex align-items-center px-2 py-2 rounded ">
                          <div>
                            <img src="<?=base_url('assets/images/avatars/avatar'.$tu->profile.'.png')?>" class="avatar avatar-sm me-2" alt="xd">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$tu->full_name?> 
                    
                        </h6>
                            <div class="" style="font-size:11px"><?=$tu->mobile_no?></div>
                          </div>
</div>
</td>
<td>
    <?=$item->type?>
</td>
<td class="">
 <?php
 if($item->type=='CREDIT'){
    ?>
<div class="d-flex align-items-center text-success  text-sm font-weight-bold">
                    + <?=$fn->amount($item->amount)?> ₹ 
                  </div>
    <?php
 }else{
    ?>
<div class="d-flex align-items-center text-danger  text-sm font-weight-bold">
                    - <?=$fn->amount($item->amount)?> ₹ 
                  </div>
    <?php
 }
 ?>

</td>
<td>
<div class="text-dark text-sm font-weight-bold">
                    <?=$item->status==1?'<span class="badge badge-xs bg-gradient-warning">Pending</span>':''?>
                    <?=$item->status==0?'<span class="badge badge-xs bg-gradient-danger">Failed</span>':''?>
                    <?=$item->status==2?'<span class="badge badge-xs bg-gradient-success">Successfull</span>':''?>
                    <?=$item->status==3?'<span class="badge badge-xs bg-gradient-danger">Cancelled</span>':''?>
                  </div>
</td>
                  
</tr>   
    <?php
}
?>
</tbody>
</table>
 </div>
          </div>
        </div>


         <!-- ############################## -->


         <div class="row mx-3 mt-4 ">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <h6>Cancel Requests On Match</h6>
            </div>
            <div class="card-body  pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                  <tr>

<th  class="p-2">Requested By</th>

<th  class="p-2">Reason</th>
<th  class="p-2">Status</th>

                    </tr>
                  </thead>
                  <tbody>
                  <?php
if(!$cancels){
    ?>
<tr>
<td colspan="3" class="text-center">
no data available
</td>
</tr>
    <?php
}
foreach($cancels as $item){
  
  $reqby = $this->db->where('id',$item->user_id)->get('users')->row();

    ?>
<tr>






<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=@$reqby->full_name?> 
                            
                          </h6>
                            <div class="" style="font-size:11px"><?=@$reqby->mobile_no??'none'?></div>
                          </div>
</div>
</td>

<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$item->reason?>
                          </h6>
                          <div class="" style="font-size:11px">Requested On <?=$fn->format($item->created_at)?></div>
                          </div>
</div>
</td>
<td>
<?php
if($item->status==0){
  ?>
  <span class="btn btn-sm bg-gradient-danger p-1 px-2"> Rejected</span>
    <?php
}elseif($item->status==1){
  ?>
  <span class="btn btn-sm bg-gradient-warning p-1 px-2">Pending</span>
    <?php
}elseif($item->status==2){
  ?>
<span class="btn btn-sm bg-gradient-success p-1 px-2"> Accepted</span>
  <?php
}
?>
</td>


</tr>
    <?php
}
?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ######################################################### -->


      <div class="row mx-3 mt-2 ">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header">
              <h6>Conflicts On Match</h6>
            </div>
            <div class="card-body  pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                  <tr>
<th  class="p-2">Conflict Date</th>
<th  class="p-2">Host</th>
<th  class="p-2">Host Result</th>
<th  class="p-2">Joiner</th>
<th  class="p-2">Joiner Result</th>
<th  class="p-2">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
if(!$conflicts){
    ?>
<tr>
<td colspan="6" class="text-center">
no data available
</td>
</tr>
    <?php
}
foreach($conflicts as $item){
  $match = $this->db->where('id',$item->match_id)->get('matches')->row();
    $host=$this->db->where('id',$match->host_id)->get('users')->row();
    $joiner=$this->db->where('id',$match->joiner_id)->get('users')->row();
   


    ?>
<tr>

<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                       
                            <div class="fw-bold" style=""> <?=$fn->format($item->created_at)?></div>
                            
                       
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$host->full_name?> 
                            <?=($match->winner_id==$host->id)?'<span class="text-xs fw-bold text-success">(Winner)</span>':''?>
                            <?=($match->looser_id==$host->id)?'<span class="text-xs fw-bold text-danger">(Looser)</span>':''?>
                          </h6>
                            <div class="" style="font-size:11px"><?=$host->mobile_no?></div>
                          </div>
</div>
</td>

<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">
                              <span class="badge badge-xs bg-gradient-success splbtn" data-bs-toggle="modal" data-bs-target="#host<?=$item->id?>">Screenshot</span>
                           
                          </h6>

                      


<!-- Modal -->
<div class="modal fade" id="host<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Host Result</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
      <img src="<?=base_url('assets/images/screenshots/match_'.$match->id.'/'.(($match->host_id==$item->conflicted_user)?$match->conflict_screenshot:$match->screenshot))?>" class="w-100 rounded" />
      
   
      </div>
   
    </div>
  </div>
</div>


                            <div class="" style="font-size:11px"><?=$fn->format($match->host_result_time)?></div>
                          </div>
</div>
</td>


<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=@$joiner->full_name?> 
                            <?=($match->winner_id==$joiner->id)?'<span class="text-xs fw-bold text-success">(Winner)</span>':''?>
                            <?=($match->looser_id==$joiner->id)?'<span class="text-xs fw-bold text-danger">(Looser)</span>':''?>
                          </h6>
                            <div class="" style="font-size:11px"><?=@$joiner->mobile_no??'none'?></div>
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">
                              <span class="badge badge-xs bg-gradient-success splbtn" data-bs-toggle="modal" data-bs-target="#joiner<?=$item->id?>">Screenshot</span>
                           
                          </h6>

                      


<!-- Modal -->
<div class="modal fade" id="joiner<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Joiner Result</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <?php
$js = $match->joiner_id==$item->conflicted_user?$match->conflict_screenshot:$match->screenshot;

        ?>
        <img src="<?=base_url('assets/images/screenshots/match_'.$match->id.'/'.$js)?>" class="w-100 rounded" />
      
   
      </div>
   
    </div>
  </div>
</div>


                            <div class="" style="font-size:11px"><?=$fn->format($match->host_result_time)?></div>
                          </div>
</div>
</td>


<td>
  <?php
if($item->status==1){
  ?>
<span class="btn btn-sm bg-gradient-dark p-1 px-2 mb-1">pending</span>
  <?php
}elseif($item->status==2){
  ?>
<span class="btn btn-sm bg-gradient-success p-1 px-2 mb-1"><i class="fas fa-check-double"></i> resolved</span>
  <?php
}
  ?>

                    
</td>
</tr>
    <?php
}
?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>