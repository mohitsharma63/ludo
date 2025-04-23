
<?php

foreach($items as $item){
 $user=$this->db->where('id',$item->user)->get('users')->row();
    ?>
<tr>
<td>

                            <h6 class="mb-0 text-sm"><?=$fn->format($item->created_at)?></h6>
                        
</td>
<td class="text-wrap">
<?=$item->message?>
</td>
<td>
  <?php
if($user){
?>
<div class="d-flex align-items-center">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=@$user->full_name?> 
                          </h6>
                            <div class="" style="font-size:11px"><?=@$user->mobile_no??'none'?></div>
                          </div>
</div>
<?php
}else{
  ?>
<div class="d-flex align-items-center">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">All Users
                          </h6>
                          
                          </div>
</div>
  <?php
}
  ?>

</td>


<td>
<span class="badge badge-xs bg-gradient-info"> <?=$item->seen_by?></span>
              

                 
</td>
</tr>
    <?php
}
?>


      