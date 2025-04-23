<div class="w-75">
    <?= form_open('api/login', ["class" => "ajaxform", "id" => "login_form"]) ?>
    <div class="mb-3">
        <label class="fw-bold fs-4 text-gold w-100 text-center">
            Enter Mobile Number
        </label>
        <input type="number" name="mobile_no" class="mobile_no_input input-1 form-control border-gold my-2" placeholder="10 digit mobile no" required />

    </div>

    <button type="submit" class="btn btn-warning w-100 gold-btn"><i class="bi bi-box-arrow-in-right"></i> Login</button>

    <div class="d-flex gap-3 justify-content-between my-3 w-100">
        <a href="<?= base_url('signup') ?>" class="showloader text-nowrap btn btn-outline-warning w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-person-add"></i> Signup</a>
        <a href="<?= base_url('') ?>" class="showloader text-nowrap btn btn-outline-warning w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-arrow-left-circle"></i> Home</a>
    </div>
    <div>

    </div>
    <?= form_close() ?>
</div>