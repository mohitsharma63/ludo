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
<th class="p-2">Txn</th>
<th  class="p-2">Txn Id</th>
<th  class="p-2">Type</th>
<th  class="p-2">Amount</th>
<th  class="p-2">Status</th>
<tr>
</thead>
                <tbody>
<?php
foreach($items as $item){
    
    ?>
      
      <tr>
        <td>
                  <div class="d-flex align-items-center">
                    <?=$item->status==1?' <button class="btn btn-icon-only btn-rounded btn-outline-dark mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-exclamation"></i></button>':''?>

                    <?=$item->status==0?' <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-times"></i></button>':''?>

                    <?=$item->status==2?' <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-check"></i></button>':''?>

                    <?=$item->status==3?' <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-times"></i></button>':''?>
                   
                    <div class="d-flex flex-column">
                      <h6 class="mb-1 text-dark text-sm"><?=$item->remarks?></h6>
                      <span class="text-xs"><?=$fn->format($item->created_at)?></span>
                    </div>
                  </div>
</td>
<td>
    <?=$item->txnid?>
</td>
<td>
    <?=$item->type?>
</td>
<td class="">
 <?php
 if($item->type=='CREDIT'){
    ?>
<div class="d-flex align-items-center text-success  text-sm font-weight-bold">
                    + <?=$fn->amount($item->amount)?> ₹ 
                  </div>
    <?php
 }else{
    ?>
<div class="d-flex align-items-center text-danger  text-sm font-weight-bold">
                    - <?=$fn->amount($item->amount)?> ₹ 
                  </div>
    <?php
 }
 ?>

</td>
<td>
<div class="text-dark text-sm font-weight-bold">
                    <?=$item->status==1?'<span class="badge badge-xs bg-gradient-warning">Pending</span>':''?>
                    <?=$item->status==0?'<span class="badge badge-xs bg-gradient-danger">Failed</span>':''?>
                    <?=$item->status==2?'<span class="badge badge-xs bg-gradient-success">Successfull</span>':''?>
                    <?=$item->status==3?'<span class="badge badge-xs bg-gradient-danger">Cancelled</span>':''?>
                  </div>
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