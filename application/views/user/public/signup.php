
<div class="w-75">
    <?= form_open('api/signup', ["class" => "ajaxform", "id" => "signup_form"]) ?>
    <div class="mb-3">
        <label class="fw-bold fs-4 text-gold w-100 text-center">
            Create new account
        </label>
        <input type="text" name="full_name" class="input-1 form-control border-gold my-2" placeholder="enter your fullname" required />
        <input type="number" name="mobile_no" class="mobile_no_input input-1 form-control border-gold my-2" placeholder="10 digit mobile no" required />
        <input type="text" name="referral_code" class="input-1 form-control border-gold my-2" value="<?=@$rc?>" placeholder="enter referral code" />

    </div>

    <button type="submit" class="btn btn-warning w-100 gold-btn"> <i class="bi bi-person-add"></i> Signup</button>

    <div class="d-flex gap-3 justify-content-between my-3 w-100">
        <a href="<?= base_url('login') ?>" class="showloader text-nowrap btn btn-outline-warning w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-box-arrow-in-right"></i> Login</a>
        <a href="<?= base_url('') ?>" class="showloader text-nowrap btn btn-outline-warning w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-arrow-left-circle"></i> Home</a>
    </div>
    <div>

    </div>
    <?= form_close() ?>
</div>