<?php

class RegistrationController {

    public static function doRegistration() {
        $user = self::getUserFromPost();
        $password = RequestController::getCleanPost('password');

        if ($user->isValidSyntax(true)) {
            if (!$user->isUserTaken()) {
                if ($user->addToDB($password)) {
                    $_GET['page'] = 'index';
                    Feedback::add('OK', 'Successfully registered. <a href="?page=login">Go to login</a>.');
                } else {
                    $_GET['page'] = 'register';
                    Feedback::add('ERR', 'Failed to add new user.');
                }
            } else {
                $_GET['page'] = 'register';
                Feedback::add('ERR', 'Username/Email is already taken.');
            }
        } else {
            $_GET['page'] = 'register';
        }
    }

    public static function getUserFromPost() {
        $username = RequestController::getCleanPost('username');
        $email = RequestController::getCleanPost('email');
        $full_name = RequestController::getCleanPost('full_name');

        $user = new User($username, $email);
        $user->fullName = $full_name;

        return $user;
    }
}