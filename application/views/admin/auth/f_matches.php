<div class="">
          <div class="card h-100">
            <div class="card-header pb-0 px-3">
              <div class="row">
                <div class="">
                  <h6 class="mb-0">User Transaction's</h6>
                </div>
                <div class=" d-flex justify-content-end align-items-center">
                </div>
              </div>
            </div>
            <div class="card-body pt-4 p-3 table-responsive">
             <table class="table">
                <thead>
<tr>
<th class="p-2">Match Id</th>
<th class="p-2">Room Code</th>

<th  class="p-2">Hosted By</th>
<th  class="p-2">Joined By</th>
<th  class="p-2">Amount</th>
<th  class="p-2">Game</th>
<th  class="p-2">Status</th>
<tr>
</thead>
                <tbody>
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
</tbody>
</table>
 </div>
          </div>
        </div>




        <!-- ////// -->
        <!-- <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-exclamation" aria-hidden="true"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Webflow</h6>
                      <span class="text-xs">26 March 2020, at 05:00 AM</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-dark text-sm font-weight-bold">
                    Pending
                  </div>
                </li>


                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-down" aria-hidden="true"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Netflix</h6>
                      <span class="text-xs">27 March 2020, at 12:30 PM</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                    - $ 2,500
                  </div>
                </li>
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                  <div class="d-flex align-items-center">
                    <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up" aria-hidden="true"></i></button>
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm">Apple</h6>
                      <span class="text-xs">27 March 2020, at 04:30 AM</span>
                    </div>
                  </div>
                  <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                    + $ 2,000
                  </div>
                </li> -->