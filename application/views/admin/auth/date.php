 

<div class="d-flex justify-content-between">

<?php
if(!isset($customdate) && $time==1){
  ?>
<a href="" class="btn <?=($time==1)?'btn-primary':'btn-outline-primary'?> showloader">Today (<?=date('d F, Y',time())?>)</a>
  <?php

}elseif(!isset($customdate) && $time==0){
  ?>
<a href="" class="btn <?=($time==0)?'btn-primary':'btn-outline-primary'?> showloader">ALL MATCHES</a>
  <?php
}elseif(isset($customdate) && $bartitle=='Match History'){
?>
<a href="" class="btn <?=($time==0)?'btn-primary':'btn-outline-primary'?> showloader">ALL MATCHES</a>
<?php
}else{
  ?>
<a href="" class="btn <?=($time==1)?'btn-primary':'btn-outline-primary'?> showloader">Today (<?=date('d F, Y',time())?>)</a>
  <?php
}
?>



<?php
if(isset($customdate)){
    
    ?>
<button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#customdate">from <?=date('d F, Y',$customdate->start)?> to <?=date('d F, Y',$customdate->end)?></button>
    <?php
}else{ ?>
    <button href="" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#customdate">Custom Dates</button>
<?php }
?>


<!-- Modal -->
<div class="modal fade" id="customdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Custom Dates</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <?= form_open('', ["class" => "showloader-form"]) ?>
     
    <div class="input-group mt-2">
        <span class="input-group-text" id="basic-addon1">From </span>
        <input type="date" name="start" value="<?=isset($customdate)?date('Y-m-d',$customdate->start):''?>" class="form-control" aria-describedby="basic-addon1" required>
    </div>
   
    <div class="input-group mt-2">
        <span class="input-group-text" id="basic-addon1">To </span>
        <input type="date" name="end" value="<?=isset($customdate)?date('Y-m-d',$customdate->end):''?>" class="form-control" aria-describedby="basic-addon1" required>
    </div>
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Apply Dates</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>
</div>


</div>
<hr class="horizontal dark mt-0">