<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_email {
  /**
   * Send mail.
   *
   * @param array $params
   */
  public static function SendMail( $params = [] ) {
    $CI = &get_instance();
    $CI->load->library('email');
    $from = $params['from'];
    $subject = $params['subject'];
    $title = $params['title'];
    $text = $params['text'];
    $to = $params['to'];
    $config['mailtype'] = 'html';
    $config['smtp_host'] = '{YOUR_HOST}';
    $config['smtp_port'] = '{YOUR_PORT}';
    $config['smtp_user'] = '{YOUR_USER}';
    $config['smtp_pass'] = '{YOUR_PASS}';
    $config['protocol'] = 'smtp';
    $config['smtp_crypto'] = 'ssl';
    $config['validate'] = TRUE;
    $config['wordwrap'] = TRUE;
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $CI->email->initialize($config);
    $CI->email->from($from, $title);
    $CI->email->to($to);
    $CI->email->subject($subject);
    $CI->email->message($text);
    if ( !empty($params['attachments']) && is_array($params['attachments']) ) {
      foreach ( $params['attachments'] as $attachment_path ) {
        $CI->email->attach($attachment_path);
      }
    }
    $send = @$CI->email->send();

    return $send;
  }
}