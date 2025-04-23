<div class="mx-2 mt-4">
    <?= form_open_multipart('user/submitkyc', ["class" => "showloader-form", "id" => "signup_form"]) ?>
    <div class="mb-4">
        <label class="fw-bold fs-4 text-gold w-100 text-center mb-3">
            Submit KYC for Approval
        </label>

        <label class="fw-bold text-gold w-100 mt-2">
            Aadhar Card Number
        </label>
        <input type="number" name="aadhar_no" class="aadhar_no_input input-1 form-control border-gold my-2" placeholder="enter 12 digit aadhar no" required />

        <label class="fw-bold text-gold w-100 mt-2">
            Aadhar Card Front
        </label>
        <input type="file" id="target" name="aadhar_front" accept="image/*" class=" input-1 form-control border-gold my-2" placeholder="enter your pincode" required />

        <label class="fw-bold text-gold w-100 mt-2">
            Aadhar Card Back
        </label>
        <input type="file" name="aadhar_back" accept="image/*" class=" input-1 form-control border-gold my-2" placeholder="enter your pincode" required />


    </div>

    <button type="submit" class="btn btn-warning w-100 gold-btn mt-3"><i class="bi bi-fingerprint"></i> Submit KYC</button>

    <div>

    </div>
    <?= form_close() ?>
</div>