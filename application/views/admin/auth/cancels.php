<?php
    if($admin->permissions){
      $access = explode("#",$admin->permissions);
    }else{
      $access=[];
    }
    if(!in_array('p_mcr',$access)) redirect(base_url('admin'));
    
    ?>


<div>
<?= form_open('', ["class" => "showloader-form"]) ?>

    <div class="d-flex gap-2">
        <div class="w-100">
      <input type="text" name="mobileno" class="form-control" value="<?=@$keyword?>" placeholder="match id" required>
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
              <h6>Cancel Requests</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                  <tr>
<th class="p-2">Match Id</th>
<th class="p-2">Room Code</th>
<th  class="p-2">Host</th>
<th  class="p-2">Joiner</th>
<th  class="p-2">Reason</th>
<th  class="p-2">Status</th>
<th  class="p-2">Action</th>
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


