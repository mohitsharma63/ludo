<div>
<!-- add new notification -->
 
<div  class="text-end">
<span class="badge badge-sm bg-gradient-primary splbtn" data-bs-toggle="modal" data-bs-target="#sendnotification"><i class="ni ni-notification-70"></i> SEND NOTIFICATION</span>
</div>
<!-- Modal -->
<div class="modal fade" id="sendnotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Send Notification</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Enter Notification Content</h6>
      <?= form_open('admin/sendnotification', ["class" => "showloader-form"]) ?>
      <input type="hidden" name="user" value="0" />
    <textarea class="form-control" name="message" required></textarea>

    
<div class="text-end mt-3">
<button type="submit" class="w-100 btn bg-gradient-primary">Send To All Users</button>
</div>

      <?= form_close() ?>
      </div>
   
    </div>
  </div>

</div>
<hr class="horizontal dark mt-0">
<div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>All Notifications</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date & Time</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Message</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">To</th>

                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Seen By</th>
                    </tr>
                  </thead>
                  <tbody id="i_load_data">
                 
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>