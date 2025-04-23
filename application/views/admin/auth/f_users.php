<?php
foreach($items as $item){
  $refer=null;
  if($item->refer_by){
      $refer=$this->db->where('referral_code',$item->refer_by)->get('users')->row();
  }

  $kyc=$this->db->where('user_id',$item->id)->get('kyc')->row();
  if(!$kyc) $kyc=404;
  else $kyc=$kyc->status;
  $kycstatus[1]='Submitted';
  $kycstatus[0]='Rejected';
  $kycstatus[2]='Completed';
  $kycstatus[404]='Not Submitted';



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
                      <td>
                      <div class="d-flex flex-column">
                            <h6 class="mb-0 text-sm"><?=@$refer->full_name?></h6>
                            <div class="" style="font-size:11px"><?=@$refer->mobile_no?></div>
                            <h6 class="" style="font-size:11px"><?=$refer?'':'no referral'?></h6>

                          </div>
                      </td>
                      <td class="text-wrap">
                      <div class="d-flex align-items-center">
                          <span class="me-2 text-xs font-weight-bold"><?=$kycstatus[$kyc]?></span>
                        
                          </div>
                        </div>
                        
                      </td>
                      <td class="">
                        
                        <span class="text-xs font-weight-bold">₹ <?=$fn->getWalletBalance($item->id)?></span>
                      
                </td>
                <td class="">
<?php
if($item->online==1){
  ?>
<span class="badge badge-sm bg-gradient-success">Online</span>
  <?php
}else{
  ?>
<span class="badge badge-sm bg-gradient-secondary">Offline</span>
  <?php
}
?>
</td>
                      <td class="align-middle text-center">
                        <div class="d-flex align-items-center justify-content-center">
                          <span class="me-2 text-xs font-weight-bold"><?=$fn->format($item->created_at)?></span>
                        
                          </div>
                        </div>
                      </td>

                      <td class="text-center">
<div>
<a href="<?=base_url('admin/openuser/'.Admin::secure('encrypt',$item->id))?>" class="showloader btn btn-sm btn-primary">OPEN USER</a>
</div>
</td>
                    
                    </tr>
                 
    <?php
}
?>