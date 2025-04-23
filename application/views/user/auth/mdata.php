<?php
    foreach ($matches as $om) {
        $match=$om;
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
        <div class="rounded bg-gold mb-3">
        <div>
            <div class="d-flex justify-content-between align-items-center p-2 border-bottom border-dark" style="font-size:16px;">
                <div class="fw-bold w-100 small">Entry Fee : ₹ <?= $fn->amount($match->amount) ?></div>

                <div class="fw-bold w-100 text-end small">Prize : ₹ <?= $match->prize ?></div>

            </div>

            <div class="d-flex justify-content-between align-items-center py-2 px-2">
                <div class="fw-bold text-center">
                    <div><img src="<?= base_url('assets/images/avatars/avatar' . $host->profile . '.png') ?>" height="35px" width="35px" /></div>
                    <div style="font-size:13px;"><?= $player1 ?></div>
                </div>
                <div class="w-100 text-center">


                    <img src="<?= base_url('assets/images/vs.png') ?>" height="40px" width="40px" />


                </div>
                <div class="fw-bold text-center">
                    <div><img src="<?= base_url('assets/images/avatars/avatar' . $joiner->profile . '.png') ?>" height="40px" width="40px" /></div>
                    <div style="font-size:13px;"><?= $player2 ?></div>
                </div>
            </div>



        </div>
        <div class="border border-1 border-dark my-1"></div>
        <div class="d-flex justify-content-between align-items-center fw-bold px-2 pb-1 small">

        <div><?= date('d M,Y h:i a', $match->created_at) ?></div>
        <div>
            <?php
if($match->status==4){
if($match->winner_id==$user->id){
    echo "WON";
}else{
    echo "LOST";

}
}else{
echo "<a href='".base_url('user/openmatch/' . User::secure('encrypt', $om->id))."' class='text-decoration-none showloader text-warning badge bg-black px-2 py-1'>Open <i class='bi bi-chevron-right'></i></a>";
}
            ?>
        </div>

    </div>


    </div>
    <?php
    }
    ?>