<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Home</title>
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>
<div id="container">
	<h1>Welcome!</h1>
	<div id="body">
    <p>
      <a href="<?php echo site_url(['login']); ?>">Login Form</a>
      <br>
      <a href="<?php echo site_url(['registration']); ?>">Registration Form</a>
    </p>
    <?php
    /*
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
    */
    ?>
	</div>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
</body>
</html>
