<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends My_Controller {

  public function __construct(){
		parent::__construct();
		$this->_checkIsLoggedIn();
	}

	public function index() {
    $dashboard = $this->userData->role .'_dashboard';
    $this->$dashboard();
    $this->_renderPage('dashboard');
	}

  private function admin_dashboard() {
    // get count active and verified user.
    $verified_user_count = $this->mGlobal->getAllCount('users', [
      'status' => 1,
      'verified' => 'yes'
    ]);
    // get Count of active and verified users who have attached active products.
    $verified_user_attached_products = $this->mGlobal->getCountVerifiedUserByAttachedProducts();

    // get count active products.
    $active_products_count = $this->mGlobal->getAllCount('products', [
      'status' => 1
    ]);

    // get Count of active products which don't belong to any user.
    $active_products_dont_any_user = $this->mGlobal->getDontSellerProductsCount();
    $this->pageData['counts'] = [
      'verified_user' => $verified_user_count,
      'verified_user_attached_products' => $verified_user_attached_products,
      'active_products' => $active_products_count,
      'active_products_dont_any_user' => $active_products_dont_any_user
    ];

    $this->pageData['user_products'] = $this->mGlobal->getUserProducts();
    $this->pageData['active_attached_products'] = $this->mGlobal->getActiveAttachedProducts();
    $this->pageData['active_products_per_user'] = $this->mGlobal->getActiveProductsPerUser();

    // get exchange rates.
    $exchange = getExchangeRates();
    $this->pageData['rates'] = !empty($exchange->rates) ? $exchange->rates : new stdClass();
  }

	private function user_dashboard() {
    //@todo I haven't processed anything here))
  }
}