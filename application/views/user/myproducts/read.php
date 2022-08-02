<br>
<h3>Products</h3>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url([ 'user', 'dashboard']); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url([ 'user', 'products']); ?>">Products</a></li>
    <li class="breadcrumb-item active"><?php echo 'Read: ' . $obj->title; ?></li>
  </ol>
</nav>
<br>
<div class="row">
  <div class="col-md-12 col-sm-12 form-horizontal form-groups-bordered">
    <div class="form-group <?php echo (form_error('status')) ? 'has-error' : ''; ?>">
      <?php echo form_label('Status <sup>*</sup>', 'status', array('class' => 'col-sm-3 control-label')) ?>
      <div class="col-sm-5">
        <?php
          $attr = new stdClass();
          $attr->class = 'form-control';
          $attr->id = 'status';
          $attr->disabled = 'disabled';
          $selected = (isset($obj->status) ? $obj->status : set_value('status'));
          $options = [
            1 => 'Published',
            0 => 'Unpublished'
          ];
        echo form_dropdown('status', $options, $selected, $attr);
        echo form_error('status');
        ?>
      </div>
    </div>
    <div class="form-group <?php echo (form_error('price')) ? 'has-error' : ''; ?>">
      <?php echo form_label('Price <sup>*</sup>', 'price', array('class' => 'col-sm-3 control-label')) ?>
      <div class="col-sm-5">
        <?php
          $attr = new stdClass();
          $attr->class = 'form-control';
          $attr->id = 'price';
		  $attr->disabled = 'disabled';
          $value = (isset($obj->price) ? $obj->price : set_value('price'));
          echo form_input('price', $value, $attr);
          echo form_error('price');
        ?>
      </div>
    </div>
    <div class="form-group">
      <?php echo form_label('Image', 'image', array('class' => 'col-sm-3 control-label')) ?>
      <div class="col-lg-5">
        <div id="imageBox-img" class="imageBoxPreview">
          <?php
          if ( !empty($obj->image) && is_file($this->settings['ServerPath']['upload_dir'] . 'products/'. $obj->image) ) {
              $src = site_url( array('uploads', 'products', $obj->image) );
            ?>
            <img width="150" class="thumbnail" src="<?php echo $src; ?>" alt="<?php echo !empty($obj->title) ? $obj->title : ''; ?>" />
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="form-group <?php echo (form_error('title')) ? 'has-error' : ''; ?>">
      <?php echo form_label('Title <sup>*</sup>', 'title', array('class' => 'col-sm-3 control-label')) ?>
      <div class="col-sm-5">
        <?php
          $attr = new stdClass();
          $attr->class = 'form-control';
          $attr->id = 'title';
		      $attr->disabled = 'disabled';
          $value = (isset($obj->title) ? $obj->title : set_value('title'));
          echo form_input('title', $value, $attr);
          echo form_error('title');
        ?>
      </div>
    </div>
    <div class="form-group <?php echo (form_error('description')) ? 'has-error' : ''; ?>">
      <?php echo form_label('Description <sup>*</sup>', 'description', array('class' => 'col-sm-3 control-label')) ?>
      <div class="col-sm-5">
        <?php
          $attr = new stdClass();
          $attr->class = 'form-control';
          $attr->id = 'description';
		  $attr->disabled = 'disabled';
          $value = (isset($obj->description) ? $obj->description : set_value('description'));
          echo form_textarea('description', $value, $attr);
          echo form_error('description');
        ?>
      </div>
    </div>
  </div>
</div>
