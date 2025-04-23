<marquee>
    <div class="animate__animated animate__flash animate__infinite">
    आपकी समस्याओं के लिए हम सदैव तत्पर हैं कृपया हमारे व्हाट्सएप नंबर पर अपनी समस्या का निवारण करवा सकते
 हो  7669006847
    </div>
</marquee>

<div class=" text-center">
    <img src="<?= base_url(SITELOGO) ?>" class="w-50 mx-auto" />
</div>

<div class="d-flex flex-wrap justify-content-center gap-4 my-3">

    <?php
    foreach ($games as $game) {
    ?>

        <div class="col-5 text-center lt-container">
            <a href="<?= base_url('user/creatematch/' . User::secure('encrypt', $game->id)) ?>" class="showloader">
                <img src="<?= base_url('assets/images/' . $game->game_logo) ?>" class="w-100 rounded" />
                <div class="lt-badge ">
                    <div class="badge bg-danger w-75">₹<?= $game->min_amount ?> - ₹<?= $game->max_amount ?></div>
                </div>
            </a>
        </div>

    <?php
    }
    ?>



</div>