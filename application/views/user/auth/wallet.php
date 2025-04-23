


<div class=" mx-2">

    
    <div class="bg-gold p-2 rounded mt-4">
        <div class="d-flex justify-content-between align-items-center">

            <div class="fw-bold" style="font-size:60px">
            <i class="bi bi-wallet2"></i>
            </div>

            <div class=" fw-bold">
               
                <div class="fs-1 text-end">₹ <?=$fn->amount($fn->getWalletBalance())?></div>
                <div class="small opacity-75">Available Balance</div>
            </div>
            
        </div>
    </div>
<div class="mt-2">

<div class="modal fade" id="addmoney" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 border-2 border-dark bg-black">
                <div class=" fw-bold text-white w-100" id="exampleModalLabel">ADD MONEY</div>
                <button type="button" class="btn-close btn-sm text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body bg-gold  rounded-bottom">
                <div class="fw-bold fs-5 my-2">
                    Enter amount
                </div>
            <?= form_open(base_url('user/addmoney'), ["class" => "showloader-form"]) ?>
    <div class="input-group mb-3">
        <input type="number" class="input-1 form-control border-gold text-start" placeholder="amount..." value="<?= $user->full_name ?>" name="amount" aria-label="Username" aria-describedby="basic-addon1" required>
        <span class="input-group-text btn btn-warning gold-btn" id="basic-addon1"><i class="bi bi-currency-rupee"></i></span>
    </div>
<div class="text-center">
    <button type="submit" class="btn btn-dark bg-black w-100 fw-bold"><i class="bi bi-currency-rupee"></i> PAY BY UPI</button>
</div>
    <?= form_close() ?>

            </div>

        </div>
    </div>
</div>

    <button class="btn btn-outline-warning fw-bold w-100 d-flex justify-content-between align-items-center mb-2" data-bs-toggle="modal" data-bs-target="#addmoney">
        <span><i class="bi bi-plus-circle-dotted"></i> Add Money</span>
        <span> <i class="bi bi-chevron-right"></i></span>
    
                </button>



                <div class="modal fade" id="addwithdraw" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 border-2 border-dark bg-black">
                <div class=" fw-bold text-white w-100" id="exampleModalLabel">ADD WITHDRAW REQUEST</div>
                <button type="button" class="btn-close btn-sm text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body bg-gold  rounded-bottom">
                
            <?= form_open('user/addwithdraw', ["id"=>"withdraw","class" => "ajaxform"]) ?>
            <div class="fw-bold fs-5 mt-2">
                   Select Payment Method
                </div>
            <select type="text" class="input-1 form-control border-gold text-start" placeholder="bank name" value="" name="method" aria-label="Username" aria-describedby="basic-addon1" required>
        <option value="bank">Bank</option>
         <option value="upi">UPI</option>
        
        
</select>

            <div class="fw-bold fs-5 mt-2">
                    Enter amount
                </div>
    <div class="input-group">
        
        <input type="number" class="input-1 form-control border-gold text-start" placeholder="amount..." value="" name="amount" aria-label="Username" aria-describedby="basic-addon1" required>
        <span class="input-group-text btn btn-warning gold-btn" id="basic-addon1"><i class="bi bi-currency-rupee"></i></span>
    </div>
    <div class="small mb-3 mt-1">
<b>Note:</b> you can withdraw minimum <b><i class="bi bi-currency-rupee"></i><?=$this->db->get('config')->row()->min_withdraw?></b> & <?=$this->db->get('config')->row()->withdraw_charge?>% fee will be charged.
    </div>
<div class="text-center">
    <button type="submit" class="btn btn-dark bg-black w-100 fw-bold"> ADD WITHDRAW REQUEST</button>
</div>
    <?= form_close() ?>

            </div>

        </div>
    </div>
</div>


    <button class="btn btn-outline-warning fw-bold w-100 d-flex justify-content-between align-items-center mb-2" data-bs-toggle="modal" data-bs-target="#addwithdraw">
        <span><i class="bi bi-bank"></i> Add Withdraw Request</span>
        <span> <i class="bi bi-chevron-right"></i></span>
    
</button>



    <a href="<?=base_url('user/withdraws')?>" class="btn btn-outline-warning fw-bold w-100 d-flex justify-content-between align-items-center mb-2 showloader">
        <span><i class="bi bi-clock-history"></i> Withdraws History</span>
        <span> <i class="bi bi-chevron-right"></i></span>
    
    </a>

    <a href="<?=base_url('user/transactions')?>" class="btn btn-outline-warning fw-bold w-100 d-flex justify-content-between align-items-center mb-2 showloader">
        <span><i class="bi bi-clock-history"></i> Transactions History</span>
        <span> <i class="bi bi-chevron-right"></i></span>
    
    </a>
    
    
    <?php
