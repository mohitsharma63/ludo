<?php
foreach($deposits as $deposit){
    $user = $this->db->where('id',$deposit->user_id)->get('users')->row();
    ?>
<div class="timeline-block mb-3">
                  <span class="timeline-step">
                    <i class="ni ni-credit-card text-warning text-gradient"></i>
                  </span>
                  <div class="timeline-content">
                    <h6 class="text-dark text-sm font-weight-bold mb-0">₹ <?=$fn->amount($deposit->amount)?> Added by <?=$user->mobile_no?></h6>
                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0"><?=$fn->format($deposit->created_at)?></p>
                  </div>
                </div>
    <?php
}
?>