<?php

class LoginController {

    public static function doLogin() {
        $username_or_email = RequestController::getCleanPost('username_or_email');
        $password = RequestController::getCleanPost('password');

        $user = new User($username_or_email, $username_or_email);

        if ($user->isValidUsernameSyntax() && $user->isUsernameTaken()) {
            $user->email = "";
        } else if ($user->isValidEmailSyntax() && $user->isEmailTaken()) {
            $user->username = "";
        } else {
            Feedback::add('ERR', 'Incorrect username or password.');
            return;
        }

        if ($user->isValidPassword($password)) {
            self::setLoginStatus(true, $user);
        } else {
            Feedback::add('ERR', 'Incorrect username or password.');
        }
    }

    public static function doLogout() {
        if (self::getLoginStatus()) {
            self::setLoginStatus(false);
        } else {
            Feedback::add('ERR', 'You are already logged out.');
        }
    }

    public static function setLoginStatus($status, $user = "") {
        if ($status) {
            $_SESSION['user'] = $user;
            $_SESSION[User::LOGIN_STATUS] = $status;
            $user->setDateLastLoggedIn();
            Feedback::add('OK', 'Successfully logged in.');
        } else {
            $_SESSION['user'] = "";
            $_SESSION[User::LOGIN_STATUS] = $status;
            Feedback::add('OK', 'Successfully logged out.');
        }
    }

    public static function getLoginStatus() {
        return $_SESSION[User::LOGIN_STATUS];
    }

    public static function getLoginWelcome() {
        if (self::getLoginStatus()) {
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