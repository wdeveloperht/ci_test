<?php if ( !defined('BASEPATH') ) { exit('No direct script access allowed'); }

// settings
$config = array();
$config['settings']['ServerPath'] = array(
  'document_root' => $_SERVER["DOCUMENT_ROOT"],
  'upload_dir' => $_SERVER["DOCUMENT_ROOT"] . '/uploads/',
  'upload_url' => '/uploads/',
);

$config['settings']['mainMenu'] = [
    'dashboard'   => 'Dashboard',
    'myproducts'  => 'My Products',
    'products'    => 'Products',
    'users'       => 'Users',
    'admins'      => 'Admins',
    'sellers'     => 'Sellers'
];

$config['settings']['notAllowedController'] = [
  'admin' => ['myproducts' => [] ],
  'user'  => [
    'products' => ['toggle', 'edit', 'remove'],
    'users'   => [],
    'admins'  => [],
    'sellers' => []
  ]
];