<br>
<h3>Products</h3>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url([ 'user', 'dashboard']); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Products</li>
  </ol>
</nav>
<br>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <table class="table table-bordered table-striped datatable">
      <thead>
        <th class="id">ID</th>
        <th>Title</th>
        <th>Price</th>
        <th>Image</th>
        <th class="quick-actions">Quick actions</th>
      </thead>
      <tbody>
      <?php
      if ( !empty($items) ) { ?>
        <?php foreach ( $items as $item ) { ?>
          <tr>
            <td><?php echo $item->id ?></td>
            <td><?php echo $item->title ?></td>
            <td><?php echo $item->price ?></td>
            <td>
              <?php
                if ( is_file($this->settings['ServerPath']['upload_dir'] .'products/'. $item->image) ) {
                  echo '<img src="'. site_url([$this->settings['ServerPath']['upload_url'], 'products', $item->image] ) .'" height="50">';
                }
              ?>
            </td>
            <td class="quick-actions">
              <a href="<?php echo site_url([ 'user', 'products', 'read', $item->id ]); ?>" class="btn btn btn-info btn-sm">Read</a>
              <?php if ( !empty($myProductIds) && !in_array($item->id, $myProductIds) ) { ?>
                <a href="<?php echo site_url([ 'user', 'myproducts', 'add', $item->id ]); ?>" class="btn btn-primary btn-sm">Add</a>
              <?php } ?>
            </td>
          </tr>
        <?php }
      } ?>
      </tbody>
    </table>
    <?php echo !empty($pagination) ? $pagination : ''; ?>
  </div>
</div>
