<?php
         foreach($users as $user){
            $refer=null;
            if($user->refer_by){
                $refer=$this->db->where('referral_code',$user->refer_by)->get('users')->row();
            }
            ?>
 <tr>
                      <td>
                        <div class="d-flex align-items-center px-2 py-1">
                          <div>
                            <img src="<?=base_url('assets/images/avatars/avatar'.$user->profile.'.png')?>" class="avatar avatar-sm me-2" alt="xd">
                          </div>
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$user->full_name?></h6>
                            <div class="" style="font-size:11px"><?=$user->mobile_no?></div>
                          </div>
                        </div>
                      </td>
                      <td>
                      <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=@$refer->full_name?></h6>
                            <div class="" style="font-size:11px"><?=@$refer->mobile_no?></div>
                            <h6 class="" style="font-size:11px"><?=$refer?'':'no referral'?></h6>

                          </div>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> <?=$fn->format($user->created_at)?> </span>
                      </td>
                      <td class="text-center">
                        
                              <span class="text-xs font-weight-bold">₹ <?=$fn->getWalletBalance($user->id)?></span>
                            
                      </td>
                    </tr>
            <?php
         }
?>