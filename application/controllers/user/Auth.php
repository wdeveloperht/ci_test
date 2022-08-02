<?php if ( !defined('BASEPATH') ) {
  exit('No direct script access allowed');
}

class Auth extends My_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    if ( !$this->_isLoggedIn() ) {
      redirect(site_url([ 'login' ]));
    }
    else {
      redirect(site_url([ 'user', 'dashboard' ]));
    }
  }

  public function login() {
    //    $password = 123123;
    //    echo password_hash($password, PASSWORD_DEFAULT);
    $this->layout = 'login';
    if ( !$this->_isLoggedIn() ) {
      $globalError = FALSE;
      $this->pageData['error'] = '';
      $this->form_validation->set_rules("email", 'E-mail', 'trim|required|valid_email');
      $this->form_validation->set_rules("password", 'Password', 'trim|required');
      $this->form_validation->set_rules("csrf_token", "", 'trim|callback_check_csrf');
      if ( $this->form_validation->run() == TRUE ) {
        $errorMessages = array(
          'login_error' => 'Credentials Does Not Match !',
        );
        $email = $this->input->post('email', TRUE);
        $pass = $this->input->post('password', TRUE);
        $userdata = $this->mUser->checkByEmail($email);
        if ( empty($userdata) ) {
          $globalError = TRUE;
          $this->pageData['error'] = $errorMessages['login_error'];
        }
        else {
          if ( $userdata->verified == 'no' ) {
            $globalError = TRUE;
            $this->pageData['error'] = 'Your email has not been verified!';
          }
          else {
            if ( !password_verify($pass, $userdata->password) ) {
              $globalError = TRUE;
              $this->pageData['error'] = $errorMessages['login_error'];
            }
          }
        }
        if ( $globalError === FALSE ) {
          if ( !empty($userdata) ) {
            $this->load->library('encryption');
            $verifyCode = $this->encryption->encrypt($userdata->email . $this->config->item('encryption_key'));
            $this->session->set_userdata('verify_code', $verifyCode);
            $this->session->set_userdata('user', $userdata);
            redirect(site_url([ 'user', 'dashboard' ]));
          }
        }
      }
      $this->_renderPage('auth/login');
    }
    else {
      redirect( site_url([ 'user', 'dashboard' ]));
    }
  }

  public function logout() {
    $this->_isLogOut();
  }

  public function registration() {
    $this->layout = 'login';
    $this->pageData['pageTitle'] = 'Registration Form';
    $this->form_validation->set_rules('role', 'Role', 'trim|required|callback_check_role');
    $this->form_validation->set_rules('name', 'Name', 'trim|required');
    $this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|is_unique[users.email]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
    $this->form_validation->set_rules('csrf_token', '', 'trim|callback_check_csrf');
    if ( $this->form_validation->run() == TRUE ) {
      $post_role = $this->input->post('role', TRUE);
      $name = $this->input->post('name', TRUE);
      $email = $this->input->post('email', TRUE);
      $password = $this->input->post('password', TRUE);
      try {
        $role = 'user';
        if ( in_array($post_role, [ 'admin', 'user' ]) ) {
          $role = $post_role;
        }
        // adds a new user.
        $isAddUser = $this->mUser->add([
                                         'role' => $role,
                                         'name' => $name,
                                         'email' => $email,
                                         'password' => password_hash($password, PASSWORD_DEFAULT),
                                         'status' => 0,
                                         'verified' => 'no',
                                         'email_verification_key' => md5($email),
                                         'email_verified_ex' => date('Y-m-d H:i:s', strtotime('+24 hours')),
                                       ]);
        if ( $isAddUser ) {
          // sends to the user․
          $config['to'] = $email;
          $config['from'] = 'orders@ibiza.am';
          $config['subject'] = 'Verify email address';
          $config['title'] = 'Verify email address';
          $config['text'] = verify_mail_template([ 'name' => $name, 'email' => $email ]);
          $sendmail = MY_email::SendMail($config);
          if ( $sendmail ) {
            $this->pageData['success'] = 1;
          }
          else {
            $this->pageData['error'] = 1;
          }
        }
        else {
          $this->pageData['error'] = 'Error: .....';
        }
      }
      catch ( Exception $e ) {
        $this->pageData['error'] = $e->getMessage();
      }
    }
    $this->_renderPage('auth/registration');
  }

  /**
   * Verify email.
   *
   * @param string $key
   */
  public function verify_email( $key = '' ) {
    $date = date('Y-m-d H:i:s');
    // get user by key.
    $user = $this->mUser->GetWhere([ 'email_verification_key' => $key ]);
    if ( empty($user) ) {
      show_404();
    }
    else {
      if ( !empty($user) && $user->email_verified_ex < $date ) {
        $msg = 'The link has expired, please contact support.';
      }
    }
    $updUser = $this->mUser->UpdateWhere([
                                           'status' => '1',
                                           'verified' => 'yes',
                                           'email_verification_key' => '',
                                           'email_verified_ex' => '',
                                           'email_verified_at' => $date,
                                         ], [ 'id' => $user->id ]);
    if ( $updUser ) {
      $msg = 'Thank you Your profile has been activated';
    }
    echo $msg;
    exit;
    // I did not design a skin for this page․
  }

  /**
   * Check email.
   *
   * @param string $val
   *
   * @return bool
   */
  public function check_email( $val = '' ) {
    $id = $this->userId;
    $data = $this->mAdmin->is_unique_field_by_id($val, 'admins.email.id.' . $id);
    if ( !$data ) {
      $this->form_validation->set_message('check_email', "The email '$val' already exists");

      return FALSE;
    }

    return TRUE;
  }

  /**
   * Check CSRF.
   *
   * @param string $val
   */
  public function check_csrf( $val = '' ) {
    $csrf_token = $this->session->userdata('csrf_token');
    if ( $val != $csrf_token ) {
      exit('<p style="text-align:center; font-size: 20px;"><b>Invalid CSRF token, access denied.</b></p>');
    }
  }

  /**
   * Check role.
   *
   * @param string $val
   *
   * @return bool
   */
  public function check_role( $val = '' ) {
    if ( empty($val) ) {
      $this->form_validation->set_message('check_role', 'The Role field is required.');

      return FALSE;
    }

    return TRUE;
  }
}