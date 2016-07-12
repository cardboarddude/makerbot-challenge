<?php
if (!$_SESSION) {
    session_start();
}

$_ENV['APPLICATION_ENV'] = 'development';

include 'Config.php';
Config::__init();

switch ($_GET['action']) {
    case 'register':
        RegistrationController::doRegistration();
        if (LoginController::getLoginStatus()) {
            $_GET['page'] = 'index';
        } else {
            $_GET['page'] = 'register';
        }
        break;
    case 'login':
        LoginController::doLogin();
        if (LoginController::getLoginStatus()) {
            $_GET['page'] = 'index';
        } else {
            $_GET['page'] = 'login';
        }
        break;
    case 'logout':
        LoginController::doLogout();
        $_GET['page'] = 'index';
        break;
    default:
}

switch ($_GET['page']) {
    case 'register':
        View::render('RegistrationView');
        break;
    case 'login':
        View::render('LoginView');
        break;
    case 'index':
        View::render('IndexView');
        break;
    case '':
        View::render('IndexView');
        break;
    default:
        Feedback::add('ERR', '404: Page could not be found.');
        View::render('IndexView');
}


?>

