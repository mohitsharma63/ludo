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
                         
                            
                       
                          </div>
</div>
</td>
<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=$host->full_name?> 
                            <?=($item->user_id==$host->id)?'<span class="text-xs fw-bold text-success"><i class="fas fa-record-vinyl"></i></span>':''?>
                           
                          </h6>
                            <div class="" style="font-size:11px"><?=$host->mobile_no?></div>
                          </div>
</div>
</td>



<td>
<div class="d-flex align-items-center px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?=@$joiner->full_name?> 
                            <?=($item->user_id==$joiner->id)?'<span class="text-xs fw-bold text-success"><i class="fas fa-record-vinyl"></i></span>':''?>
                          </h6>
                            <div class="" style="font-size:11px"><?=@$joiner->mobile_no??'none'?></div>
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

<td>
  <?php
if($item->status==1){
  ?>
<div class="d-flex gap-2">

<?= form_open('admin/approvecancel/'.Admin::secure('encrypt',$item->id), ["class" => "showloader-form"]) ?>
<button type="submit" class="btn btn-sm btn-success p-1 px-2"><i class="fas fa-check"></i> Accept</button>
<?=form_close()?>

<?= form_open('admin/rejectcancel/'.Admin::secure('encrypt',$item->id), ["class" => "showloader-form"]) ?>
<button type="submit" class="btn btn-sm btn-danger p-1 px-2"><i class="fas fa-times"></i> Reject</button>
<?=form_close()?>

</div>
  <?php
}elseif($item->status==2){
  ?>

  <?php
}elseif($item->status==0){
  ?>

  <?php
}
  ?>

                    <div><a href="<?=base_url('admin/openmatch/'.$fn->secure('encrypt',$match->id))?>" class="  showloader text-sm">Open Match <i class="fas fa-arrow-circle-right"></i></a></div>
</td>
</tr>
    <?php
}
?>