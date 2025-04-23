<div class="my-4 mx-2">


    <div class="fs-5 fw-bold text-gold"><i class="bi bi-cash-coin"></i> Transactions</div>
    <div class="d-flex justify-content-between gap-2 mt-3 pb-2" style="overflow-x:scroll;scrollbar-width:thin">
        <a href="<?= base_url('user/transactions/all') ?>" class="btn btn-sm <?= $type == 'all' ? 'btn-warning' : 'btn-outline-warning' ?> showloader">All</a>
        <a href="<?= base_url('user/transactions/deposits') ?>" class="btn btn-sm <?= $type == 'deposits' ? 'btn-warning' : 'btn-outline-warning' ?> showloader">Deposits</a>
        <a href="<?= base_url('user/transactions/winnings') ?>" class="btn btn-sm <?= $type == 'winnings' ? 'btn-warning' : 'btn-outline-warning' ?> showloader">Winnings</a>
        <a href="<?= base_url('user/transactions/penalty') ?>" class="btn btn-sm <?= $type == 'penalty' ? 'btn-warning' : 'btn-outline-warning' ?> showloader">Penalty</a>
        <a href="<?= base_url('user/transactions/referrals') ?>" class="btn btn-sm <?= $type == 'referrals' ? 'btn-warning' : 'btn-outline-warning' ?> showloader">Referrals</a>

        <a href="<?= base_url('user/transactions/withdraws') ?>" class="btn btn-sm <?= $type == 'withdraws' ? 'btn-warning' : 'btn-outline-warning' ?> showloader">Withdraws</a>

        <a href="<?= base_url('user/transactions/matches') ?>" class="btn btn-sm <?= $type == 'matches' ? 'btn-warning' : 'btn-outline-warning' ?> showloader">Matches</a>



    </div>

    <div id="i_load_data">

    </div>


</div>