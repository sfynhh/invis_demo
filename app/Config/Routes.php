<?php

use CodeIgniter\Router\RouteCollection;
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/contentHome', 'Home::contentHome');
$routes->post('/changeRole', 'Login::changeRole');
$routes->post('/modalMyunit', 'Home::modalMyunit');
$routes->post('/updateMyunit', 'Home::updateMyunit');

//sign in
$routes->get('/Signin', 'Login::index');
$routes->post('/SigninProcess', 'Login::processLogin');
$routes->get('/logout', 'Login::Logout');

//user
$routes->get('UserAdmin', 'User::index');
$routes->post('callUserAdmin', 'User::dataJson');
$routes->post('getNipId', 'User::getPgwId');
$routes->post('insertAdmin', 'User::simpanData');
$routes->post('userDel', 'User::deleteUser');
$routes->post('getNipNim', 'User::getNipNim');

//Home

$routes->post('assetShow', 'Home::show_asset');


//lis inventaris
$routes->get('listInventaris', 'List_asset::index');
$routes->post('callListAsset', 'List_asset::dataJson');
$routes->post('generate_id_asset', 'List_asset::generate_id_asset');
$routes->post('addInventaris', 'List_asset::Add_asset');
$routes->post('inventarisDelete', 'List_asset::Delete_asset');
$routes->post('modalEditInventaris', 'List_asset::modalEdit');
$routes->post('prosesInventarisUpdate', 'List_asset::editInvenProcess');
$routes->post('createQrCode', 'List_asset::createQrCode');
// $routes->post('callUserAdmin', 'User::dataJson');

//loan Cart

$routes->get('loanCart', 'List_loan::index');
$routes->get('callDataCarts', 'List_loan::callDataCart');
//loan Cart
$routes->post('addLoanCart', 'List_loan::Add_ListLoan');

$routes->post('loanCartDelete', 'List_loan::deleteList');
$routes->post('addLoanProcess', 'List_loan::Add_requested');


$routes->get('LoanProcess', 'Loan_status::index');
$routes->post('callLoanProcess', 'Loan_status::dataJson');
$routes->post('endedLoan', 'Loan_status::Accept_asset');

$routes->get('/DataEmployee', 'Employee::index');

$routes->post('callDataEmpJson', 'Employee::dataJson');
$routes->post('getPicClassLoan', 'Employee::getPicClassLoan');


