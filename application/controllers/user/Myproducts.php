<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MyProducts extends My_Controller {

  private $tbl = 'products';

  public function __construct(){
		parent::__construct();
		$this->_checkIsLoggedIn();
		$this->pageData['pageTitle'] = 'My Products';
	}

  /**
   * Index.
   *
   * @param int $pageNum
   */
	public function index( $pageNum = 0 ) {
    $where = ['s.id_user' => $this->userId ];

    $config['page_num'] = $pageNum;
    $config['per_page'] = 10;
    $config['num_links'] = 5;
    $config['uri_segment'] = 4;
    $config['base_url'] = 'user/myproducts/index';
    $data = $this->mGlobal->getAllMyProducts($config['per_page'], $config['page_num'], $where);
    $config['total_rows'] = $data['total_rows'];
    $config['items'] = $data['items'];
    if ( $pageNum && empty($config['items']) ) {
      redirect( site_url( ['user', 'products', 'index', 0] ) );
    }
    $this->_pagination($config);

		$this->_renderPage('myproducts/list');
	}

  /**
   * Add.
   *
   * @param int $id_product
   * @param int $pageNum
   */
  public function add( $id_product = 0, $pageNum = 0 ) {
    $obj = new stdClass();
    if ( $id_product ) {
      $obj = $this->mGlobal->getById($this->tbl, $id_product);
    }
    if ( empty($obj) ) {
      redirect( site_url( ['user', 'products', 'index', $pageNum] ) );
    }
    // init validation.
    $this->form_validation->set_rules('id_product', 'Product', 'trim|required|callback_check_product_unique');
    $this->form_validation->set_rules('qty', 'QTY', 'trim|required|numeric');
    $this->form_validation->set_rules('per_price', 'Per Price', 'trim|required|callback_check_decimal');

    if ( $this->form_validation->run('') == TRUE ) {
      // get post data.
      $data = [
        'id_user'     => $this->userId,
        'id_product'  => $this->input->post('id_product', true),
        'qty'         => $this->input->post('qty', true),
        'per_price'   => $this->input->post('per_price', true),
        'timestamps'  => date('Y-m-d H:i:s')
      ];

      // add process.
      $insert = $this->mGlobal->insert('sellers', $data);
      if ( $insert ) {
        $this->session->set_userdata('edit', $obj->title . ' has been added!');
        redirect(site_url([ 'user', 'myproducts', 'index', $pageNum ]));
      }
      else {
        // error case ...
      }
    }

    $this->pageData['validation_errors'] = validation_errors();
    $this->pageData['obj'] = $obj;
    $this->pageData['id_product'] = $id_product;
    $this->pageData['page_num'] = $pageNum;
    $this->_renderPage('myproducts/add');
  }

  /**
   * Edit.
   *
   * @param int $id_product
   * @param int $id
   * @param int $pageNum
   */
  public function edit( $id_product = 0, $id = 0, $pageNum = 0 ) {
    $obj = new stdClass();
    if ( $id ) {
      $product = $this->mGlobal->getById('products', $id_product);
      $obj = $this->mGlobal->getWhere('sellers', ['sellers.id' => $id, 'sellers.id_user' => $this->userId, 'sellers.id_product' => $id_product] );
    }
    if ( empty($obj) ) {
      redirect( site_url( ['user', 'myproducts', 'index', $pageNum] ) );
    }
    // init validation.
    $this->form_validation->set_rules('id_product', 'Product', 'trim|required|callback_check_product_unique');
    $this->form_validation->set_rules('qty', 'QTY', 'trim|required|numeric');
    $this->form_validation->set_rules('per_price', 'Per Price', 'trim|required|callback_check_decimal');

    if ( $this->form_validation->run('') == TRUE ) {
      // get post data.
      $data = [
        'id_user'     => $this->userId,
        'id_product'  => $this->input->post('id_product', true),
        'qty'         => $this->input->post('qty', true),
        'per_price'   => $this->input->post('per_price', true),
        'timestamps'  => date('Y-m-d H:i:s')
      ];

      // update process.
      $update = $this->mGlobal->updateWhere( 'sellers', $data, ['sellers.id' => $id, 'sellers.id_user' => $this->userId, 'sellers.id_product' => $id_product] );
      if ( $update ) {
        $this->session->set_userdata('edit', $product->title . ' has been edited!');
        redirect( site_url( ['user', 'myproducts', 'index', $pageNum] ) );
      }
      else {
        // error case ...
      }
    }

    $this->pageData['validation_errors'] = validation_errors();
    $this->pageData['id'] = $id;
    $this->pageData['obj'] = $obj;
    $this->pageData['product'] = $product;
    $this->pageData['id_product'] = $id_product;
    $this->pageData['page_num'] = $pageNum;
    $this->_renderPage('myproducts/add');
  }

  /**
   * Remove.
   *
   * @param int $id_product
   * @param int $id
   * @param int $pageNum
   */
  public function remove( $id_product = 0, $id = 0, $pageNum = 0 ) {
    $obj = $this->mGlobal->getById($this->tbl, $id_product);
    if ( !empty($obj) ) {
      $this->mGlobal->removeWhere('sellers', [ 'id' => $id, 'id_user' => $this->userId, 'id_product' => $id_product ] );
      $this->session->set_userdata('remove', $obj->title . ' has been removed!');
    }
    redirect( site_url( ['user', 'myproducts', 'index', $pageNum] ) );
  }

  /**
   * Check pre price is decimal or numeric.
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

  /**
   * check product is unique.
   *
   * @param string $id_product
   *
   * @return bool
   */
  public function check_product_unique( $id_product = '' ) {
      $id = $this->uri->segment(5);
      $operator = '=';
      $id_user = $this->userId;
      if ( $id ) {
        $this->db->where( ['sellers.id !=' => $id] );
      }
      $data = $this->mGlobal->is_unique_field_by_id($id_product, 'sellers.id_product.id_user.' . $id_user, $operator);
      if ( !$data ) {
        $this->form_validation->set_message('check_product_unique', "You cannot add product <b>{$id_product}</b> because it already exists.");

        return FALSE;
      }
    return TRUE;
  }
}