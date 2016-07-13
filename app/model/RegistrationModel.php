<?php

class RegistrationModel {

    public static function setRegistrationTimestamp($user)
    {
        $sql = "UPDATE users SET user_last_login_timestamp = :user_last_login_timestamp
                WHERE user_name = :user_name LIMIT 1";
        $sth = $database->prepare($sql);

        $update_col_names =  array('registration_timestamp');
        $update_col_values =  array(time());
        $where_col_names = array('username');
        $where_col_values = array($user->username);

        $query = new Query('user');
        $query->update($update_col_names);
        $query->prepare($col_names, $col_values);
        $query->execute();

        $sth->execute(array(':user_name' => $user_name, ':user_last_login_timestamp' => time()));
    }

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