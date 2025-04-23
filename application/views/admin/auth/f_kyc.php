<?php
foreach($items as $item){
$kyc=$item;
  if(!$kyc) $kyc=404;
  else $kyc=$kyc->status;
  $kycstatus[1]='<span class="badge badge-xs bg-gradient-warning">Submitted</span>';
  $kycstatus[0]='<span class="badge badge-xs bg-gradient-danger">Rejected</span>';
  $kycstatus[2]='<span class="badge badge-xs bg-gradient-success">Completed</span>';
  $kycstatus[404]='<span class="badge badge-xs bg-gradient-info">Not Submitted</span>';



    ?>
   <tr>
   <td>
                        <div class="d-flex align-items-center px-2 py-1">
                          <div>
                            <img src="<?=base_url('assets/images/avatars/avatar'.$item->profile.'.png')?>" class="avatar avatar-sm me-2" alt="xd">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$item->full_name?></h6>
                            <div class="" style="font-size:11px"><?=$item->mobile_no?></div>
                          </div>
                        </div>
                      </td>
                    
                      <td class="text-wrap">
                      <div class="d-flex align-items-center">
                          <span class="me-2 text-xs font-weight-bold"><?=$kycstatus[$kyc]?></span>
                        
                          </div>
                        </div>
                        
                      </td>
                      <td class="text-wrap">
                        
                        
                      <span class="me-2 text-xs font-weight-bold"><?=$item->remarks?></span>
                </td>

                <td class="">
                        
                        
                        <span class="me-2 text-xs font-weight-bold"><?=$item->aadhar_no?></span><br>
                        

<span class="btn p-0 p-1 text-xs bg-gradient-info rounded font-weight-bold rounded text-white" data-bs-toggle="modal" data-bs-target="#aadharf<?=$item->id?>">Front</span>

<!-- Modal -->
<div class="modal fade" id="aadharf<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aadhar Front</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="<?=base_url('assets/images/kyc/'.$item->mobile_no.'/'.$item->aadhar_front)?>" class="w-100 rounded" />

   
      </div>
   
    </div>
  </div>
</div>

  <span class="btn p-0 p-1 text-xs bg-gradient-info rounded font-weight-bold rounded text-white" data-bs-toggle="modal" data-bs-target="#aadharb<?=$item->id?>">Back</span>

<!-- Modal -->
<div class="modal fade" id="aadharb<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aadhar Back</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="<?=base_url('assets/images/kyc/'.$item->mobile_no.'/'.$item->aadhar_back)?>" class="w-100 rounded" />
      
   
      </div>
   
    </div>
  </div>
</div>
                  </td>

                <td class="text-xs fw-bold">
<?=$fn->format($item->created_at)?>
</td>
          
                    

                      <td class="">
                        <?php
if($item->status==1){
  ?>
<div class="d-flex gap-2">

<?= form_open('admin/approvekyc/'.Admin::secure('encrypt',$item->user_id), ["class" => "showloader-form"]) ?>
<button type="submit" class="btn btn-sm btn-success p-1 px-2"><i class="fas fa-check"></i> Approve</button>
<?=form_close()?>




<span class="btn btn-sm btn-danger p-1 px-2" data-bs-toggle="modal" data-bs-target="#reject<?=$item->id?>"><i class="fas fa-times"></i> Reject</span>

<!-- Modal -->
<div class="modal fade" id="reject<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reject KYC</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Enter Reject Reason</h6>
      <?= form_open('admin/rejectkyc/'.Admin::secure('encrypt',$item->user_id), ["class" => "showloader-form"]) ?>
 
    <textarea class="form-control" name="remarks" required></textarea>

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">REJECT KYC REQUEST</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>

</div>
  <?php
}elseif($item->status==0){
  ?>
<button type="submit" class="btn btn-sm bg-gradient-dark p-1 px-2"> KYC rejected</button>
  <?php
}elseif($item->status==2){
  ?>
<button type="submit" class="btn btn-sm bg-gradient-dark p-1 px-2"> KYC Approved</button>
  <?php
}
                        ?>

</td>
                    
                    </tr>
                 
    <?php
}
?>