<?php
if(isset($user) && $user){
    ?>
<nav class="navbar p-0">
    <div class="pt-3 px-2 container d-flex justify-content-between">
        <button class="btn btn-warning gold-label" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
            <i class="bi bi-list"></i>
        </button>
        <div class="d-flex gap-2">

        <div id="installInstructions">
        <button id="download" class="btn bg-gold"> <i class="bi bi-file-arrow-down"></i></button>
        </div>
          

<div>
            <button data-bs-toggle="modal" data-bs-target="#info" class="btn bg-gold">
                <i class="bi bi-info-circle"></i>
            </button>
</div>

            <a href="<?=base_url('user/wallet')?>" class="btn bg-gold showloader fw-bold">
                <i class="bi bi-wallet2"></i> &nbsp;&nbsp;<span id="balance"><?= $balance ?></span>
                <i class="bi bi-currency-rupee "></i>
            </a>
        </div>
    </div>
</nav>
    <?php
}
?>
