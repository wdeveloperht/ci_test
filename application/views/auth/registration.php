<?php 
	$csrf_token = md5(uniqid(rand(), true));
	$this->session->set_userdata("csrf_token", $csrf_token);
?>
<div class="col-6 col-md-6">
  <div class="registratio-container">
    <div class="registratio-form">
      <div class="registratio-content">
        <h3><?php echo ('Registratio Form'); ?></h3>
        <div class="form-registratio-<?php echo (!empty($success)) ? 'success' : 'error'; ?>">
          <?php
            if ( !empty($error) ) {
              ?>
                <p>Please contact support by phone (+374) -- -- -- --</p>
              <?php
            }
            if ( !empty($success) ) {
            ?>
              <p>Thank you for registration. <br> Check Your Email box and Click on the email verification link.</p>
            <?php
            }
          ?>
        </div>
        <?php echo form_open( site_url( ['registration'] ), ['method'=>'post', 'role'=>'form', 'id'=>'form_registratio']); ?>
        <div class="form-group">
          <?php echo form_dropdown('role', ['' => '-Select role-', 'admin' => 'Admin', 'user' => 'User'], set_value('role'), ['id' => 'role', 'class' => 'form-control' ] ); ?>
          <?php echo form_error('role') ?>
        </div>
        <div class="form-group">
          <?php echo form_input('name', set_value('name'), ['placeholder' => ('Name'), 'id' => 'name', 'class' => 'form-control']); ?>
          <?php echo form_error('name') ?>
        </div>
        <div class="form-group">
          <?php echo form_input('email', set_value('email'), ['placeholder' => ('E-mail'), 'id' => 'email', 'class' => 'form-control']); ?>
          <?php echo form_error('email') ?>
          </div>
        </div>
        <div class="form-group">
          <?php echo form_password('password', '', ['placeholder' => ('Password'), 'id' => 'password', 'class' => 'form-control']) ?>
          <?php echo form_error('password') ?>
        </div>
        <div class="form-group">
          <?php echo form_input('csrf_token', $csrf_token, ['id' => 'csrf_token', 'class' => 'none']); ?>
          <button type="submit" class="btn btn-primary float-right">Registration</button>
        </div>
      <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>