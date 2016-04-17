<?php

namespace App;

define('DATA','user_data');
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
    
    public static function data(){
        return isset($_SESSION[DATA])? $_SESSION[DATA] : null;
    }

    public static function grant($data = 'undefined') {
        $_SESSION[AUTHFLAG] = true;
        $_SESSION[DATA] = $data;
    }

    public static function logout() {
        session_destroy();
    }

}

