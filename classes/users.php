<?php

/**
 * Created by PhpStorm.
 * User: Mystichal
 * Date: 2017-11-13
 * Time: 23:21
 */
class users extends application
{
    # function user register
    public function register($email, $password)
    {
        # set login time
        $date = date("Y-m-d");

        # set arg vars
        $numargs = func_num_args();
        $arg_list = func_get_args();

        # connect to database
        $this->database->connect();

        # escape args
        for ($i = 0; $i < $numargs; $i++) {
            $arg_list[$i] = $this->database->escapeString($arg_list[$i]);
        }

        # check if email exists
        $this->database->select('users', '*', NULL, 'email="' . $arg_list[0] . '"');
        $num = $this->database->numRows();

        # disconnect from database
        $this->database->disconnect();

        # if uni then insert data to database
        if ($num == 0) {
            # connect from database
            $this->database->connect();

            $this->database->insert('users', array(
                'email' => $arg_list[0],
                'password' => $arg_list[1],
                'regdate' => $date,
                'lastsession' => $date,
                'permission' => '0',
                'lang' => '0',
                'status' => '0'
            ));

            # disconnect from database
            $this->database->disconnect();
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password)
    {
        # set login time
        $date = date("Y-m-d");

        # connect to database
        $this->database->connect();

        # set arg vars
        $numargs = func_num_args();
        $arg_list = func_get_args();

        # escape args
        for ($i = 0; $i < $numargs; $i++) {
            $arg_list[$i] = $this->database->escapeString($arg_list[$i]);
        }

        # user data look up
        $this->database->select('users', 'id, permission, lang', NULL, 'email="' . $arg_list[0] . '" AND password="' . $arg_list[1] . '"');
        $num = $this->database->numRows();
        $userData = $this->database->getResult();

        # disconnect from database
        $this->database->disconnect();

        # if user exist.
        if ($num == 1) {
            // start session.
            session_start();

            # set session vars.
            $_SESSION['session'] = true;
            $_SESSION['sessionId'] = $userData['0']['id'];
            $_SESSION['sessionPermission'] = $userData['0']['permission'];
            $_SESSION['sessionLang'] = $userData['0']['lang'];
            $_SESSION['sessionMsg'] = [];

            # set welcome message
            array_push($_SESSION['sessionMsg'], array('type' => 'success', 'msg' => 'Welcome user.'));

            # connect to database, set the update the last session var.
            $this->database->connect();
            $this->database->update('users', array('lastsession' => $date), 'id="' . $userData['0']['id'] . '"');
            $this->database->disconnect();

            # session is set return true.
            return true;
        } else {
            # session did not set return false.
            return false;
        }
    }

    # function to logout user
    public function logout()
    {
        unset($_SESSION['session']);
        unset($_SESSION['sessionId']);
        unset($_SESSION['sessionPermission']);
        unset($_SESSION['sessionLang']);
        unset($_SESSION['sessionMsg']);
        session_destroy();
        return;
    }

    # function check session
    public function getSession()
    {
        if (isset($_SESSION['session'])) {
            return true;
        } else {
            return false;
        }

    }

    # function all user data
    public function allUsers() {
        $this->database->connect();
        $this->database->select('users', '*', null, null, 'id ASC');
        $userData = $this->database->getResult();
        $this->database->disconnect();
        return $userData;
    }

    public function numUsers() {
        // connect to database.
        $this->database->connect();

        // Sql select all users, num is the number of result
        $this->database->select('users', '*', NULL, NULL, 'id ASC');
        $num = $this->database->numRows();
        $this->database->disconnect();
        return $num; // return array
    }

    // function to get the numer of users that was created last month
    public function numUsersLast() {
        // connect to database.
        $this->database->connect();

        // Sql select all users, num is the number of result
        $this->database->select('users', '*', NULL, 'YEAR(regdate) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND MONTH(regdate) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
        $num = $this->database->numRows();
        $this->database->disconnect();
        return $num; // return array
    }

    // function to get the numer of users that was created this month
    public function numUsersThis() {
        $date = date("Y-m-d");
        // connect to database.
        $this->database->connect();

        // Sql select all users, num is the number of result
        $this->database->select('users', '*', NULL, 'YEAR(regdate) = YEAR(CURRENT_DATE) AND MONTH(regdate) = MONTH(CURRENT_DATE)');
        $num = $this->database->numRows();
        $this->database->disconnect();
        return $num; // return array
    }

    public function emailById($id) {
        $this->database->connect();
        $this->database->select('users', 'email', NULL, 'id="' . $id . '"');
        $userData = $this->database->getResult();
        $this->database->disconnect();

        return $userData;
    }
}