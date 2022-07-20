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