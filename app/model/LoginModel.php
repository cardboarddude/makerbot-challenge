<?php

class LoginModel {
    const IS_LOGGED_IN = 'is_user_logged_in';
    const LOGIN_WITH_EMAIL = 'email';
    const LOGIN_WITH_USERNAME = 'username';
    const LOGIN_TYPE_INVALID = 'invalid_login_type';

    private static function setLoginTimestamp($user)
    {
        $timestamp_col_name = array('last_login_timestamp');
        $username_col_name = array('username');
        $username_col_value = array($user->username);

        $query = new Query('user');
        $query->updateCols($timestamp_col_name);
        $query->whereColsEqual($username_col_name);
        $query->prepare(array_merge($timestamp_col_name, $username_col_name),
                        array_merge(array(time()), $username_col_value));
        $query->execute();
    }

    public static function isUserPasswordValid($user, $password) {
        $login_type = self::getLoginType($user);
        $login_value = "";
        switch ($login_type) {
            case self::LOGIN_WITH_EMAIL:
                $login_value = $user->email;
                break;
            case self::LOGIN_WITH_USERNAME:
                $login_value = $user->username;
                break;
            default:
                Feedback::add('BUG', 'Unknown login type: '.$login_type);
                return;
        }
        return self::isValidCredentials($login_type, $login_value, $password);
    }

    private static function isValidCredentials($login_type, $login_value, $password) {
        $select_col_names = array($login_type,'password');
        $where_col_names = array($login_type);
        $where_col_values = array($login_value);

        $query = new Query('user');

        $query->selectCols($select_col_names);
        $query->whereColsEqual($where_col_names);
        $query->prepare($where_col_names, $where_col_values);
        $query->execute();

        if ($query->isSuccess()) {
            $password_hash = $query->getResult()->password;
            return password_verify($password, $password_hash);
        }

        return false;
    }

    private static function getLoginType($user) {
        if ($user->username != "") {
            return self::LOGIN_WITH_USERNAME;
        } else if ($user->email != "") {
            return self::LOGIN_WITH_EMAIL;
        } else {
            return self::LOGIN_TYPE_INVALID;
        }
    }

    public static function setLoginStatus($status, $user = "") {
        if ($status && $user) {
            self::setLoginTimestamp($user);
            $user->loadUserFromDB();
            $_SESSION['user'] = $user;
            $_SESSION[self::IS_LOGGED_IN] = $status;
        } else {
            $_SESSION['user'] = "";
            $_SESSION[self::IS_LOGGED_IN] = $status;
        }
    }

    public static function getLoginStatus() {
        return $_SESSION[self::IS_LOGGED_IN];
    }
}