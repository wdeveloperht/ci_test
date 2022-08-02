<?php 
	$csrf_token = md5(uniqid(rand(), true));
	$this->session->set_userdata("csrf_token", $csrf_token);
?>
<div class="col-4 col-md-4">
  <div class="login-container">
    <div class="login-form">
      <div class="login-content">
        <h3><?php echo ('Login Form'); ?></h3>
        <?php if ( !empty($error) ) { ?>
          <div class="form-login-error">
            <p><?php echo $error; ?></p>
          </div>
        <?php } ?>
        <?php echo form_open( site_url(['login']), ['method'=>'post', 'role'=>'form', 'id'=>'form_login']); ?>
        <div class="form-group">
          <?php echo form_input('email', set_value('email'), ['type' => 'email', 'placeholder' => ('E-mail'), 'id' => 'email', 'class' => 'form-control']); ?>
          <?php echo form_error('email') ?>
        </div>
        <div class="form-group">
          <?php echo form_password('password', '', ['placeholder' => ('Password'), 'id' => 'password', 'class' => 'form-control']) ?>
          <?php echo form_error('password') ?>
        </div>
        <div class="form-group">
          <?php echo form_input('csrf_token', $csrf_token, ['id' => 'csrf_token', 'class' => 'none']); ?>
          <button type="submit" class="btn btn-primary float-right"><?php echo ('Login In'); ?></button>
        </div>
      <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>
