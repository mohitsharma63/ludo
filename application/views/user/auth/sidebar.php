<div class="offcanvas offcanvas-start sidebar" style='background-image: url(<?= base_url("assets/images/background.jpg?") ?>);' data-bs-backdrop="static" tabIndex="-1" id="sidebar" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header align-items-start">
        <h5 class="offcanvas-title" id="staticBackdropLabel">
            <div class=" text-center">
                <img src="<?= base_url(SITELOGO) ?>" class="w-50 mx-auto" />
            </div>
        </h5>
        <button type="button" class="btn-close bg-warning px-3" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body">
        <div class="d-flex flex-column gap-4">

            <a href="<?= base_url('user/wallet') ?>" class="showloader text-decoration-none">
                <div class="d-flex justify-content-between align-items-center fs-4 border rounded gold-label px-2 py-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-wallet2"></i> Wallet
                    </div>
                    <div>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </a>



            <a href="<?= base_url('user/transactions') ?>" class="showloader text-decoration-none">
                <div class="d-flex justify-content-between align-items-center fs-4 border rounded gold-label px-2 py-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-cash-coin"></i> Transactions
                    </div>
                    <div>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </a>










            <a href="<?= base_url('user/withdraws') ?>" class="showloader text-decoration-none">
                <div class="d-flex justify-content-between align-items-center fs-4 border rounded gold-label px-2 py-4">
                    <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-bank"></i> Withdraws
                    </div>
                    <div>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </a>



            <a href="<?= base_url('user/refer') ?>" class="showloader text-decoration-none">
                <div class="d-flex justify-content-between align-items-center fs-4 border rounded gold-label px-2 py-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-share"></i> Refer & Earn
                    </div>
                    <div>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </a>

            <a href="<?= base_url('contact-us') ?>" class="showloader text-decoration-none">
                <div class="d-flex justify-content-between align-items-center fs-4 border rounded gold-label px-2 py-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-telephone"></i> Contact Us
                    </div>
                    <div>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </a>


            <a href="<?= base_url('user/logout') ?>" class="showloader text-decoration-none">
                <div class="d-flex justify-content-between align-items-center fs-4 border rounded gold-label px-2 py-4">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </div>
                    <div>
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </a>


        </div>
        <div class="my-4">
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
    </div>
</div>