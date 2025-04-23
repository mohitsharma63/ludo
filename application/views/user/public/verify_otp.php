
<style>
.containerx {
    display: flex;
    justify-content: center;
    align-items: center;
  
}
 
.inputx {
    width:100%;
    border: none;
    border: 1px solid #FFAD25;
    border-radius:20px;
    margin: 0 5px;
    text-align: center;
    font-size: 26px;
    cursor: not-allowed;
    pointer-events: none;
    background-color:rgba(255,173,37,0.5);
}
 
.inputx:focus {
    border: 1px solid black;
    outline: none;
}
 
.inputx:nth-child(1) {
    cursor: pointer;
    pointer-events: all;
}
</style>
<div class="w-75">
    <div class="mb-4">
        <label class="fw-bold fs-4 text-gold w-100 text-center">
            Enter 6 Digit Code
        </label>
        <div class="text-warning text-center">
            sended to <?= @$mobile_no ?>
        </div>
        <?= form_open('api/verifyotp', ["class" => "ajaxform", "id" => "verifyotp_form"]) ?>
        
         <div class="containerx my-4">
        <div id="inputs" class="inputs d-flex">
            <input class="inputx" name="otp[]" type="password"
                inputmode="numeric"  maxlength="1" />
                
            <input class="inputx" name="otp[]" type="password"
                inputmode="numeric" maxlength="1" />
                
            <input class="inputx" name="otp[]"  type="password"
                inputmode="numeric" maxlength="1" />
                
            <input class="inputx" name="otp[]" type="password"
                inputmode="numeric" maxlength="1" />
                
                <input class="inputx" name="otp[]"  type="password"
                inputmode="numeric" maxlength="1" />
                
                <input class="inputx" name="otp[]" type="password"
                inputmode="numeric" maxlength="1" />
        </div>
    </div>
        
        
        <!--<input type="number" name="otp" class="otp_input input-1 form-control border-gold my-2 fs-2" placeholder="******" required />-->
        
        
        
        
        
        <button type="submit" class="btn btn-warning w-100 gold-btn"> <i class="bi bi-check2-circle"></i> Verify OTP</button>
        <?= form_close() ?>
        <div class="small text-warning mt-1" id="resend_countdown">you can resend otp in <span id="resend_seconds">120</span> seconds</div>
        <div class="d-flex gap-3 justify-content-between my-3 w-100">

            <button onclick="history.back()" class="showloader text-nowrap btn btn-outline-warning w-100 d-flex align-items-center justify-content-center gap-1"><i class="bi bi-arrow-left-circle"></i> Back</button>

            <?= form_open('api/resend', ["class" => "ajaxform", "id" => "signup_form"]) ?>
            <button type="submit" class="showloader text-nowrap btn btn-outline-warning w-100 d-flex align-items-center justify-content-center gap-1" id="resend_otp_btn" disabled><i class="bi bi-send"></i>
                Resend Otp</button>
         <?= form_close() ?>

        </div>
    </div>

    <script>
        var intervalId = null;

        function start_timer() {
            let seconds = 120;
            intervalId = setInterval(() => {
                $("#resend_seconds").text(seconds);
                seconds--;
                if (seconds < 0) {
                    clearInterval(intervalId);
                    $("#resend_countdown").hide();
                    $("#resend_otp_btn").attr('disabled', false)

                }

            }, 1000);
        }

        start_timer();
        
        
        const inputs = document.getElementById("inputs");
 
inputs.addEventListener("input", function (e) {
    const target = e.target;
    const val = target.value;
 
    if (isNaN(val)) {
        target.value = "";
        return;
    }
 
    if (val != "") {
        const next = target.nextElementSibling;
        if (next) {
            next.focus();
        }
    }
});
 
inputs.addEventListener("keyup", function (e) {
    const target = e.target;
    const key = e.key.toLowerCase();
 
    if (key == "backspace" || key == "delete") {
        target.value = "";
        const prev = target.previousElementSibling;
        if (prev) {
            prev.focus();
        }
        return;
    }
});
    </script>