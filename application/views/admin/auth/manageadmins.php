
<?php
$permissions=$fn->getPermissions();


?>

<div>
<!-- add new notification -->
 
<div  class="text-end">
<span class="badge badge-sm bg-gradient-primary splbtn" data-bs-toggle="modal" data-bs-target="#sendnotification"><i class="ni ni-circle-08"></i> Add Admin</span>
</div>


<!-- Modal -->
<div class="modal fade" id="sendnotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Admin</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <?= form_open('admin/addnewadmin', ["class" => "showloader-form"]) ?>
      <h6 class="m-0">Admin Name</h6>
      <input type="text" name="full_name" class="form-control" required>
      <h6 class="m-0 mt-2">Admin Email</h6>
      <input type="email" name="email_id" class="form-control" required>

      <h6 class="m-0 mt-2">Admin Password</h6>
      <input type="text" name="password" class="form-control" required>

      <h6 class="m-0 mt-2">Admin Status</h6>
      <select name="status" class="form-control">
        <option value="1">Active</option>
        <option value="0">Inactive</option>

      </select>

      <h6 class="m-0 mt-2">Permissions</h6>
      <div class="d-flex flex-wrap gap-3">
      <?php
foreach($permissions as $key=>$permission){
    ?>
 <div class="form-check border px-3 rounded rounded-4">
  <input class="form-check-input" name="permission[]" type="checkbox" value="<?=$key?>" id="<?=$key?>">
  <label class="form-check-label" for="<?=$key?>">
    <?=$permission?>
  </label>
</div>
    <?php
}
      ?>
     </div>
    

  

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Add Admin</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>

</div>
<hr class="horizontal dark mt-0">
<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Admin List</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Admin</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Permissions</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                    </tr>
                  </thead>
                  <tbody >
                 <?php
foreach($admins as $auser){
    ?>
<tr>
<td class="align-top">
    <div class="fw-bold"><?=$auser->full_name?></div>
    <div class="small"><?=$auser->email_id?></div>

</td>
<td class="text-wrap">
    <?php
    if($auser->permissions){

    
$pms = explode('#',$auser->permissions);
foreach($pms as $pm){
    ?>
<button class="p-0 bg-primary py-1 text-xs rounded rounded-4 border-0 text-white px-2 my-1"><i class="ni ni-key-25"></i> <?=$permissions[$pm]?></button>
    <?php
}}
    ?>
</td>
<td class="align-top">
    <?php
if($auser->status){
?>
<span class="badge bg-gradient-success">Active</span>
<?php
}else{
?>
<span class="badge bg-gradient-secondary">Inactive</span>
<?php
}
    ?>
    <div class="text-xs mt-1">last updated at <?=$fn->format($auser->updated_at)?></div>
</td>
<td class="align-top">
<button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#sendnotification<?=$auser->id?>">Edit</button>


<!-- Modal -->
<div class="modal fade" id="sendnotification<?=$auser->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Admin : <?=$auser->email_id?></h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <?= form_open('admin/updateadmin/'.$fn->secure('encrypt',$auser->id), ["class" => "showloader-form"]) ?>
      <h6 class="m-0">Admin Name</h6>
      <input type="text" name="full_name" value="<?=$auser->full_name?>" class="form-control" required>
      <h6 class="m-0 mt-2">Admin Email</h6>
      <input type="email" name="email_id" value="<?=$auser->email_id?>" class="form-control" required>

      <h6 class="m-0 mt-2">Admin Password</h6>
      <input type="text" name="password" value="<?=$fn->secure('decrypt',$auser->password)?>" class="form-control" required>

      <h6 class="m-0 mt-2">Admin Status</h6>
      <select name="status" class="form-control">
        <option value="1" <?=$auser->status==1?'selected':''?>>Active</option>
        <option value="0" <?=$auser->status==0?'selected':''?>>Inactive</option>

      </select>

      <h6 class="m-0 mt-2">Permissions</h6>
      <div class="d-flex flex-wrap gap-3">
      <?php
      $ps=array();
      if($auser->permissions){
        $ps = explode("#",$auser->permissions);
      }
foreach($permissions as $key=>$permission){
    ?>
 <div class="form-check border px-3 rounded rounded-4">
  <input class="form-check-input" name="permission[]" type="checkbox" value="<?=$key?>" id="<?=$key?><?=$auser->id?>" <?=in_array($key,$ps)?'checked':''?>>
  <label class="form-check-label" for="<?=$key?><?=$auser->id?>">
    <?=$permission?>
  </label>
</div>
    <?php
}
      ?>
     </div>
    

  

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Update Admin</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>
  </div>



<a href="<?=base_url('admin/deleteadmin/'.$fn->secure('encrypt',$auser->id))?>" class="showloader btn btn-sm btn-danger">Delete</a>

</td>

</tr>
    <?php
}
                 ?>
                  </tbody>
                </table>

                <?php
if(!$admins) echo '<div class="text-center py-3 text-warning">no data available</div>';
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>