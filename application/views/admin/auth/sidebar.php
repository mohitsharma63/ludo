<?php
    if($admin->permissions){
      $access = explode("#",$admin->permissions);
    }else{
      $access=[];
    }

    
    ?>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="<?=base_url()?> " target="_blank">
        <img src="<?=base_url(SITELOGO)?>" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold"><?=COMPANY_NAME?></span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-100" id="sidenav-collapse-main">
      <ul class="navbar-nav h-100">
        
        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='Dashboard'?'active':''?> showloader" href="<?=base_url('admin')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-shop <?=$bartitle=='Dashboard'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <?php
 if($admin->id==1){
?>
<li class="nav-item">
          <a class="nav-link <?=$bartitle=='Admin Logs'?'active':''?> showloader" href="<?=base_url('admin/logs')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-copy-04 <?=$bartitle=='Admin Logs'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Admin Logs</span>
          </a>
        </li>
<?php
}
        ?>
        
        <?php
if(in_array('p_mu',$access)){
        ?>

        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='Manage Users'?'active':''?> showloader" href="<?=base_url('admin/manageusers')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-02 <?=$bartitle=='Manage Users'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Manage Users</span>
          </a>
        </li>

        <?php
}
        ?>

<?php
if(in_array('p_mkr',$access)){
        ?>
        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='User KYC'?'active':''?> showloader" href="<?=base_url('admin/managekyc')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-badge <?=$bartitle=='User KYC'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">User KYC</span>
          </a>
        </li>
        <?php
}
        ?>
       
       <?php
if(in_array('p_mwr',$access)){
        ?>
        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='User Withdraws'?'active':''?> showloader" href="<?=base_url('admin/withdraws')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-box-2 <?=$bartitle=='User Withdraws'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">User Withdraws</span>
          </a>
        </li>

        <?php
}
        ?>


<?php
if(in_array('p_mpmr',$access)){
        ?>
        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='Pending Results'?'active':''?> showloader" href="<?=base_url('admin/pendingresult')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-folder-17 <?=$bartitle=='Pending Results'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Pending Results</span>
          </a>
        </li>
        <?php
}
        ?>


<?php
if(in_array('p_mcr',$access)){
        ?>
        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='Cancel Requests'?'active':''?> showloader" href="<?=base_url('admin/cancelrequest')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-folder-17 <?=$bartitle=='Cancel Requests'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Cancel Requests</span>
          </a>
        </li>

        <?php
}
        ?>


<?php
if(in_array('p_mc',$access)){
        ?>
        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='Manage Conflicts'?'active':''?> showloader" href="<?=base_url('admin/manageconflicts')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-folder-17 <?=$bartitle=='Manage Conflicts'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Manage Conflicts</span>
          </a>
        </li>

        <?php
}
        ?>

     
<?php
if(in_array('p_mhd',$access)){
        ?>
        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='Match History'?'active':''?> showloader" href="<?=base_url('admin/matchhistory')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-bullet-list-67 <?=$bartitle=='Match History'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Match History</span>
          </a>
        </li>
        <?php
}
        ?>

        <?php
 if($admin->id==1){
?>
 <li class="nav-item">
          <a class="nav-link <?=$bartitle=='Manage Notifications'?'active':''?> showloader" href="<?=base_url('admin/managenotifications')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-notification-70 <?=$bartitle=='Manage Notifications'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Manage Notifications</span>
          </a>
        </li>



        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='Manage Admins'?'active':''?> showloader" href="<?=base_url('admin/manageadmins')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-key-25 <?=$bartitle=='Manage Admins'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Manage Admins</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?=$bartitle=='Configuration'?'active':''?> showloader" href="<?=base_url('admin/config')?>">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-settings-gear-65 <?=$bartitle=='Configuration'?'':'text-dark'?>"></i>

            </div>
            <span class="nav-link-text ms-1">Configuration</span>
          </a>
        </li>
<?php
}
        ?>

       




       
      
      </ul>
    </div>
   
  </aside>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->