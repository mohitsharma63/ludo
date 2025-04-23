


<div class=" mx-3">

    
    <div class="bg-gold p-2 rounded mt-4">
        <div class="fw-bold fs-5 text-center"><i class="bi bi-share"></i> Referrals</div>
        <div class="border border-1 border-dark my-1"></div>
        <div class="d-flex">
            <div class="fw-bold text-center w-100">
                <div>Referred Users</div>
                <div class="fs-3"><?=$fn->getstat()->referedUsers?></div>
            </div>

            <div class="fw-bold text-center w-100">
                <div>Referral Earnings</div>
                <div class="fs-3">₹ <?=$fn->getstat()->referralBonus?></div>
            </div>
        </div>
    </div>

    <div class="bg-gold p-2 rounded mt-3">
    <div class="text-center py-3">
<img src="<?=base_url('assets/images/referral.png')?>" class="w-50"/>
</div>
        <div class="fw-bold fs-6 text-center">
            Refer your friends, and you will get <?=$fn->amount($this->db->get('config')->row()->referral_bonus)?>% bonus , everytime they win a match.
        </div>
       
        <div class="border border-2 border-black mx-3 my-2 py-2 text-black text-center fs-1 rounded fw-bold">
          <?=$user->referral_code?>
        </div>
        <div class="text-center fw-bold">Referral Code</div>
    </div>


    <div class="mt-3 d-flex gap-2">
<button data-text="<?=$user->referral_code?>" class="copy btn btn-dark fw-bold bg-black w-100">
<i class="bi bi-copy"></i> Copy Code
</button>
<button data-text="<?=base_url('signup/'.strtolower($user->referral_code))?>" class="copy btn btn-dark  fw-bold bg-black w-100">
<i class="bi bi-copy"></i> Copy Link
</button>
</div>

<a href="whatsapp://send?text=Play ludo and earn money. Register Now, My refer code is <?=$user->referral_code?>.%0A👇👇%0A<?=base_url('signup/'.strtolower($user->referral_code))?>" data-action="share/whatsapp/share"  
target="_blank" class="button-41 text-decoration-none fw-bold mt-3"><i class="bi bi-whatsapp"></i> Share to WhatsApp </a>   



    

    
</div>