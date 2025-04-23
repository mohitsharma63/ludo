
<?php
$permissions=$fn->getPermissions();


?>

<div>
<!-- add new notification -->




<hr class="horizontal dark mt-0">
<div class="row">
        <div class="col-12">

          <div class="card border mb-4">
            <div class="card-header pb-0 px-3">
              <h6 class="text-primary"> <i class="ni ni-settings-gear-65"></i> Super Admin Credentials</h6>
            </div>
            <div class="card-body px-3 pt-0 pb-2">
            <?= form_open('admin/updatesuperadmin', ["class" => "showloader-form"]) ?>
      <h6 class="m-0">Admin Name</h6>
      <input type="text" name="full_name" value="<?=$admin->full_name?>" class="form-control" required>
      <h6 class="m-0 mt-2">Admin Email</h6>
      <input type="email" name="email_id" value="<?=$admin->email_id?>" class="form-control" required>

      <h6 class="m-0 mt-2">Admin Password</h6>
      <input type="text" name="password" value="<?=$fn->secure('decrypt',$admin->password)?>" class="form-control" required>

      

  

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Update Super Admin</button>
</div>

      <?= form_close() ?>
            </div>
          </div>


          <div class="card border mb-4">
            <div class="card-header pb-0 px-3">
              <h6 class="text-primary"><i class="ni ni-settings-gear-65"></i> Withdraw Setting</h6>
            </div>
            <div class="card-body px-3 pt-0 pb-2">
            <?= form_open('admin/updateconfig', ["class" => "showloader-form"]) ?>
      <h6 class="m-0">Minimum Withdraw (₹)</h6>
      <input type="text" name="min_withdraw" value="<?=$config->min_withdraw?>" class="form-control" required>

      <h6 class="m-0">Withdraw Fee (%)</h6>
      <input type="text" name="withdraw_charge" value="<?=$config->withdraw_charge?>" class="form-control" required>
     
   
  

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Update Withdraw Config</button>
</div>

      <?= form_close() ?>
            </div>
          </div>


          <div class="card border mb-4">
            <div class="card-header pb-0 px-3">
              <h6 class="text-primary"><i class="ni ni-settings-gear-65"></i> Reward Setting</h6>
            </div>
            <div class="card-body px-3 pt-0 pb-2">
            <?= form_open('admin/updateconfig', ["class" => "showloader-form"]) ?>
      <h6 class="m-0">Winner Reward (%)</h6>
      <input type="text" name="reward" value="<?=$config->reward?>" class="form-control" required>

      <h6 class="m-0">Referral Bonus (%)</h6>
      <input type="text" name="referral_bonus" value="<?=$config->referral_bonus?>" class="form-control" required>
     
   
  

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Update Reward Config</button>
</div>

      <?= form_close() ?>
            </div>
          </div>



          <div class="card border mb-4">
            <div class="card-header pb-0 px-3">
              <h6 class="text-primary"><i class="ni ni-settings-gear-65"></i> Support & Social Media Config</h6>
            </div>
            <div class="card-body px-3 pt-0 pb-2">
            <?= form_open('admin/updateconfig', ["class" => "showloader-form"]) ?>
      <h6 class="m-0">Whatsapp</h6>
      <input type="text" name="whatsapp" value="<?=$config->whatsapp?>" class="form-control" required>

      <h6 class="m-0">Instagram</h6>
      <input type="text" name="instagram" value="<?=$config->instagram?>" class="form-control" required>

      <h6 class="m-0">Youtube</h6>
      <input type="text" name="youtube" value="<?=$config->youtube?>" class="form-control" required>

      <h6 class="m-0">Email</h6>
      <input type="email" name="email" value="<?=$config->email?>" class="form-control" required>
     
   
     
   
  

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Update Support Config</button>
</div>

      <?= form_close() ?>

            </div>
          </div>





          <div class="card border mb-4">
            <div class="card-header pb-0 px-3">
              <h6 class="text-primary"><i class="ni ni-settings-gear-65"></i> Fast2SMS Config</h6>
            </div>
            <div class="card-body px-3 pt-0 pb-2">
            <?= form_open('admin/updateconfig', ["class" => "showloader-form"]) ?>
      <h6 class="m-0">Fast2SMS Api Key</h6>
      <input type="text" name="otp_api" value="<?=$config->otp_api?>" class="form-control" required>

     
   
     
   
  

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Update Fast2SMS Config</button>
</div>

      <?= form_close() ?>
            </div>
          </div>


          <div class="card border mb-4">
            <div class="card-header pb-0 px-3">
              <h6 class="text-primary"><i class="ni ni-settings-gear-65"></i> Paytm Business Config</h6>
            </div>
            <div class="card-body px-3 pt-0 pb-2">
            <?= form_open('admin/updateconfig', ["class" => "showloader-form"]) ?>
      <h6 class="m-0">Merchant Id</h6>
      <input type="text" name="pb_mid" value="<?=$config->pb_mid?>" class="form-control" required>

      <h6 class="m-0">VPA Address</h6>
      <input type="text" name="pb_vpa" value="<?=$config->pb_vpa?>" class="form-control" required>
     
   
  

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Update Paytm Business Config</button>
</div>

      <?= form_close() ?>
            </div>
          </div>









        </div>
      </div>