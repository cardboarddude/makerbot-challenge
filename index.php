<?php

include 'app/core/Config.php';
Config::__init('development');

switch ($_GET['action']) {
    case 'register':
        RegistrationController::doRegistration();
        break;
    case 'login':
        LoginController::doLogin();
        break;
    case 'logout':
        LoginController::doLogout();
        $_GET['page'] = 'index';
        break;
    default:
}

$page = $_GET['page'];
switch ($page) {
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
        if (strlen($page) > 0) {
            Feedback::add('ERR', "404: Page '$page' could not be found.");
        } else {
            Feedback::add('ERR', "404: Page could not be found.");
        }
        View::render('IndexView');
}


?>

