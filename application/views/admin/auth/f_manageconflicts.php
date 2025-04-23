<?php

foreach($items as $item){
  $match = $this->db->where('id',$item->match_id)->get('matches')->row();
    $host=$this->db->where('id',$match->host_id)->get('users')->row();
    $joiner=$this->db->where('id',$match->joiner_id)->get('users')->row();
   


    ?>
<tr>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Match #<?=$match->id?></h6>
                            <div class="" style="font-size:11px"><?=$fn->format($match->created_at)?></div>
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$match->room_code?></h6>
                            <div class="" style="font-size:11px">Conflict : <?=$fn->format($item->created_at)?></div>
                            
                       
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
<span class="btn btn-sm btn-primary p-1 px-2 mb-1" data-bs-toggle="modal" data-bs-target="#approve<?=$item->id?>">Resolve</span>

<!-- Modal -->
<div class="modal fade" id="approve<?=$item->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Resolve Conflict</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          
        </button>
      </div>
      <div class="modal-body">
        <h6>Select Winner</h6>
      <?= form_open('admin/resolveconflict/'.Admin::secure('encrypt',$item->id), ["class" => "showloader-form"]) ?>
 
      <select class="form-control" name="winner" required>
      <option value=''>Select User</option>
<option value="<?=$match->host_id?>">Host | <?=$host->full_name .' | '.$host->mobile_no?></option>
<option value="<?=$match->joiner_id?>">Joiner | <?=$joiner->full_name .' | '.$joiner->mobile_no?></option>

      </select>
    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">SUBMIT RESULT & ADD PENALTY</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>
</div>
  <?php
}elseif($item->status==2){
  ?>
<span class="btn btn-sm bg-gradient-dark p-1 px-2 mb-1"><i class="fas fa-check-double"></i> resolved</span>
  <?php
}
  ?>

                    <div><a href="<?=base_url('admin/openmatch/'.$fn->secure('encrypt',$match->id))?>" class="  showloader text-sm">Open Match <i class="fas fa-arrow-circle-right"></i></a></div>
</td>
</tr>
    <?php
}
?>