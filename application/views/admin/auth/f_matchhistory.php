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
                       
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$host->full_name?> 
                            <?=($item->winner_id==$host->id)?'<span class="text-xs fw-bold text-success">(Winner)</span>':''?>
                            <?=($item->looser_id==$host->id)?'<span class="text-xs fw-bold text-danger">(Looser)</span>':''?>
                          </h6>
                            <div class="" style="font-size:11px"><?=$host->mobile_no?></div>
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=@$joiner->full_name?> 
                            <?=($joiner && $item->winner_id==$joiner->id)?'<span class="text-xs fw-bold text-success">(Winner)</span>':''?>
                            <?=($joiner && $item->looser_id==$joiner->id)?'<span class="text-xs fw-bold text-danger">(Looser)</span>':''?>
                          </h6>
                            <div class="" style="font-size:11px"><?=@$joiner->mobile_no??'none'?></div>
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
<?=$item->status==1?'<span class="badge badge-xs bg-gradient-success">Open</span>':''?>
                    <?=$item->status==2?'<span class="badge badge-xs bg-gradient-success">Active</span>':''?>

                   
                    <?=$item->status==3?'<span class="badge badge-xs bg-gradient-danger">Cancelled</span>':''?>
                    <?=$item->status==4?'<span class="badge badge-xs bg-gradient-success">Finished</span>':''?>

                    <div><a href="<?=base_url('admin/openmatch/'.$fn->secure('encrypt',$item->id))?>" class=" mt-1 showloader text-sm">Open Match <i class="fas fa-arrow-circle-right"></i></a></div>
</td>
</tr>
    <?php
}
?>