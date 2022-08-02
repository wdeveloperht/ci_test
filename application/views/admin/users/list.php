<br>
<h3>Users</h3>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url([ 'user', 'dashboard']); ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">Users</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-4 col-sm-4">
    <a href="#" class="btn btn-info btn-sm">Add New User</a>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <table class="table table-bordered table-striped datatable">
      <thead>
        <th class="id">ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Verified</th>
      </thead>
      <tbody>
      <?php
      if ( !empty($items) ) { ?>
        <?php foreach ( $items as $item ) {
          ?>
          <tr>
            <td><?php echo $item->id ?></td>
            <td><?php echo $item->name ?></td>
            <td><?php echo $item->email ?></td>
            <td><?php echo $item->verified ?></td>
          </tr>
        <?php }
      } ?>
      </tbody>
    </table>
    <?php echo !empty($pagination) ? $pagination : ''; ?>
  </div>
</div>
