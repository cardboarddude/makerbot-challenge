<?php

class LoginController {

    public static function doLogin() {
        $username_or_email = RequestController::getCleanPost('username_or_email');
        $password = RequestController::getCleanPost('password');
        $user = new User($username_or_email, $username_or_email);

        if (!LoginModel::isUserLoginValid($user)) {
            $_GET['page'] = 'login';
            Feedback::add('ERR', 'Incorrect username or password.');
            return ;
        }

        if (LoginModel::isLoggedInAs($user)) {
            $_GET['page'] = 'login';
            Feedback::add('ERR', 'You are already logged in.');
            return ;
        }

        if (LoginModel::isUserPasswordValid($user, $password)) {
            LoginModel::setLoginStatus(true, $user);
            $_GET['page'] = 'index';
            Feedback::add('OK', 'Successfully logged in.');
        } else {
            $_GET['page'] = 'login';
            Feedback::add('ERR', 'Incorrect username or password.');
        }
    }

    public static function doLogout() {
        if (LoginModel::getLoginStatus()) {
            LoginModel::setLoginStatus(false);
            Feedback::add('OK', 'Successfully logged out.');
        } else {
            Feedback::add('ERR', 'You are already logged out.');
        }
    }

    public static function getLoginWelcome() {
        if (LoginModel::getLoginStatus()) {
            $welcome = "";
            if (strlen($_SESSION['user']->fullName) > 0) {
                $welcome = 'Hello, '.$_SESSION['user']->fullName.'! ';
            } else {
                $welcome = 'Welcome! ';
            }

            return $welcome."<a href='?action=logout'>Logout</a>";
        } else {
            return 'You are not currently logged in.';
        }
    }
}