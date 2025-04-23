<?php
    if($admin->permissions){
      $access = explode("#",$admin->permissions);
    }else{
      $access=[];
    }
    ?>
<div class=" bg-dark p-2 rounded m-1 d-flex justify-content-between">


<a href="<?=base_url('admin/manageusers')?>" class="<?=in_array('p_mu',$access)?'':'d-none '?>showloader btn btn-light m-0 my-2 mx-1">ONLINE USERS : <span id="onlineusers" class="stat"></span></a>
<a href="<?=base_url('admin/withdraws')?>" class="<?=in_array('p_mwr',$access)?'':'d-none '?>showloader btn btn-light m-0 my-2 mx-1">Withdraws : <span id="withdraws" class="stat"></span></a>
<a href="<?=base_url('admin/manageconflicts')?>" class="<?=in_array('p_mc',$access)?'':'d-none '?>showloader btn btn-light m-0 my-2 mx-1">Conflicts : <span id="conflicts" class="stat"></span></a>
<a href="<?=base_url('admin/cancelrequest')?>" class="<?=in_array('p_mcr',$access)?'':'d-none '?>showloader btn btn-light m-0 my-2 mx-1">Cancel Requests : <span id="cancels" class="stat"></span></a>
<a href="<?=base_url('admin/managekyc')?>" class="<?=in_array('p_mkr',$access)?'':'d-none '?>showloader btn btn-light m-0 my-2 mx-1">KYC requests : <span id="kycs" class="stat"></span></a>
<a href="<?=base_url('admin/matchhistory')?>" class="<?=in_array('p_mhd',$access)?'':'d-none '?>showloader btn btn-light m-0 my-2 mx-1">Active Matches : <span id="activematches" class="stat"></span></a>



</div>

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid d-flex justify-content-between py-1 px-3">
        <nav aria-label="breadcrumb">
      
          <h6 class="font-weight-bolder mb-0"><?=@$bartitle?></h6>
        </nav>
        <div class="collapse justify-content-end navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          
          <ul class="navbar-nav justify-content-end gap-2">
           
            

            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>

         
           
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user cursor-pointer"></i>
                <span class="d-sm-inline d-none"> <?=$admin->full_name?></span>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <!--<li class="mb-2">-->
                <!--  <a class="dropdown-item border-radius-md" href="javascript:;">-->
                <!--   Edit Account-->
                <!--  </a>-->
                <!--</li>-->
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md showloader" href="<?=base_url('admin/logout')?>">
                    Logout
                  </a>
                </li>
               
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid py-4">