<?php if ( !defined('BASEPATH') ) {
  exit('No direct script access allowed');
}

class MY_Controller extends CI_Controller {
  protected static $instance = FALSE;
  public $layout = 'user/dashboard';
  public $ajaxCall = FALSE;
  public $settings = array();
  public $pageData = array();
  public $userData = NULL;
  public $userId = 0;
  public $userRole = '';
  public $styles = array();
  public $scripts = array();

  /**
   * @return bool|MY_Controller
   */
  public static function &getInstance() {
    if ( !self::$instance ) {
      self::$instance = new self ();

      return new self();
    }

    return self::$instance;
  }

  function __construct() {
    parent::__construct();
    $this->_init();
  }

  /**
   * init.
   */
  protected function _init() {
    // Get Settings.
    if ( !empty($this->config->item('settings')) ) {
      $this->settings = $this->config->item('settings');
    }
    $this->pageData['settings'] = $this->settings;
    $this->pageData['module'] = $this->module = $this->router->fetch_class();
    $this->pageData['method'] = $this->method = $this->router->fetch_method();
    $this->pageData['pageTitle'] = 'Dashboard';
    $this->ajaxCall = ($this->input->server('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest');
    // Get User data.
    $user = $this->session->userdata('user');
    if ( !empty($user->id) ) {
      $user = $this->mUser->checkById($user->id);
    }
    $this->userData = isset($user->id) ? $user : NULL;
    $this->userId = isset($user->id) ? $user->id : 0;
    $this->userRole = isset($user->role) ? $user->role : '';
    $this->_checkPermission();
    $this->form_validation->set_error_delimiters('<span class="help-block error-msg">', '</span>');
  }

  /**
   * Add script.
   *
   * @param string $fileName
   */
  public function _addScript( $fileName = '' ) {
    $this->scripts[$fileName] = 1;
  }

  /**
   *  get scripts.
   */
  public function _getScripts() {
    $scripts = array_keys($this->scripts);
    $this->pageData['scripts'] = '';
    foreach ( $scripts as $script ) {
      $this->pageData['scripts'] .= '<script type="text/javascript" language="javascript" src="' . $script . '"></script>';
      $this->pageData['scripts'] .= "\n";
    }
  }

  /**
   * add style.
   *
   * @param string $fileName
   */
  public function _addStyle( $fileName = '' ) {
    $this->styles[$fileName] = 1;
  }

  /**
   * get styles.
   */
  public function _getStyles() {
    $styles = array_keys($this->styles);
    $this->pageData['styles'] = '';
    foreach ( $styles as $style ) {
      $this->pageData['styles'] .= '<link rel="stylesheet" media="screen" type="text/css" href="' . $style . '"/>';
      $this->pageData['styles'] .= "\n";
    }
  }

  /**
   * Render page.
   *
   * @param string $path
   */
  protected function _renderPage( $path = '' ) {
    $this->_getStyles();
    $this->_getScripts();
    $view_path = $path;
    // the view path changes dynamically depending on the user's role․
    if ( $this->pageData['module'] != 'auth' && !empty($this->userData->role) ) {
      $view_path = $this->userData->role . '/' . $path;
    }
    $this->load->view($view_path, $this->pageData);
  }

  /**
   * is logged in.
   *
   * @return bool
   */
  protected function _isLoggedIn() {
    $this->load->library('encryption');
    $user = $this->session->userdata('user');
    $user_email = isset($user->email) ? $user->email : '';
    $mustVerifyCode = $user_email . $this->config->item('encryption_key');
    $verifyCode = $this->session->userdata('verify_code');
    $verifyCode = $this->encryption->decrypt($verifyCode);

    return (strcmp($verifyCode, $mustVerifyCode) === 0);
  }

  /**
   * is log out.
   */
  protected function _isLogOut() {
    if ( $this->_isLoggedIn() ) {
      $this->session->unset_userdata('verify_code');
      $this->session->unset_userdata('user');
      $this->session->sess_destroy();
    }
    redirect(site_url([ 'login' ]));
  }

  /**
   *  check is logged in.
   */
  protected function _checkIsLoggedIn() {
    if ( !$this->_isLoggedIn() ) {
      redirect(site_url([ 'login' ]));
    }
  }

  /**
   * check permission.
   */
  protected function _checkPermission() {
    $module = $this->module;
    $method = $this->method;
    $role = $this->userRole;
    $notAllowedController = $this->settings['notAllowedController'];
    if ( !empty($notAllowedController[$role]) ) {
      // disabled method.
      if ( !empty($method) && !empty($notAllowedController[$role][$module]) && in_array($method, $notAllowedController[$role][$module]) ) {
        // echo 'Method_show_404()';
        show_404();
      }
      // disabled module.
      else {
        if ( in_array($module, array_keys($notAllowedController[$role])) && empty($notAllowedController[$role][$module]) ) {
          // echo 'Controller_show_404()';
          show_404();
        }
      }
    }
  }

  /**
   * Pagination.
   *
   * @param array $data
   */
  protected function _pagination( $data = [] ) {
    if ( isset($data['items']) && !empty($data['items']) ) {
      $config['uri_segment'] = $data['uri_segment'];
      $config['base_url'] = site_url($data['base_url']);
      $config['total_rows'] = $data['total_rows'];
      $config['num_links'] = $data['num_links'];
      $config['per_page'] = $data['per_page'];
      $config['full_tag_open'] = '<ul class="pagination float-right">';
      $config['full_tag_close'] = '</ul>';
      $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
      $config['cur_tag_close'] = '</a></li>';
      $config['num_tag_open'] = '<li class="page-item">';
      $config['num_tag_close'] = '</li>';
      $config['prev_link'] = 'Prev';
      $config['prev_tag_open'] = '<li class="page-item">';
      $config['prev_tag_close'] = '</li>';
      $config['next_link'] = 'Next';
      $config['next_tag_open'] = '<li class="page-item">';
      $config['next_tag_close'] = '</li>';
      $config['last_link'] = 'Last';
      $config['last_tag_open'] = '<li class="page-item">';
      $config['last_tag_close'] = '</li>';
      $config['first_link'] = 'First';
      $config['first_tag_open'] = '<li class="page-item">';
      $config['first_tag_close'] = '</li>';
      $this->pagination->initialize($config);
      $this->pageData['pagination'] = $this->pagination->create_links();
      $this->pageData['items'] = $data['items'];
    }
    $this->pageData['per_page'] = $data['per_page'];
    $this->pageData['page_num'] = $data['page_num'];
  }

  /**
   * Save image.
   *
   * @param string $tbl
   * @param        $obj
   * @param string $key
   *
   * @return string
   */
  protected function _save_image( $tbl = '', $obj, $key = 'image' ) {
    if ( !empty($_FILES[$key]['tmp_name']) ) {
      $tmp = $_FILES[$key]['tmp_name'];
      $tmp_name = $_FILES[$key]['name'];
      $ex = explode('.', $tmp_name);
      $format = end($ex);
      $name = rand_value(TRUE) . '.' . $format;
      $upload_path = $this->settings['ServerPath']['upload_dir'] . $tbl . '/';
      if ( !is_dir($upload_path) ) {
        @mkdir($upload_path, 0755, TRUE);
        copy('uploads/index.html', $upload_path . '/index.html');
      }
      if ( !empty($obj) && !empty($obj->$key) ) {
        $this->_deleteImage($obj->$key, $tbl);
      }
      $moved = move_uploaded_file($tmp, $upload_path . $name);
      if ( $moved ) {
        return $name;
      }
    }

    return '';
  }

  /**
   * Update.
   *
   * @param string $tbl
   * @param array  $data
   * @param int    $id
   */
  protected function _update( $tbl = '', $data = [], $id = 0 ) {
    if ( $id ) {
      $this->mGlobal->updateById($tbl, $data, $id);
    }
    else {
      $liId = $this->mGlobal->insert($tbl, $data);
    }
    if ( $id ) {
      $this->session->set_userdata('edit', $data['title'] . ' has been edited!');
    }
    else {
      $this->session->set_userdata('edit', $data['title'] . ' has been added!');
    }

    return ($liId) ? $liId : $id;
  }

  /**
   * Delete image.
   *
   * @param $filename
   * @param $folder
   */
  protected function _deleteImage( $filename, $folder ) {
    $path = $this->settings['ServerPath']['upload_dir'];
    $file = "{$path}{$folder}/{$filename}";
    @unlink($file);
  }
}