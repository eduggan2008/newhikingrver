<?php

define("APP_ROOT", dirname(__FILE__, 2));
require APP_ROOT . '/src/functions.php';
require APP_ROOT . '/config/config.php';
require APP_ROOT . '/src/classes/Session.php';

spl_autoload_register(function($class) {
    $path = APP_ROOT . '/src/classes/';
    require $path . $class . '.php';
});

if(DEV !== true) {
    set_exception_handler('handle_exception');
    set_error_handler('handle_error');
    register_shutdown_function('handle_shutdown');
}

$cms = new CMS($dsn, $username, $password);
unset($dsn, $username, $password);

$session = $cms->getSession();
    
    $session_id = $_SESSION['id'] ?? 0;
    $session_role = $_SESSION['role'] ?? 'public';
    $session_first_name = $_SESSION['first_name'] ?? '';
    $session_last_name = $_SESSION['last_name'] ?? '';
    $session_email = $_SESSION['email'] ?? '';
    $session_picture = $_SESSION['picture'] ?? '';
    $session_joined = $_SESSION['joined'] ?? '';
    






