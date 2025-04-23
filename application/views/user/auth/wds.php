<?php
foreach ($txns as $txn) {
    
?>
    <div class="bg-gold rounded px-2 pt-1 my-3">
        <div class=" d-flex justify-content-between mb-1">
            <div class="d-flex gap-2 align-items-center">
                <img src="<?= base_url('assets/images/txn.png') ?>" class="" height="34px" />
                <div>
                <div class="fw-bold"> <?= $txn->txnid ?></div>
                    <div class="small">Amount : ₹<?= $fn->amount($txn->transfer_amount) ?> | Fee : ₹<?= $fn->amount($txn->transfer_fee) ?></div>
                    
                </div>
            </div>

            <div>
            <div class="fw-bold fs-5 vertical-align-center text-end"> ₹<?= $fn->amount($txn->total_amount) ?></div>
<div class="text-end"> 
    <?=$txn->status==1?'<span class="text-primary opacity-75 fw-bold small">pending</span>':''?>
    <?=$txn->status==2?'<span class="text-success opacity-75 fw-bold small">success</span>':''?>
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