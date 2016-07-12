<?php

class User {
    const LOGIN_STATUS = 'is_user_logged_in';

    public $username;
    public $email;
    public $fullName;

    public function __construct($username, $email) {
        $this->username = $username;
        $this->email = $email;
        $this->fullName = "";
        $this->isLoggedIn = false;
    }

    public function isValidSyntax($show_feedback = false) {
        return ($this->isValidUsernameSyntax($show_feedback) && $this->isValidEmailSyntax($show_feedback));
    }

    public function isValidUsernameSyntax($show_feedback = false) {
        $regex = Config::get('USER_CONST')['username']['regex_validation'];
        if (preg_match($regex, $this->username)) {
            return true;
        }
        if ($show_feedback) {
            $feedback = 'Invalid username. Usernames may contain...<br><ul>';

            foreach (Config::get('USER_CONST')['username']['syntax_rules'] as $rule) {
                $feedback .= "<li>".$rule."</li>";
            }
            $feedback .= "</ul>";
            Feedback::add('ERR', $feedback);
        }
        return false;
    }
    public function isValidEmailSyntax($show_feedback = false) {
        $regex = Config::get('USER_CONST')['email']['regex_validation'];

        if (preg_match($regex, $this->email)) {
            return true;
        }
        if ($show_feedback) Feedback::add('ERR', 'Invalid email.');
        return false;
    }

    public function isUserTaken() {
        return ($this->isUsernameTaken() || $this->isEmailTaken());
    }

    public function isEmailTaken() {
        $query = new Query('user');
        return $query->isFieldValueTaken(array('email'), array($this->email));
    }

    public function isUsernameTaken() {
        $query = new Query('user');
        return $query->isFieldValueTaken(array('username'), array($this->username));
    }

    public function setDateLastLoggedIn() {
        if (LoginController::getLoginStatus()) {
            //TODO: Update db with today's date
        }
    }

    public function isValidPassword($password) {
        $unique_col_name = "";
        $unique_col_val = "";

        if ($this->username != "") {
            $unique_col_name = 'username';
            $unique_col_val = $this->username;
        } else if ($this->email != "") {
            $unique_col_name = 'email';
            $unique_col_val = $this->email;
        } else {
            return false;
        }
        $select_col_names = array($unique_col_name,'password');
        $where_col_names = array($unique_col_name);
        $where_col_values = array($unique_col_val);

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

    public function addToDB($password) {
        $col_names = array('username', 'email', 'full_name', 'password');
        // TODO: Add registration date here
        $col_values = array($this->username, $this->email, $this->fullName, password_hash($password, PASSWORD_BCRYPT));
        $query = new Query('user');
        $query->insert($col_names);
        $query->prepare($col_names, $col_values);
        $query->execute();

        if ($query->isSuccess()) {
            Feedback::add('OK', 'Successfully added new user.');
        } else {
            Feedback::add('ERR', 'Failed to add new user.');
        }
    }
}