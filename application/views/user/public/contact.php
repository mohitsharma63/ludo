


<div class=" mx-3">

    
  

    <div class="bg-gold p-2 rounded mt-4">
    <div class="fw-bold fs-5 text-center">Contact Us</div>
    <div class="border border-1 border-dark my-1"></div>
    <div class="text-center py-3">
<img src="<?=base_url('assets/images/contact.png')?>" class="w-50"/>
</div>
        <div class="fw-bold fs-6">
        We'd love to hear from you! Whether you have a question about our services, pricing, need a demo, or anything else, our team is ready to answer all your questions.
        </div>
       
        <div class="fw-bold fs-5 mt-3">Get In Touch</div>
        <div class="fw-bold"><i class="bi bi-envelope"></i> <?=$this->db->get('config')->row()->email?></div>
        <div class="fw-bold"><i class="bi bi-telephone"></i> <?=$this->db->get('config')->row()->whatsapp?></div>
    </div>


    <div class="mt-3 d-flex gap-2 justify-content-between">
<a href="https://wa.me/<?=$this->db->get('config')->row()->whatsapp?>" target="_blank" class="btn btn-dark btn-lg bg-black"><i class="bi bi-whatsapp"></i> Whatsapp</a>
<a href="<?=$this->db->get('config')->row()->instagram?>" target="_blank" class="btn btn-lg btn-dark bg-black"><i class="bi bi-instagram"></i> Instagram</a>
<a href="<?=$this->db->get('config')->row()->youtube?>" target="_blank" class="btn btn-dark btn-lg bg-black"><i class="bi bi-youtube"></i> Youtube</a>
</div>





    

    
</div>