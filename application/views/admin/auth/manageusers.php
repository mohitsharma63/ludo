<?php
    if($admin->permissions){
      $access = explode("#",$admin->permissions);
    }else{
      $access=[];
    }

    if(!in_array('p_mu',$access)) redirect(base_url('admin'));
    ?>
<div>
<?= form_open('', ["class" => "showloader-form"]) ?>

    <div class="d-flex gap-2">
        <div class="w-100">
      <input type="number" name="mobileno" class="form-control" value="<?=@$keyword?>" placeholder="mobile no" required>
</div>
      <button type="submit" class="btn btn-primary">FIND</button>
</div>

<?= form_close()?>
</div>
<hr class="horizontal dark mt-0">
<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>All Registered Users</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Refer by</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">KYC Status</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Wallet</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Joined On</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Action</th>
                    </tr>
                  </thead>
                  <tbody id="i_load_data">
                 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>