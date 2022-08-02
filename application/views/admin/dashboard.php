<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="count-wrap">
        <h2>Count section</h2>
        <p>
          <em>Task: All active and verified users.</em> <b><?php echo $counts['verified_user']; ?></b>
        </p>
        <p>
          <em>Task: Count of active and verified users who have attached active products.</em> <b><?php echo $counts['verified_user_attached_products']; ?></b>
        </p>
        <p>
          <em>Task: Count of all active products (just from products table).</em> <b><?php echo $counts['active_products']; ?></b>
        </p>
        <p>
          <em>Task: Count of active products which don't belong to any user.</em> <b><?php echo $counts['active_products_dont_any_user']; ?></b>
        </p>
      </div>
    <br>
    <div class="table-wrap">
      <p><em>Task: Amount of all active attached products (if user1 has 3 prod1 and 2 prod2 which are active, user2 has 7 prod2 and 4 prod3, prod3 is inactive, then the amount of active attached products will be 3 + 2 + 7 = 12).</em></p>
      <?php if ( !empty($user_products) ) { ?>
        <table border="1" style="width: 220px; border-collapse: collapse;">
          <tr>
            <th>User name</th>
            <th>Count</th>
          </tr>
          <?php
          $total_qty = 0;
          foreach( $user_products as $item ) {
            $total_qty += $item->qty; ?>
            <tr>
              <td><?php echo $item->name; ?></td>
              <td><?php echo $item->qty; ?></td>
            </tr>
          <?php } ?>
          <tr>
            <th>Total Count</th>
            <th> <b><?php echo $total_qty; ?></b></th>
          </tr>
        </table>
      <?php } else {
        echo '<p> Result not fund! </p>';
      }
      ?>

      <br>

      <p><em>Task: Summarized price of all active attached products (from the previous subpoint if prod1 price is 100$, prod2 price is 120$, prod3 price is 200$, the summarized price will be 3 x 100 + 9 x 120 = 1380).</em></p>
      Total Price <b><?php echo !empty($active_attached_products) ? $active_attached_products : ''; ?></b>

      <br>
      <br>

      <p><em>Task: Summarized prices of all active products per user. For example - John Summer - 85$, Lennon Green - 107$.</em></p>
      <?php if ( !empty($active_products_per_user) ) { ?>
        <table border="1" style="width: 400px; border-collapse: collapse;">
          <tr>
            <th>Name</th>
            <th>Price</th>
          </tr>
          <?php foreach( $active_products_per_user as $item ) { ?>
            <tr>
              <td><?php echo $item->name; ?></td>
              <td>$ <?php echo $item->price; ?></td>
            </tr>
          <?php } ?>
        </table>
      <?php } ?>
      <br>

      <p><em>Task: The exchange rates for USD and RON based on Euro using https://exchangeratesapi.io/ . This is a separated subpoint and isn't related to the previous subpoints.</em></p>
      <?php if ( !empty($active_products_per_user) ) { ?>
        <table border="1" style="width: 400px; border-collapse: collapse;">
          <tr>
            <th>Name</th>
            <th>Price EUR </th>
            <th>Price USD </th>
            <th>Price RON </th>
          </tr>
          <?php foreach( $active_products_per_user as $item ) { ?>
            <tr>
              <td><?php echo $item->name; ?></td>
              <td><?php echo number_format($item->price, 2, '.', ''); ?></td>
              <td><?php echo ( !empty($rates->USD) ) ? number_format(($item->price * $rates->USD), 2, '.', '') : '-'; ?></td>
              <td><?php echo ( !empty($rates->RON) ) ? number_format(($item->price * $rates->RON), 2, '.', '') : '-'; ?></td>
            </tr>
          <?php } ?>
        </table>
      <?php } ?>
    </div>
  </div>
</div>