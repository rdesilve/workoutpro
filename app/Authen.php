<?php

namespace App;

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
        unset($_SESSION['loggedin']);
        unset($_SESSION['nameofuser']);
        session_destroy();
    }
   
    
    /**
     * Checks to see if the user is logged in.
     * @return type True if the user is logged in, false otherwise
     */
    public static function check(){
        if (isset($_SESSION['loggedin'])){
            return $_SESSION['loggedin'];
        }else{
            return false;
        }
    }
    /**
     * Retrives the user's name
     * @return type The name of the user currently logged in.
     */
    public static function name(){
        if (isset($_SESSION['nameofuser'])){
            return $_SESSION['nameofuser'];
        }else{
            return "";
        }
    }
    
    /**
     * Logs the user in, or grants access to restricted pages.
     * @param type $name The name of the user.
     */
    public static function grant($name = "undefined"){
        $_SESSION['loggedin'] = true;
        $_SESSION['nameofuser'] = $name;
    }

}

