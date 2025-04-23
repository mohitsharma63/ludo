<div class="my-4 mx-3">

    <div class="bg-gold px-3 py-2 rounded">
        <div class="fw-bold text-center"><?= $game->game_name ?> (<i class="bi bi-currency-rupee"></i><?= $game->min_amount ?> - <i class="bi bi-currency-rupee"></i><?= $game->max_amount ?>)</div>
        <div class="border border-1 border-dark my-1"></div>

        <?= form_open('user/newmatch/' . User::secure('encrypt', $game->id), ["class" => "ajaxform showloader-form mt-3"]) ?>

        <div class="input-group mb-3">

            <!-- <input type="number" class="input-1 form-control border-gold " placeholder="room code" name="room_code" required> -->

            <input type="number" class="input-1 form-control border-gold " placeholder="amount" name="amount" required>

            <button type="submit" class="input-group-text btn btn-dark" id="basic-addon1">CREATE</button>
        </div>
   
        <?= form_close() ?>

    </div>

    <div id="matchdata">

    </div>
    <div class="mt-3">
        <!--//fakematches-->
    
    
     <?php
     $fakematches=[];

for($i=0;$i<rand(7,10);$i++){
    $fm = new stdClass();
     $fm->amount=rand($game->min_amount,$game->max_amount);
     $fm->prize=$fn->getPrize($fm->amount);
     $fm->husername=$fn->username();
     $fm->jusername=$fn->username();
     $fm->hprofile=rand(1,20);
     $fm->jprofile=rand(1,20);
     $fakematches[]=$fm;
}
     
     
    foreach ($fakematches as $om) {
    


    ?>
        <div class="rounded bg-gold mb-3">
            <div>
                <div class="d-flex justify-content-between align-items-center p-2 border-bottom border-dark" style="font-size:16px;">
                    <div class="fw-bold w-100 small">Entry Fee : ₹ <?= $fn->amount($om->amount) ?></div>

                    <div class="fw-bold w-100 text-end small">Prize : ₹ <?=$om->prize?></div>

                </div>

                <div class="d-flex justify-content-between align-items-center py-2 px-2">
                    <div class="fw-bold text-center">
                        <div><img src="<?= base_url('assets/images/avatars/avatar' . $om->hprofile . '.png') ?>" height="35px" width="35px" /></div>
                        <div style="font-size:13px;">@<?= $om->husername ?></div>
                    </div>
                    <div class="w-100 text-center">


                        <img src="<?= base_url('assets/images/vs.png') ?>" height="40px" width="40px" />


                    </div>
                    <div class="fw-bold text-center">
                        <div><img src="<?= base_url('assets/images/avatars/avatar' . $om->jprofile . '.png') ?>" height="40px" width="40px" /></div>
                        <div style="font-size:13px;">@<?= $om->jusername ?></div>
                    </div>
                </div>



            </div>
        </div>
    <?php
    }
    ?>
    
    
    <!--//fakematchesend-->
    </div>



</div>