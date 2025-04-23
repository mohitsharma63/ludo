
  <main class="main-content  bg-dark mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-4 shadow bg-white">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Admin Panel</h3>
                  <p class="mb-0">only for authorised users</p>
                </div>
                <div class="card-body">
                <?= form_open('admin/checklogin', ["id"=>"adminlogin","class" => "ajaxform"]) ?>
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" name="email_id" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" required>
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon" required>
                    </div>
                   
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Login</button>
                    </div>
                    <?= form_close() ?>
                </div>
                
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8 rounded-0">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6 rounded-0" style="background-image:url('<?=base_url("assets/admin/assets/img/curved-images/curved6.jpg")?>')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>