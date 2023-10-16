<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);

// $http_host  = "https://$_SERVER[HTTP_HOST]";
// $php_self   = explode(".", $_SERVER['PHP_SELF'])[0];
// $http_model = "https://$_SERVER[HTTP_HOST]/model/update/create?action=";
// $http_delete = "https://$_SERVER[HTTP_HOST]/model/delete/index?";
// $http_cart  = $http_host . "/model/update/cart?action=";

// define('cookie_domain', "$_SERVER[HTTP_HOST]");
// define('model_url', $http_model);

// define('admin_uri', $http_host."/dashboard");
// define('admin_url', $http_host."/dashboard/");


// define('base_uri', "https://hello.angacinemas.com");
// define('base_url', "https://hello.angacinemas.com/");


// define('creator_uri', "https://hello.angacinemas.com/");
// define('creator_url', "https://hello.angacinemas.com");


// define('doctor_url', $http_host."/doctor/");
// define('doctor_uri', $http_host."/doctor");


// define('client_url', $http_host."/client/");
// define('client_uri', $http_host."/client");


// define('cart_url', "$http_cart");
// define('delete_url', "$http_delete");


// define('ROOT_PATH', realpath(dirname(__FILE__)) . '/backoffice/');
// define('MODEL_PATH', realpath(dirname(__FILE__)) . '/model/');


// define('file_url', 'https://uploads.angacinemas.com/images/');
// define('doc_url', 'https://uploads.angacinemas.com/files/');
// define('signature_url', 'https://hello.angacinemas.com/doctor/signatures/');
// define('pdf_uri', 'https://hello.angacinemas.com/prescription/index');


// define('TARGET_DIR', '/home/angacinemas/uploads.angacinemas.com/');
// define('LOG_DIR', '/home/angacinemas/log.angacinemas.com/');


// LOCAL
$http_host  = "https://$_SERVER[HTTP_HOST]/daktari";
$php_self   = explode(".", $_SERVER['PHP_SELF'])[0];
$http_model = "https://$_SERVER[HTTP_HOST]/daktari/model/update/create?action=";
$http_delete = "https://$_SERVER[HTTP_HOST]/daktari/model/delete/index?";
$http_cart  = $http_host . "/model/update/cart?action=";


define('cookie_domain', "$_SERVER[HTTP_HOST]");
define('model_url', $http_model);

define('admin_url', $http_host . "/dashboard/");
define('admin_uri', $http_host . "/dashboard");


define('base_url', "https://localhost/daktari");
define('base_uri', "https://localhost/daktari/");


define('doctor_url', "https://localhost/daktari/doctor/");
define('doctor_uri', "https://localhost/daktari/doctor");

define('client_url', "https://localhost/daktari/client/");
define('client_uri', "https://localhost/daktari/client");

define('creator_uri', "https://vesencomputing.com/");

define('delete_url', "$http_delete");
define('cart_url', "$http_cart");

define('file_url', $http_host . "/uploads/images/");
define('doc_url', $http_host . "/uploads/files/");
define('signature_url', $http_host . '/doctor/signatures/');
define('pdf_uri', '"https://localhost/daktari/prescription/index');


define('ROOT_PATH', realpath(dirname(__FILE__)) . '/');
define('MODEL_PATH', realpath(dirname(__FILE__)) . '/model/');


define('LOG_DIR', realpath(dirname(__FILE__)) . '/log/');
define('TARGET_DIR', "$http_host/uploads/");
