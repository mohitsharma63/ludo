<?php
foreach($items as $item){
  $status[1]='<span class="badge badge-xs bg-gradient-warning">Pending</span>';
  $status[0]='<span class="badge badge-xs bg-gradient-danger">Rejected</span>';
  $status[2]='<span class="badge badge-xs bg-gradient-success">Completed</span>';
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
                    
                      <td class="">
                      <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$item->txnid?></h6>
                            <div class="" style="font-size:11px"><?=$fn->format($item->created_at)?></div>
                        </div>
                      </td>
                      <td class="">
                        
                        
                      <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Transfer : ₹ <?=$fn->amount($item->transfer_amount)?></h6>
                            <div class="" style="font-size:11px">Fee : ₹ <?=$fn->amount($item->transfer_fee)?></div>
                      </div>
                </td>

                <td class="">
                        
                        
                        <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm"> ₹ <?=$fn->amount($item->total_amount)?></h6>
                
                        </div>
                  </td>

                <td class="text-wrap">
                <div class="" style="font-size:11px"><?=$item->data?></div>
                  </td>

             <td class="text-xs fw-bold">

             <?=$status[$item->status]?>

             </td>
          
                    

                      <td class="">
                        <?php
if($item->status==1){
  
  ?>
<div class="d-flex gap-2">



<span class="btn btn-sm btn-success p-1 px-2" data-bs-toggle="modal" data-bs-target="#approve<?=$item->id?>"><i class="fas fa-check"></i> Approve</span>

<!-- Modal -->
<div class="modal fade" id="approve<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Approve Withdraw</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      
      <div class="border rounded p-2 bg-gradient-secondary text-white mb-2">
          <?php
          if($item->method=='bank'){
              ?>
              <h6>Bank Details</h6>
      <div><b>Full Name :</b> <?=@$item->name?></div>
      <div><b>Bank Name :</b> <?=@$item->bank?></div>
      <div><b>IFSC Code :</b> <?=@$item->ifsc_code?></div>
      <div><b>Account No :</b> <?=@$item->account_no?></div>
              <?php
          }else{
              ?>
              <h6>UPI Details</h6>
      <div><b>UPI Id :</b> <?=@$item->upi?></div>
              <?php
          }
          ?>
      
    

      </div>

        <h6>Upload Payment Proof</h6>
      <?= form_open_multipart('admin/approvewithdraw/'.Admin::secure('encrypt',$item->id), ["class" => "showloader-form"]) ?>
 
      <input type="file" id="target" name="screenshot" accept="image/*" class=" input-1 form-control border-gold my-2" placeholder="enter your pincode" required />

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Submit Withdraw Approval</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>
</div>




<span class="btn btn-sm btn-danger p-1 px-2" data-bs-toggle="modal" data-bs-target="#reject<?=$item->id?>"><i class="fas fa-times"></i> Reject</span>

<!-- Modal -->
<div class="modal fade" id="reject<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Reject Withdraw Request</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Enter Reject Reason</h6>
      <?= form_open('admin/rejectwithdraw/'.Admin::secure('encrypt',$item->id), ["class" => "showloader-form"]) ?>
 
    <textarea class="form-control" name="remarks" required></textarea>

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">REJECT withdraw REQUEST</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>
</div>




</div>


  <?php
}elseif($item->status==0){
  ?>
<button type="submit" class="btn btn-sm bg-gradient-dark p-1 px-2">Rejected</button>
  <?php
}elseif($item->status==2){
  ?>
<button type="submit" class="btn btn-sm bg-gradient-dark p-1 px-2" data-bs-toggle="modal" data-bs-target="#aadharb<?=$item->id?>">Approved</button>


<!-- Modal -->
<div class="modal fade" id="aadharb<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment Proof</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="<?=base_url('assets/images/withdraws/'.$item->mobile_no.'/'.$item->screenshot)?>" class="w-100 rounded" />
      
   
      </div>
   
    </div>
  </div>
</div>
  <?php
}
                        ?>

</td>
                    
                    </tr>
                 
    <?php
}
?>