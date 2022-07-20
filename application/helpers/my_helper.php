<?php if ( !defined('BASEPATH') ) {
  exit('No direct script access allowed');
}
if ( !function_exists('pre') ) {
  function pre( $data = FALSE, $e = FALSE ) {
    $bt = debug_backtrace();
    $caller = array_shift($bt);
    print "<pre>";
    print_r($data);
    print "\r\n Called in : " . $caller['file'] . ", At line:" . $caller['line'];
    echo "</pre>\n";
    if ( $e ) {
      exit;
    }
  }
}
if ( !function_exists('last_sql') ) {
  function last_sql( $e = FALSE ) {
    $bt = debug_backtrace();
    $caller = array_shift($bt);
    $CI = &get_instance();
    echo $CI->db->last_query();
    echo "<br/>Called in : " . $caller['file'] . ", At line:" . $caller['line'];
    if ( $e ) {
      exit;
    }
  }
}