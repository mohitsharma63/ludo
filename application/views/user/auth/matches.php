<div id="activematch">
    <?php
    foreach ($createdmatches as $om) {
        $host = $this->db->where('id', $om->host_id)->get('users')->row();
        $joiner = $this->db->where('id', $om->joiner_id)->get('users')->row();
$jreqs=$this->db->where('match_id',$om->id)->where('status',1)->get('join_reqs')->result();
    ?>
        <div class="rounded bg-gold my-3 overflow-hidden">
            <div>
                <div class="d-flex justify-content-between align-items-center py-2 px-2">
                    <div class="fw-bold">Challenge from @<?= $host->username ?></div>
                    <div>

                        <a href="<?= base_url('user/cancelmatch/' . User::secure('encrypt', $om->id)) ?>" class="btn btn-dark btn-sm showloader">Cancel</a>

                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center py-2 px-2">
                    <div class="fw-bold w-100">
                        <div>Entry Fee</div>
                        <div>₹ <?= $fn->amount($om->amount) ?></div>
                    </div>
                    <div class="w-100 text-center">

                        <img src="<?= base_url('assets/images/loading2.svg') ?>" height="40px" width="40px" />



                    </div>
                    <div class="fw-bold w-100 text-end">
                        <div>Prize</div>
                        <div>₹ <?=$om->prize?></div>
                    </div>
                </div>

<?php
if($jreqs && $om->status==1){
    echo '<div class="border-top border-dark"></div>';
    foreach($jreqs as $r){
        $rj = $this->db->where('id',$r->joiner_id)->get('users')->row();
        ?>
<div class="fw-bold d-flex justify-content-between py-1 bg-dark text-white px-2">

<div>@<?=$rj->username?> requested to join</div>
<div>
    <a href="<?=base_url('user/acceptreq/'.$fn->secure('encrypt',$r->id))?>" class="btn btn-sm btn-light fw-bold p-0 px-2 bg-gold"><i class="bi bi-check2"></i> Accept</a>



</div>

</div>
        <?php
    }
}
?>

            </div>
        </div>
    <?php
    }
    ?>
</div>
<div id="joinedmatch">
    <?php
    foreach ($joinedmatches as $om) {
        $host = $this->db->where('id', $om->host_id)->get('users')->row();
        $joiner = $this->db->where('id', $om->joiner_id)->get('users')->row();

        if ($host->id == $user->id) {
            $player1 = 'You';
            $player2 = '@' . $joiner->username;
        } else {
            $player1 = '@' . $host->username;
            $player2 = 'You';
        }
    ?>
        <div class="rounded bg-black text-gold my-3">
            <div>
                <div class="d-flex justify-content-between align-items-center py-2 px-2">
                    <div class="fw-bold w-100"><?= @$player1 ?></div>
                    <div class="fw-bold w-100 text-center">VS</div>
                    <div class="fw-bold w-100 text-end"><?= @$player2 ?></div>

                </div>

                <div class="d-flex justify-content-between align-items-center py-2 px-2">
                    <div class="fw-bold w-100">
                        <div>Entry Fee</div>
                        <div>₹ <?= $fn->amount($om->amount) ?></div>
                    </div>
                    <div class="w-100 text-center">

                        <a href="<?= base_url('user/openmatch/' . User::secure('encrypt', $om->id)) ?>" class="btn bg-gold fw-bold btn-sm showloader">OPEN</a>



                    </div>
                    <div class="fw-bold w-100 text-end">
                        <div>Prize</div>
                        <div>₹ <?=$om->prize?></div>
                    </div>
                </div>



            </div>
        </div>
    <?php
    }
    ?>
</div>


<div id="openmatches">
    <?php
    foreach ($openmatches as $om) {
        $host = $this->db->where('id', $om->host_id)->get('users')->row();
        $joiner = $this->db->where('id', $om->joiner_id)->get('users')->row();
        $jreq=$this->db->where('match_id',$om->id)->where('joiner_id',$user->id)->get('join_reqs')->row();

    ?>
        <div class="rounded bg-gold my-3">
            <div>
                <div class="d-flex justify-content-between align-items-center py-2 px-2">
                    <div class="fw-bold">Challenge from @<?= $host->username ?></div>
                    <div>

                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center py-2 px-2">
                    <div class="fw-bold w-100">
                        <div>Entry Fee</div>
                        <div>₹ <?= $fn->amount($om->amount) ?></div>
                    </div>
                    <div class="w-100 text-center">
                        <?php
if($jreq && $jreq->status==1){
    ?>
    <a class="btn btn-dark btn-sm disabled"> <img src="<?= base_url('assets/images/loading.svg') ?>" height="20px" width="20px" /> WAIT</a>
    
       <?php
}elseif($jreq && $jreq->status==0){
    ?>
    <a class="btn btn-danger btn-sm disabled"> REJECTED</a>
       <?php 
}else{
    ?>
 <a href="<?= base_url('user/sendjoinreq/' . User::secure('encrypt', $om->id)) ?>" class="btn btn-dark btn-sm showloader">PLAY</a>
    <?php
}
                        ?>
                       
                    </div>
                    <div class="fw-bold w-100 text-end">
                        <div>Prize</div>
                        <div>₹ <?=$om->prize?></div>
                    </div>
                </div>



            </div>
        </div>
    <?php
    }
    ?>
</div>

<div id="runningmatch">
    <?php
    if ($runningmatches || true) {
    ?>
        <div class="fw-bold text-gold mb-2 mt-4"><i class="bi bi-dice-6"></i> Running Matches</div>
    <?php
    }
    ?>

    <?php
    foreach ($runningmatches as $om) {
        $host = $this->db->where('id', $om->host_id)->get('users')->row();
        $joiner = $this->db->where('id', $om->joiner_id)->get('users')->row();


    ?>
        <div class="rounded bg-gold mb-3">
            <div>
                <div class="d-flex justify-content-between align-items-center p-2 border-bottom border-dark" style="font-size:16px;">
                    <div class="fw-bold w-100 small">Entry Fee : ₹ <?= $fn->amount($om->amount) ?></div>

                    <div class="fw-bold w-100 text-end small">Prize : ₹ <?=$om->prize?></div>

                </div>

                <div class="d-flex justify-content-between align-items-center py-2 px-2">
                    <div class="fw-bold text-center">
                        <div><img src="<?= base_url('assets/images/avatars/avatar' . $host->profile . '.png') ?>" height="35px" width="35px" /></div>
                        <div style="font-size:13px;">@<?= $host->username ?></div>
                    </div>
                    <div class="w-100 text-center">


                        <img src="<?= base_url('assets/images/vs.png') ?>" height="40px" width="40px" />


                    </div>
                    <div class="fw-bold text-center">
                        <div><img src="<?= base_url('assets/images/avatars/avatar' . $joiner->profile . '.png') ?>" height="40px" width="40px" /></div>
                        <div style="font-size:13px;">@<?= $joiner->username ?></div>
                    </div>
                </div>



            </div>
        </div>
    <?php
    }
    ?>
    
    
    
    
    
    
    
    
    
</div>