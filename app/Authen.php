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
    
    
    /**
     * Flags the app to log out the user when they are redirected
     * to another page.
     */
    public static function logout(){
        unset($_SESSION[AUTHFLAG]);
        unset($_SESSION[USERDATA]);
        session_destroy();
    }
   
    
    /**
     * Checks to see if the user is logged in.
     * @return type True if the user is logged in, false otherwise
     */
    public static function check(){
        if (isset($_SESSION[AUTHFLAG])){
            return $_SESSION[AUTHFLAG];
        }else{
            return false;
        }
    }
    /**
     * Retrives the user's name
     * @return type The name of the user currently logged in, null otherwise
     */
    public static function data(){
        if (isset($_SESSION[USERDATA])){
            return $_SESSION[USERDATA];
        }else{
            return null;
        }
    }
    
    /**
     * Logs the user in, or grants access to restricted pages.
     * @param type $data The name of the user.
     */
    public static function grant($data = "undefined"){
        $_SESSION[AUTHFLAG] = true;
        $_SESSION[USERDATA] = $data;
    }

}

