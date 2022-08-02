<?php if ( !defined('BASEPATH') ) {
  exit('No direct script access allowed');
}

class Sellers extends My_Controller {

  private $tbl = 'sellers';

  public function __construct() {
    parent::__construct();
    $this->_checkIsLoggedIn();
    $this->pageData['pageTitle'] = 'Sellers';
  }

  /**
   * Index.
   *
   * @param int $pageNum
   */
  public function index( $pageNum = 0 ) {
    //@todo I haven't processed anything here))
    $this->_renderPage('sellers/list');
  }
}