<?php if ( !defined('BASEPATH') ) {
  exit('No direct script access allowed');
}
/**
 * Exchange rates.
 *
 * The exchange rates for USD and RON based on Euro
 *
 * @param string $symbols
 * @param string $base
 *
 * @return mixed|void
 */
if ( !function_exists('getExchangeRates') ) {
  function getExchangeRates($symbols = 'USD%2CRON', $base = 'EUR') {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/latest?symbols={$symbols}&base={$base}",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: text/plain",
        "apikey: H4NubDnBSaTXPLqOK7ioURgLFQNj1d0J"
      ),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET"
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    if ( !empty($response) && isJson($response) ) {
      return json_decode($response);
    }

    return;
  }
}

/**
 * is Json.
 *
 * @param $string
 *
 * @return bool
 */
if ( !function_exists('isJson') ) {
  function isJson( $string ) {
    json_decode($string);

    return json_last_error() === JSON_ERROR_NONE;
  }
}

if (!function_exists('pre')) {
  function pre($data = false, $e = false)
  {
    $bt = debug_backtrace();
    $caller = array_shift($bt);
    print "<pre><xmp>";
    print_r($data);
    print "\r\n Called in : " . $caller['file'] . ", At line:" . $caller['line'];
    echo "</xmp></pre>\n";
    if ($e) {
      exit;
    }
  }
}

if (!function_exists('last_sql')) {
  function last_sql($e = false)
  {
    $bt = debug_backtrace();
    $caller = array_shift($bt);
    $CI = &get_instance();
    echo $CI->db->last_query();
    echo "<br/>Called in : " . $caller['file'] . ", At line:" . $caller['line'];
    if ($e) {
      exit;
    }
  }
}


if ( !function_exists('html_main_menu') ) {
  function html_main_menu() {
    $CI = &get_instance();
    $userRole = $CI->userRole;
    $module   = $CI->module;
    $mainMenu = $CI->settings['mainMenu'];
    $notAllowedController = $CI->settings['notAllowedController'];
    ob_start();
    ?>
    <ul id="main-menu" class="main-menu">
      <?php
       if ( !empty($mainMenu) ) {
        foreach ( $mainMenu as $key => $menu ) {
          if ( !empty($notAllowedController[$userRole]) && in_array($key, array_keys($notAllowedController[$userRole])) && empty($notAllowedController[$userRole][$key]) ) {
            continue;
          }
        ?>
          <li class="root-level <?php echo ($module == $key) ? 'active' : ''; ?>">
            <a href="<?php echo site_url( [ 'user', $key] ); ?>">
              <span><?php echo $menu; ?></span>
            </a>
          </li>
        <?php
        }
      }
     ?>
      <li class="root-level">
        <a href="<?php echo site_url( ['logout'] ); ?>">
          <span>Log out</span>
        </a>
      </li>
    </ul>
    <?php
    return ob_get_clean();
  }
}

if ( !function_exists('verify_mail_template') ) {
  function verify_mail_template( $args = [] ) {
    ob_start();
    ?>
    <div>
      <h2>Hi <b>{{USER_NAME}}</b></h2>
      <div>
        <p>Click on <a href="{{VERIFY_EMAIL_LINK}}" target="_blank">Verify Email</a> link to activate your profile. </p>
        <p>Thank you for registering!</p>
      </div>
    </div>
    <?php
    $text = ob_get_clean();
    $text = str_replace('{{USER_NAME}}', $args['name'], $text);
    $text = str_replace('{{VERIFY_EMAIL_LINK}}', site_url(['user', 'verify-email', md5($args['email']) ]), $text);

    return $text;
  }
}


if ( !function_exists('rand_value') ) {
  function rand_value($isnumber = false){
    if ( $isnumber ) {
      $str = mt_rand(100000000, 999999999); // lenght 9
    }
    else {
      $string = "0123456789abcdefghijklmnopqrstuvwxyz";
      $str = "";
      for($i = 0; $i < 25; $i++)  {
        $index = mt_rand(0, 35);
        $str .= $string[$index];
      }
    }
    return $str;
  }
}