<br>
<h3>My Products</h3>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url([ 'user', 'dashboard']); ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url([ 'user', 'products']); ?>">Products</a></li>
    <li class="breadcrumb-item active"><?php echo !empty($product) ? 'Edit: ' . $product->title : 'Add: ' . $obj->title; ?></li>
  </ol>
</nav>
<br>
<div class="row">
  <?php echo form_open_multipart(current_url(), ['id' => 'FormData', 'class' => 'col-md-12 col-sm-12 form-horizontal form-groups-bordered']); ?>
  <?php echo form_error('id_product'); ?>
	<div class="form-group <?php echo (form_error('qty')) ? 'has-error' : ''; ?>">
      <?php echo form_label('QTY <sup>*</sup>', 'qty', array('class' => 'col-sm-3 control-label')) ?>
      <div class="col-sm-5">
        <?php
          $attr = new stdClass();
          $attr->class = 'form-control';
          $attr->id = 'qty';
          $value = (isset($obj->qty) ? $obj->qty : set_value('qty'));
          echo form_input('qty', $value, $attr);
          echo form_error('qty');
        ?>
      </div>
    </div>
	<div class="form-group <?php echo (form_error('price')) ? 'has-error' : ''; ?>">
      <?php echo form_label('Per Price <sup>*</sup>', 'per_price', array('class' => 'col-sm-3 control-label')) ?>
      <div class="col-sm-5">
        <?php
          $attr = new stdClass();
          $attr->class = 'form-control';
          $attr->id = 'per_price';
          $value = (isset($obj->per_price) ? $obj->per_price : set_value('per_price'));
          echo form_input('per_price', $value, $attr);
          echo form_error('per_price');
        ?>
      </div>
    </div>
	<div class="box-footer">
      <input type="text" id="id_product" name="id_product" class="none" value="<?php echo $id_product; ?>">
      <button type="submit" class="btn btn-primary btn-sm"><?php echo !empty($product) ? 'Edit' : 'Add'; ?></button>
    </div>
  <?php echo form_close(); ?>
</div>
