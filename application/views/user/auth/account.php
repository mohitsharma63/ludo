<div class="d-flex justify-content-center my-3">
    <div class="position-relative" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#avatars">

        <img src="<?= base_url('assets/images/avatars/avatar' . $user->profile . '.png') ?>" class="rounded-circle ac-profile" height="80px" width="80px" />
        <span class="position-absolute bottom-0 start-50 translate-bottom bg-gold rounded-circle p-1 border d-flex justify-content-center align-items-center" style="width:22px;height:22px;font-size:13px;margin-left:10px;margin-bottom:-1px">
            <i class="bi bi-pencil-square"></i>
        </span>

    </div>
</div>

<div class="modal fade" id="avatars" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-2 border-dark bg-gold">
                <h1 class="modal-title fs-5 fw-bold text-dark text-center w-100" id="exampleModalLabel">AVATARS</h1>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-gold">
                <div class="d-flex gap-3 flex-wrap justify-content-center">
                    <?php
                    for ($i = 1; $i <= 20; $i++) {
                    ?>
                        <a href="<?= base_url('user/updateprofile/' . $i) ?>" class="showloader"><img src="<?=base_url("assets/images/avatars/avatar".$i.".png")?>" width="60px" height="60px" class="border border-dark rounded-circle"></a>
                    <?php
                    }
                    ?>

                </div>

            </div>

        </div>
    </div>
</div>

<div class=" mx-3">

    <?= form_open('user/updatename', ["class" => "ajaxform"]) ?>
    <div class="input-group mb-3">
        <input type="text" class="input-1 form-control border-gold text-start" placeholder="full name" value="<?= $user->full_name ?>" name="full_name" aria-label="Username" aria-describedby="basic-addon1" required>
        <button type="submit" class="input-group-text btn btn-warning gold-btn" id="basic-addon1"><i class="bi bi-check-circle"></i></button>
    </div>
    <?= form_close() ?>

    <?= form_open('user/updateusername', ["class" => "ajaxform"]) ?>
    <div class="input-group mb-3">
        <input type="text" class="input-1 form-control border-gold text-start" placeholder="username" value="<?= $user->username ?>" name="username" aria-label="Username" aria-describedby="basic-addon1" required>
        <button type="submit" class="input-group-text btn btn-warning gold-btn" id="basic-addon1"><i class="bi bi-check-circle"></i></button>
    </div>
    <?= form_close() ?>

    <div class="bg-gold p-3 rounded">
        <div class="fw-bold d-flex justify-content-between align-items-center">
            <div><i class="bi bi-telephone"></i> Mobile No</div>
            <div><?= $user->mobile_no ?></div>
        </div>
        <div class="border border-1 border-dark my-1"></div>
        <div class="fw-bold d-flex justify-content-between align-items-center">
            <div><i class="bi bi-fingerprint"></i> KYC</div>

            <?php
            if ($kyc && $kyc->status == 1) {
            ?>
                <button class="btn btn-sm btn-dark" disabled><i class="bi bi-hourglass-split"></i> Submitted</button>
            <?php
            } elseif ($kyc && $kyc->status == 2) {
            ?>
                <span> <i class="bi bi-patch-check-fill"></i> Verified</span>
            <?php
            } else { ?>
                <a href="<?= base_url('user/kyc') ?>" class="showloader btn btn-sm btn-dark">Submit KYC <i class="bi bi-arrow-right-circle"></i></a>
            <?php }
            ?>

        </div>
        <div class="small text-dark mt-1 opacity-75" style="font-size:13px">
            <?php
            if ($kyc && $kyc->status == 0) {
            ?>
                <i class="bi bi-info-circle"></i> previous kyc rejected because <?= $kyc->remarks ?>
            <?php
            }
            ?>
        </div>
    </div>


    <div class="bg-gold p-3 rounded my-3 d-flex flex-column gap-2">
        <div class="fw-bold fs-4 text-center m-0">STATISTICS</div>
        <div class="border border-1 border-dark my-1"></div>
        <div class="fw-bold d-flex justify-content-between align-items-center">
            <div><i class="bi bi-cash-coin"></i> Match Earnings</div>
            <div><?=$fn->getstat()->winRewards?>
                <i class="bi bi-currency-rupee "></i>
            </div>
        </div>
        <div class="fw-bold d-flex justify-content-between align-items-center">
            <div><i class="bi bi-share"></i> Referral Earnings</div>
            <div><?=$fn->getstat()->referralBonus?>
                <i class="bi bi-currency-rupee "></i>
            </div>
        </div>
        <div class="fw-bold d-flex justify-content-between align-items-center">
            <div><i class="bi bi-dice-6"></i> Game Played</div>
            <div><?=$fn->getstat()->playedMatches?></div>
        </div>
        <div class="fw-bold d-flex justify-content-between align-items-center">
            <div><i class="bi bi-trophy"></i> Game Won</div>
            <div><?=$fn->getstat()->wonMatches?></div>
        </div>
        <div class="fw-bold d-flex justify-content-between align-items-center">
            <div><i class="bi bi-cash"></i> Penalty</div>
            <div><?=$fn->getstat()->penalties?>
                <i class="bi bi-currency-rupee "></i>
            </div>
        </div>


    </div>

    <div class="text-warning text-center small opacity-75">
        registered on <?= date('d M, Y h:i a', $user->created_at) ?>
    </div>

</div>