$banknames = [
  "Allahabad Bank", "Andhra Bank", "Axis Bank", "Bandhan Bank", "Bank of Baroda", "Bank of India", "Bank of Maharashtra", "Canara Bank", "Central Bank of India", "City Union Bank", "Corporation Bank", "Dena Bank", "Federal Bank", "HDFC Bank", "ICICI Bank", "IDBI Bank", "IDFC FIRST Bank", "Indian Bank", "Indian Overseas Bank", "IndusInd Bank", "Jammu & Kashmir Bank", "Karnataka Bank", "Karur Vysya Bank", "Kotak Mahindra Bank", "Lakshmi Vilas Bank", "Oriental Bank of Commerce", "Punjab & Sind Bank", "Punjab National Bank", "RBL Bank", "South Indian Bank", "State Bank of India", "Syndicate Bank", "UCO Bank", "United Bank of India", "Vijaya Bank", "Yes Bank"

]
?>

<div class="modal fade" id="bankdetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 border-2 border-dark bg-black">
                <div class=" fw-bold text-white w-100" id="exampleModalLabel">UPDATE BANK DETAILS</div>
                <button type="button" class="btn-close btn-sm text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body bg-gold  rounded-bottom">
                
            <?= form_open('user/updatebank', ["id"=>"updatebank","class" => "ajaxform"]) ?>
    
        <div class="d-flex flex-column gap-2">
        <input type="text" class="input-1 form-control border-gold text-start" placeholder="fullname in bank" value="<?=@$bank->name?>" name="name" aria-label="Username" aria-describedby="basic-addon1" required>

        <select type="text" class="input-1 form-control border-gold text-start" placeholder="bank name" value="" name="bank" aria-label="Username" aria-describedby="basic-addon1" required>
        <option value="">Select Bank</option>
        <?php
foreach($banknames as $bn){
    ?>
<option value="<?=$bn?>" <?=($bank!=null && $bank->bank==$bn)?'selected':''?>><?=$bn?></option>
    <?php
}
        ?>
</select>
        <input type="text" class="input-1 form-control border-gold text-start" placeholder="bank account no" value="<?=@$bank->account_no?>" name="account_no" aria-label="Username" aria-describedby="basic-addon1" required>
        <input type="text" class="input-1 form-control border-gold text-start" placeholder="ifsc code" value="<?=@$bank->ifsc_code?>" name="ifsc_code" aria-label="Username" aria-describedby="basic-addon1" required>
</div>
  
    <div class="small mb-3 mt-1">
<b>Note:</b> please fill this details carefully, you will get your withdraws in this account.
    </div>
<div class="text-center">
    <button type="submit" class="btn btn-dark bg-black w-100 fw-bold"> UPDATE BANK DETAILS</button>
</div>
    <?= form_close() ?>

            </div>

        </div>
    </div>
</div>

<hr>

<div class="fw-bold text-gold my-2">Update Payment Methods</div>
    <button class="btn btn-outline-warning fw-bold w-100 d-flex justify-content-between align-items-center mb-2" data-bs-toggle="modal" data-bs-target="#bankdetails">
        <span><i class="bi bi-wallet-fill"></i> Bank Details</span>
        <span> <i class="bi bi-chevron-right"></i></span>
    
</button>


<div class="modal fade" id="bankdetails2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2 border-2 border-dark bg-black">
                <div class=" fw-bold text-white w-100" id="exampleModalLabel">UPDATE UPI DETAILS</div>
                <button type="button" class="btn-close btn-sm text-white" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body bg-gold  rounded-bottom">
                
            <?= form_open('user/updateupi', ["id"=>"updatebank","class" => "ajaxform"]) ?>
    
        <div class="d-flex flex-column gap-2">
        <input type="text" class="input-1 form-control border-gold text-start" placeholder="enter upi id" value="<?=@$bank->upi?>" name="upi" aria-label="Username" aria-describedby="basic-addon1" required>

       
</div>
  
    <div class="small mb-3 mt-1">
<b>Note:</b> please fill this details carefully, you will get your withdraws in this account.
    </div>
<div class="text-center">
    <button type="submit" class="btn btn-dark bg-black w-100 fw-bold"> UPDATE UPI DETAILS</button>
</div>
    <?= form_close() ?>

            </div>

        </div>
    </div>
</div>




    <button class="btn btn-outline-warning fw-bold w-100 d-flex justify-content-between align-items-center mb-2" data-bs-toggle="modal" data-bs-target="#bankdetails2">
        <span><i class="bi bi-wallet-fill"></i> UPI Details</span>
        <span> <i class="bi bi-chevron-right"></i></span>
    
</button>


</div>
   

    
</div>