<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-lg-7">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">

          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 ">Change your password for</h1>
                <h5 class = "mb-4"><?= $this->session->userdata('reset_email');?></h5>
              </div>
              <?= $this->session->flashdata('message');?>
              <form class="user" action = "<?=base_url('auth/changepassword')?>" method = "POST" >
                <div class="form-group">
                  <input type="password" class="form-control form-control-user" id="password" name = "password" placeholder="Enter new password...">
                  <?= form_error('password', '<small class = "text-danger pl-3">', '</small>');?>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-user" id="re-password" name = "re-password" placeholder="Repeat password...">
                  <?= form_error('re-password', '<small class = "text-danger pl-3">', '</small>');?>
                </div>
                <button type = "submit" class="btn btn-primary btn-user btn-block">
                  Reset Password
                </button>
              </form>

              <hr>
     
              <div class="text-center">
                <a class="small" href="<?=base_url('auth'); ?>">Back to login</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

</div>

