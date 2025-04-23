<?php
foreach ($txns as $txn) {
    if($txn->tag=='DEPOSIT' && $txn->status==1){
        $fn->checkstatus($txn->txnid);
    }
?>
    <div class="bg-gold rounded px-2 pt-1 my-3">
        <div class=" d-flex justify-content-between mb-1">
            <div class="d-flex gap-2 align-items-center">
                <img src="<?= base_url('assets/images/txn.png') ?>" class="" height="34px" />
                <div>
                    <div class="fw-bold"><?= $txn->remarks ?></div>
                    <div> <?= $txn->txnid ?></div>
                </div>
            </div>

            <div>
            <div class="fw-bold fs-5 vertical-align-center text-end"><?= $txn->type == 'CREDIT' ? '+' : '-' ?> ₹<?= $fn->amount($txn->amount) ?></div>
<div class="text-end"> 
    <?=$txn->status==1?'<span class="text-primary opacity-75 fw-bold small">pending</span>':''?>
    <?=$txn->status==2?'<span class="text-success opacity-75 fw-bold small">success</span>':''?>
    <?=$txn->status==3?'<span class="text-danger opacity-75 fw-bold small">canceled</span>':''?>
    <?=$txn->status==0?'<span class="text-danger opacity-75 fw-bold small">failed</span>':''?>

</div>
        </div>
        </div>
        <div class="small text-center border-top border-dark opacity-75">
            <?= date('d M,Y h:i a', $txn->created_at) ?> 
           
        </div>
    </div>
<?php
}
?>