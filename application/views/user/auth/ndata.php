<?php
foreach($notifications as $notification){
    ?>

            <div class="bg-gold p-2 rounded my-3">
<div class="fw-bold d-flex justify-content-between align-items-center">
    <div>
<?= date('d M,Y h:i a', $notification->created_at) ?>
</div>




<?php
if($notification->user>0 && $notification->user==$user->id){
    echo "<span class='badge bg-black small'><i class='bi bi-person-fill-lock'></i> For You</span>";
}else{
    echo "<span class='badge bg-black small'><i class='bi bi-people'></i> For Everyone</span>";
}
?>

</div>
<div class="border border-1 border-dark my-1"></div>
<div class="text-center">
<?=$notification->message?>
</div>


             </div>

    <?php
}
?>