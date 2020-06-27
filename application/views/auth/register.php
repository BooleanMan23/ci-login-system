
  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form class="user" method = "post" action = "<?= base_url('auth/register');?>">
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="user_name" placeholder="Full Name" name = "user_name" value = "<?= set_value('user_name');?>">
                  <?= form_error('user_name', '<small class = "text-danger pl-3">', '</small>');?>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="user_email" placeholder="Email Address" name ="user_email"  value = "<?= set_value('user_email');?>">
                  <?= form_error('user_email', '<small class = "text-danger pl-3">', '</small>');?>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="user_password1" name = "user_password1" placeholder="Password">
                    <?= form_error('user_password1', '<small class = "text-danger pl-3">', '</small>');?>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="user_password2" name = "user_password2" placeholder="Repeat Password">
                  </div>
                </div>
                <button type = "submit" class="btn btn-primary btn-user btn-block">
                  Register Account
                </button>
              
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="forgot-password.html">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
