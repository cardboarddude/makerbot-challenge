<?php

class RegistrationController {

    public static function doRegistration() {
        $username = RequestController::getCleanPost('username');
        $password = RequestController::getCleanPost('password');
        $email = RequestController::getCleanPost('email');
        $full_name = RequestController::getCleanPost('full_name');

        $user = new User($username, $email);
        $user->fullName = $full_name;

        if ($user->isValidSyntax(true)) {
            if (!$user->isUserTaken()) {
                $user->addToDB($password);
            } else {
                Feedback::add('ERR', 'Username/Email is already taken.');
            }
        }
    }
}