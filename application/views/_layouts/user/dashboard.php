<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <meta name="robots" content="noindex, nofollow">
  <title><?php echo $pageTitle; ?></title>
  <meta name="description" content="">
  <meta name="author" content="Web Developer Tigran Nalbandyan tigran.nalbandyan01@gmail.com">
  <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/css/style.css" type="text/css" />
  <?php echo $styles; ?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="page-body" data-url="<?php echo site_url(); ?>">
<div class="page-container">
  <div class="sidebar-menu">
    <div class="sidebar-menu-inner">
      <?php echo html_main_menu(); ?>
    </div>
  </div>
  <div class="main-content">
    <h2>Welcome <a href="#"><?php echo $this->userData->name; ?></a></h2>
    <hr>
    <div class="col-xs-12 status">
      <?php if ( $this->session->userdata('add') ) { ?>
        <div class="alert alert-success"><?php echo $this->session->userdata('add'); ?></div>
        <?php $this->session->unset_userdata('add');
      } ?>
      <?php if ( $this->session->userdata('edit') ) { ?>
        <div class="alert alert-primary"><?php echo  $this->session->userdata('edit'); ?></div>
        <?php $this->session->unset_userdata('edit');
      } ?>
      <?php if ( $this->session->userdata('toggle') ) { ?>
        <div class="alert alert-warning"><?php echo  $this->session->userdata('toggle'); ?></div>
        <?php $this->session->unset_userdata('toggle');
      } ?>
      <?php if ( $this->session->userdata('remove') ) { ?>
        <div class="alert alert-danger"><?php echo  $this->session->userdata('remove'); ?></div>
        <?php $this->session->unset_userdata('remove');
      } ?>
    </div>
    {{content}}
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    <footer class="main text-center">
      &copy; <?php echo date('Y'); ?> Development by <a href="https://www.linkedin.com/in/tigran-nalbandyan/" target="_blank">Tigran Nalbandyan</a>
    </footer>
  </div>
</div>
<script src="/assets/js/script.js"></script>
<?php echo $scripts; ?>
</body>
</html>