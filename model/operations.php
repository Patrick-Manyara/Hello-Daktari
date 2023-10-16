<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if (!defined('ROOT_PATH')) {
    http_response_code(401);
    exit();
}

define('auth', true);
define('CORE_PATH', realpath(dirname(__FILE__)) . '/');

require_once 'helper/logs.php';
require_once 'constants.php';
require_once 'app_header.php';

if (session_status() == PHP_SESSION_NONE) {

    session_name('JSESSIONID');

    session_start();
    // session_regenerate_id(true);

    if (isset($_SESSION['session_ip']) === false) {
        $_SESSION['session_ip'] = $_SERVER['REMOTE_ADDR'];
    }
    
    writing_system_logs("Session started for: [ " . json_encode($_SESSION) . ' ]');
}

$error      = array();
$success    = array();
$warning    = array();

require_once 'user_data/index.php';
require_once 'helper/index.php';

if ((($_SESSION['session_ip'] !== $_SERVER['REMOTE_ADDR']) ||
    (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY'] > ($minutesBeforeSessionExpire * 60))))) {
    writing_system_logs("Inactivity time allowed exceeded, logging out user: [ " . json_encode($_SESSION) . ' ]');
    logout();
}

require_once 'read/index.php';
require_once 'email/email.php';
?>