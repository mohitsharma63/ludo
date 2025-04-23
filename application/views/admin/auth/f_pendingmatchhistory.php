<?php

foreach($items as $item){
    $host=$this->db->where('id',$item->host_id)->get('users')->row();
    $joiner=$this->db->where('id',$item->joiner_id)->get('users')->row();
    $game=$this->db->where('id',$item->game_id)->get('game')->row();


    ?>
<tr>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Match #<?=$item->id?></h6>
                            <div class="" style="font-size:11px"><?=$fn->format($item->created_at)?></div>
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$item->room_code?></h6>
                            <!-- <div class="" style="font-size:11px"><?=$fn->format($item->created_at)?></div> -->
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$host->full_name?> 
                            <?=($item->host_result==1)?'<span class="text-xs fw-bold text-dark">(Submited Win)</span>':''?>
                            <?=($item->host_result==2)?'<span class="text-xs fw-bold text-danger">(Submited Lost)</span>':''?>
                          </h6>
                            <div class="" style="font-size:11px"><?=$host->mobile_no?></div>
                            <?php
if($item->host_result>0){
  ?>
<div class="text-primary" style="font-size:11px">result submitted on <?=$fn->format($item->host_result_time)?></div>
  <?php
}else{?>
<div class="text-danger" style="font-size:11px">result not submitted</div>
<?php
}
                            ?>
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=@$joiner->full_name?> 
                            <?=($item->joiner_result==1)?'<span class="text-xs fw-bold text-dark">(Submited Win)</span>':''?>
                            <?=($item->joiner_result==2)?'<span class="text-xs fw-bold text-danger">(Submited Lost)</span>':''?>
                        
                          </h6>
                            <div class="" style="font-size:11px"><?=@$joiner->mobile_no??'none'?></div>
                            <?php
if($item->joiner_result>0){
  ?>
<div class="text-primary" style="font-size:11px">result submitted on <?=$fn->format($item->joiner_result_time)?></div>
  <?php
}else{?>
<div class="text-danger" style="font-size:11px">result not submitted</div>
<?php
}
                            ?>
                            

                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-1 text-xs">Bet : ₹ <?=$fn->amount($item->amount)?> </h6>
                            <h6 class="mb-0 text-xs">Prize : ₹ <?=$fn->amount($item->prize)?> </h6>

                          
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$game->game_name?></h6>
                            <div class="" style="font-size:11px">( ₹ <?=$fn->amount($game->min_amount)?> - ₹ <?=$fn->amount($game->max_amount)?> )</div>
                          </div>
</div>
</td>
<td>

                   

                    <span class="btn btn-sm btn-primary p-1 px-2 mb-1" data-bs-toggle="modal" data-bs-target="#approve<?=$item->id?>">Submit Result</span>

<!-- Modal -->
<div class="modal fade" id="approve<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Submit Result</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          
        </button>
      </div>
      <div class="modal-body">
        <h6>Select Winner</h6>
      <?= form_open('admin/submitresult/'.Admin::secure('encrypt',$item->id), ["class" => "showloader-form"]) ?>
 
      <select class="form-control" name="winner" required>
      <option value=''>Select User</option>
<option value="<?=$item->host_id?>">Host | <?=$host->full_name .' | '.$host->mobile_no?></option>
<option value="<?=$item->joiner_id?>">Joiner | <?=$joiner->full_name .' | '.$joiner->mobile_no?></option>

      </select>
    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">SUBMIT RESULT & ADD PENALTY</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>
</div>
                   
                   

                    <div><a href="<?=base_url('admin/openmatch/'.$fn->secure('encrypt',$item->id))?>" class=" mt-1 showloader text-sm">Open Match <i class="fas fa-arrow-circle-right"></i></a></div>
</td>
</tr>
    <?php
}
?>