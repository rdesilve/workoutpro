<?php

namespace App;

define('USERDATA','user_data');
define('AUTHFLAG', 'loggedin');
/**
 * Stores static varibles to remember the state of a user's log in session.
 * Since Auth isn't working, this class will access the session data that
 * flags the current session as logged in. When a log out occures the
 * session is shut down.
 */
class Authen {
    
    
    public static function check() {
        return (isset($_SESSION[AUTHFLAG]) && $_SESSION[AUTHFLAG]);
    }

    public static function grant($data = 'undefined') {
        $_SESSION[AUTHFLAG] = true;
        $_SESSION[DATA] = $data;
    }

    public static function loggout() {
        session_destroy();
    }

}

