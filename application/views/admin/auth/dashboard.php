

  
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">New Users</p>
                    <h5 class="font-weight-bolder mb-0">
                      <?=count($newusers)?>
                      <span class="text-success text-sm font-weight-bolder">Users Joined</span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Deposits</p>
                    <h5 class="font-weight-bolder mb-0">
                    ₹ <?=Admin::amount($depositmoney)?>
                      <span class="text-success text-sm font-weight-bolder"><?=count($deposits)?> Deposits</span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Matches</p>
                    <h5 class="font-weight-bolder mb-0">
                     <?=$matches?>
                      <span class="text-success text-sm font-weight-bolder">finished matches</span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


       


        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              
<?php
if($admin->id>1){
?>
<div class="text-center">
<span href="" class="btn btn-primary">Today (<?=date('d F, Y',time())?>)</span>
</div>
<?php
}else{
?>
<div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Admin Earnings</p>
                    <h5 class="font-weight-bolder mb-0">
                    ₹ <?=Admin::amount($admin_earnings)?>
                      <span class="text-success text-sm font-weight-bolder">
                      Estimated
                      </span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
                </div>
<?php
}
?>
              
            </div>
          </div>
        </div>


      
        <div class="col-xl-6 col-sm-6 mb-xl-0 mt-3 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Withdraws</p>
                    <h5 class="font-weight-bolder mb-0">
                    ₹ <?=number_format(Admin::amount($withdraws),2)?>
                      <span class="text-success text-sm font-weight-bolder"><?=$withdrawsc?> Withdraws , - Withdraw Fee </span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
          <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4 mt-3">
          <div class="card bg-dark text-white">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Wallet Balance (All Users)</p>
                    <h5 class="font-weight-bolder text-white mb-0">
                    ₹ <?=number_format(Admin::amount($fn->getWalletBalanceAll()),2)?>
                      <span class="text-success text-sm font-weight-bolder"> <?=$uc?> Users Wallet</span>
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                  <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
     
 

      <div class="row my-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>New Registered Users</h6>
              
                </div>
                
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Refer By</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Registered On</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Wallet</th>
                    </tr>
                  </thead>
                  <tbody id="i_load_data">
                   
                   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6>Deposits By Users</h6>
            
            </div>
            <div class="card-body p-3">
              <div class="timeline timeline-one-side" id="i_load_data2">

               
                
              </div>
            </div>
          </div>
        </div>
      </div>
     
      
   