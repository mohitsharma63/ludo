<div class="w-75">
    <img src="<?= base_url(SITELOGO) ?>" class="w-100 animate__animated animate__pulse animate__infinite" />

    <div class="w-100 d-flex flex-column gap-3 mt-3">
        <a href="<?= base_url('login') ?>" class="showloader btn btn-warning w-100 gold-btn"><i class="bi bi-box-arrow-in-right"></i> Login</a>
        <a href="<?= base_url('signup') ?>" class="showloader btn btn-warning w-100 gold-btn"><i class="bi bi-person-add"></i> Signup</a>
    </div>

    <div class="d-flex gap-3 justify-content-between my-3 w-100">
        <div id="installInstructions">
        <button id="download" class=" text-nowrap btn btn-outline-warning w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-file-arrow-down"></i> Install App</button>
        </div>
        <button data-bs-toggle="modal" data-bs-target="#info" class=" text-nowrap btn btn-outline-warning w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-info-circle"></i> Guide</button>
    </div>

    <div class="d-flex flex-wrap row-gap-1 column-gap-3 justify-content-center">
        <a href="<?= base_url('terms-and-conditions') ?>" class="showloader text-gold small text-decoration-none">
            Terms & Conditions
        </a>
    
        <a href="<?= base_url('privacy-policy') ?>" class="showloader text-gold small text-decoration-none">
            Privacy Policy
        </a>
        <a href="<?= base_url('about-us') ?>" class="showloader text-gold small text-decoration-none">
            About Us
        </a>
        <a href="<?= base_url('contact-us') ?>" class="showloader text-gold small text-decoration-none">
            Contact Us
        </a>
    </div>
</div>