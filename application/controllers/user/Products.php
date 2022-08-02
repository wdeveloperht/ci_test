<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends My_Controller {

  private $tbl = 'products';

  public function __construct(){
		parent::__construct();
		$this->_checkIsLoggedIn();
    $this->pageData['pageTitle'] = 'Products';
  }

  /**
   * Index.
   *
   * @param int $pageNum
   */
	public function index( $pageNum = 0 ) {
    $where = [];
    // this section only applies to those with the user role․
	  if ( $this->userRole == 'user' ) {
      $where = [ 'status' => 1 ];
      // we get the IDs of all products attached to the user.
      $this->getAllUserProduct();
    }

    $config['page_num'] = $pageNum;
    $config['per_page'] = 10;
    $config['num_links'] = 5;
    $config['uri_segment'] = 4;
    $config['base_url'] = 'user/products/index';
    $config['total_rows'] = $this->mGlobal->getAllCount($this->tbl, $where);
    $config['items'] = $this->mGlobal->getAll($this->tbl, $config['per_page'], $config['page_num'], $where);
    if ( $pageNum && empty($config['items']) ) {
      redirect( site_url( ['user', 'products', 'index', 0] ) );
    }
    $this->_pagination($config);

		$this->_renderPage('products/list');
	}

  /**
   * Read.
   *
   * @param int $id
   * @param int $pageNum
   */
  public function read( $id = 0, $pageNum = 0 ) {
    $obj = new stdClass();
    if ( $id ) {
      $obj = $this->mGlobal->getById($this->tbl, $id);
    }
    if ( empty($obj) ) {
      redirect( site_url( ['user', 'products', 'index', $pageNum] ) );
    }

    $this->pageData['obj'] = $obj;
    $this->pageData['page_num'] = $pageNum;
    $this->_renderPage($this->tbl . '/read');
  }

  /**
   * Edit.
   *
   * @param int $id
   * @param int $pageNum
   */
  public function edit( $id = 0, $pageNum = 0 ) {
    $obj = new stdClass();
    if ( $id ) {
      $obj = $this->mGlobal->getById($this->tbl, $id);
    }
    if ( empty($obj) ) {
      redirect( site_url( ['user', 'products', 'index', $pageNum] ) );
    }
    // init validation.
    $this->form_validation->set_rules('status', 'Status', 'trim|required');
    $this->form_validation->set_rules('title', 'Title', 'trim|required');
    $this->form_validation->set_rules('description', 'Description', 'trim|required');
    $this->form_validation->set_rules('price', 'Price', 'trim|required|callback_check_decimal');

    if ( $this->form_validation->run('') == TRUE ) {
      // get post data.
      $data = [
        'status'      => $this->input->post('status', true),
        'price'       => $this->input->post('price', true),
        'title'       => $this->input->post('title', true), // $this->db->escape_str();
        'description' => $this->input->post('description', true), // $this->db->escape_str();
        'timestamps'  => date('Y-m-d H:i:s')
      ];
      // save image process.
      $data['image'] = $this->_save_image( $this->tbl, $obj, 'image' );
      // update process.
      $this->_update( $this->tbl, $data, $id );
      redirect( site_url( ['user', 'products', 'index', $pageNum] ) );
    }

    $this->pageData['validation_errors'] = validation_errors();
    $this->pageData['id'] = $id;
    $this->pageData['obj'] = $obj;
    $this->pageData['page_num'] = $pageNum;
    $this->_renderPage($this->tbl . '/edit');
  }

  /**
   * Toggle.
   *
   * @param     $id
   * @param int $pageNum
   */
  public function toggle( $id, $pageNum = 0 ) {
    $obj = $this->mGlobal->getById($this->tbl, $id);
    if ( !empty($obj) ) {
      $this->mGlobal->toggleById($this->tbl, $id);
      $this->session->set_userdata('toggle', $obj->title . ' status changed!');
    }

    redirect( site_url( ['user', 'products', 'index', $pageNum] ) );
  }

  /**
   * Remove.
   *
   * @param     $id
   * @param int $pageNum
   */
  public function remove( $id, $pageNum = 0 ) {
    $obj = $this->mGlobal->getById($this->tbl, $id);
    if ( !empty($obj) ) {
      if ( !empty($obj->image) ) {
        $this->_deleteImage($obj->image, $this->tbl);
      }
      $this->mGlobal->removeById($this->tbl, $id);
      $this->session->set_userdata('remove', $obj->title . ' has been removed!');
    }
    redirect( site_url( ['user', 'products', 'index', $pageNum] ) );
  }

  /**
   * Check decimal or numeric.
   *
   * @param int $num
   *
   * @return bool
   */
  public function check_decimal( $num = 0 ) {
    if ( is_float($num) || is_numeric($num) ) {
      return TRUE;
    }
    $this->form_validation->set_message('check_decimal', 'The Price field is available only Decimal | Numeric.');
    return FALSE;
  }

  private function getAllUserProduct() {
    $myProducts = $this->mGlobal->getAll('sellers', 0, 0, ['sellers.id_user' => $this->userId] );
    $myProductIds = [];
    if ( !empty($myProducts) ) {
      foreach( $myProducts as $product ) {
        $myProductIds[] = $product->id_product;
      }
    }
    $this->pageData['myProductIds'] = $myProductIds;
  }
}