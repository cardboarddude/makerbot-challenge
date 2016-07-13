<?php

class RegistrationModel {

    public static function addNewUser($user, $password) {
        $col_names = array('username', 'email', 'full_name', 'password');
        // TODO: Add registration date here
        $col_values = array($user->username, $user->email, $user->fullName, password_hash($password, PASSWORD_BCRYPT));
        $query = new Query('user');
        $query->insert($col_names);
        $query->prepare($col_names, $col_values);
        $query->execute();

        if ($query->isSuccess()) {
            Feedback::add('OK', 'Successfully added new user.');
            return true;
        } else {
            Feedback::add('ERR', 'Failed to add new user.');
            return false;
        }
    }
}