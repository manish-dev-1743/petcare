<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('register','Home::register');
$routes->get('register/allies','Home::alliesregister');

$routes->post('allies-signup','Home::alliessignup');
$routes->post('signup','Home::signup');
$routes->get('login','Home::login');
$routes->post('do-login','Home::dologin');

$routes->get('admin/dashboard','Admin::index');
$routes->get('allies/dashboard','Allies::index');
$routes->get('admin/pets','Admin::pets');
$routes->get('admin/pets/update','Admin::petsdata');

$routes->post('admin/pets/doupdate','Admin::dopetupdate');
$routes->get('admin/pets/delete','Admin::deletePet');

$routes->get('admin/pet-lists','Allies::petlist');
$routes->get('admin/animal/update','Allies::animaldata');
$routes->post('admin/animals/doupdate','Allies::doanimalupdate');
$routes->get('admin/animals/image/(:num)','Allies::deleteanimalimg/$1');
$routes->get('admin/animal/delete/(:num)','Allies::deleteanimal/$1');

$routes->get('admin/product/lists','Allies::productlist');
$routes->get('admin/product/update','Allies::productdata');
$routes->post('admin/product/doupdate','Allies::doproductupdate');
$routes->get('admin/product/delete/(:num)','Allies::deleteproduct/$1');

$routes->get('pets/(:any)/(:num)','Home::petdata/$1/$2');
$routes->get('pet/(:any)','Home::petcat/$1');

$routes->get('product/(:num)','Home::productdetail/$1');


$routes->get('logout','Home::logout');

$routes->get('profile','Users::profile');
$routes->get('delete/document','Allies::deletedoc');

$routes->post('user/profile/update','Users::updateProfile');
$routes->post('user/changePass','Users::changeuserpass');

$routes->post('cart/add','Users::addtocart');
$routes->get('my-cart','Users::mycart');
$routes->get('delete/cart/(:num)','Users::deletecart/$1');

$routes->post('proceed/payment','Users::proceedpayment');

$routes->get('payment/success','Users::paymentsuccess');

$routes->get('my-order','Users::myorder');