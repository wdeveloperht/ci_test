<?php if ( !defined('BASEPATH') ) {
  exit('No direct script access allowed');
}

class Admins extends My_Controller {

  private $tbl = 'users';

  public function __construct() {
    parent::__construct();
    $this->_checkIsLoggedIn();
    $this->pageData['pageTitle'] = 'Admins';
  }

  /**
   * Index.
   *
   * @param int $pageNum
   */
  public function index( $pageNum = 0 ) {
    $where = [ 'users.role' => 'admin', 'users.id !=' => $this->userId ];
    $config['page_num'] = $pageNum;
    $config['per_page'] = 10;
    $config['num_links'] = 5;
    $config['uri_segment'] = 4;
    $config['base_url'] = 'user/admins/index';
    $config['total_rows'] = $this->mGlobal->getAllCount($this->tbl, $where);
    $config['items'] = $this->mGlobal->getAll($this->tbl, $config['per_page'], $config['page_num'], $where);
    if ( $pageNum && empty($config['items']) ) {
      redirect(site_url([ 'user', 'admins', 'index', 0 ]));
    }
    $this->_pagination($config);
    $this->_renderPage('admins/list');
  }
}