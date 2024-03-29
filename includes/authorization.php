<?php

/**
 * File contain functions for users authentication
 * and authorization.
 * @author Ilya G. Drobenya
 */

require_once('common.php');

define('SECONDS_PER_MONTH', 60 * 60 * 24 * 30);

/**
 * Class represent process of user 
 * authentication and authorization.
 * For get instance use method getInstance. 
 * @author Ilya G. Drobenya
 */
class User
{
    // User roles
    const GUEST = 1;
    const REGISTERED_USER = 2;
    const ADMINISTRATOR = 3;
    
    /**
     * Method return class instance.
     * @return authenticator instance 	 
     */
    public static function getInstance() {
        if (self::$instance === NULL) {
            self::$instance = new User();
        }
        
        return self::$instance;
    } // getInstance
    
    
    /**
     * Method get user nickname
     * @return if user registered returns user nickname,
     * otherwise returns FALSE
     */
    public function getUserNickname() {
        $this->loginByCookie();
        
        @session_start();
        if ( isset($_SESSION['usr_data']['login']) ) {
            return $_SESSION['usr_data']['login'];
        }
        
        return FALSE;
    } // getUserNickname
    
    
    /**
     * Method get user role
     * @return current user role (Authenticator::GUEST,
     * Authenticator::ADMINISTRATOR, 
     * Authenticator::REGISTERED_USER)  
     */
    public function getUserRole() {
        $this->loginByCookie();
        
        @session_start();
        if ( isset($_SESSION['usr_data']['role']) ){
           return (int)$_SESSION['usr_data']['role'];        
        }
        
        return self::GUEST; 
    } // getUserRole
    
    
    /**
     * Method get current user id
     * @return If user registered returns his id,
     * otherwise returns FALSE
     */
    public function getUserId() {
        $this->loginByCookie();
        
        @session_start();
        if ( isset($_SESSION['usr_data']['id']) ) {
            return (int)$_SESSION['usr_data']['id'];
        }
        
        return FALSE;
    }
    
    
    /**
     * Function for login users. Function check
     * correctness of arguments and block SQL-injection.
     * @param $nickname user login (string)
     * @param $password user password (string)
     * @param $remember need to remember user (TRUE, FALSE)
     * @return current user role (Authenticator::GUEST,
     * Authenticator::ADMINISTRATOR, 
     * Authenticator::REGISTERED_USER)  
     */
    public function login(&$nickname, &$password, 
            &$remember = FALSE) 
    {
        // check nickname and password correction
        if ( !$this->hasValidNickname($nickname)
                && !$this->hasValidPassword($password) ) {
            $this->logout();
            return self::GUEST;
        }
   
        // compute hash for user password
        $password_hash = $this->hashPassword($nickname, $password);
        if (FALSE === $password_hash) {
            $this->logout();
            return self::GUEST;
        }

        // get user role
        $data = $this->getUserDataFromDb($nickname, $password_hash);
        $role = $data['role'];
        
        if ($role === self::GUEST) {
            return $role;
        }
      
        // save current user data in session
        @session_start();
        //$_SESSION['usr_login'] = $nickname;
        //$_SESSION['usr_role'] = $role;
        $_SESSION['usr_data'] = $data;
   
        // if remember flag set
        if (TRUE === $remember) {
            $this->rememberUser($nickname, $password_hash);
        }
   
        return $role;
    } // login
    
    
    /**
     * Logout user
     * @return None
     */
    public function logout() {
       unset($_SESSION['usr_data']);

       $prev_month_time = time() - SECONDS_PER_MONTH;
       setcookie('login', '', $prev_month_time, '/');
       setcookie('passw_hash', '', $prev_month_time, '/');
    } // logout
    
    
    /**
     * Method returns TRUE if user is guest
     * @return if user not registered returns TRUE,
     * otherwise returns FALSE 
     */
    public function isGuest() {
        if (self::GUEST === $this->getUserRole()) {
            return TRUE;
        }
        return FALSE;
    } // isGuest
    
    
    /**
     * @return if user is admin returns TRUE,
     * otherwise returns FALSE.
     */
    public function isAdmin() {
        if (self::ADMINISTRATOR === $this->getUserRole()) {
            return TRUE;
        }
        return FALSE;
    } // isAdmin
    
    
    /**
     * @return Method return TRUE if user is registered user
     * otherwise returns FASLE
     */
    public function isRegisteredUser() {
        if (self::REGISTERED_USER === $this->getUserRole()) {
            return TRUE;
        }
        return FALSE;
    } // isRegisteredUser
    
    
    private function __construct() {
        global $db_link;
        $this->db_connection = $db_link;
    } // __construct
    
    
    private function __clone() {
    }
    
    
    /**
     * @param $nickname
     * @return Returns TRUE if nickname is correct, 
     * otherwise FALSE. 
     */
    private function hasValidNickname(&$nickname) {
        if (!isset($nickname)) {
            return FALSE;
        }
        
        $nickname = trim($nickname); 
        $has_valid_nick = preg_match("/^([\w_]{1,100})$/", 
           $nickname);        
        return $has_valid_nick; 
    } // hasValidNickname
    
    
    /**
     * @param $password
     * @return Returns TRUE if password is correct, 
     * otherwise FALSE. 
     */
    private function hasValidPassword(&$password) {
        if (!isset($password)) {
            return FALSE;
        }
        $password = trim($password); 
        $has_valid_passw = preg_match("/^([\w_]{0,100})$/", 
            $password);        
        return $has_valid_passw;
    } // hasValidPassword


    /**
     * Method search in database login and password.
     * Arguments must be verified.
     * @return array( 'id' => val1, 'role' => val2,
     * 'login' => val3 ) for regestered users, and
     * array( 'role' => val4 ) for guests.  
     */
    private function getUserDataFromDb($nickname, 
            $passw_hash) {
        $result = mysql_query(
            "SELECT `usr_id`, `usr_login`, `usr_role`"
           . "FROM `users` "
           . "WHERE `usr_login` = '$nickname' " 
           . "  AND `usr_password_hash` = '$passw_hash' ",
           $this->db_connection);
      
        // if searching user not exist
        if (mysql_num_rows($result) !== 1) {
            // return current role
            $data = array( 'role' => self::GUEST );
            return $data;
        }
               
        $row = mysql_fetch_assoc($result);
        $data = array(
            'id' => (int)$row['usr_id'],
            'login' => $row['usr_login'],
            'role' => (int)$row['usr_role']
        );
        return $data;
    } // checkNickAndPasswHash 
    
    
    /**
     * @return (string) password hash for corresponding
     * user, if user account not found returns FALSE.
     */
    private function hashPassword($nickname, $password) {
        // fetch password hash salt from db
        $result = mysql_query(
           "SELECT `usr_security_salt` " 
           . "FROM `users` "
           . "WHERE `usr_login` = '$nickname' ", 
           $this->db_connection);
       
        // if user account not exist then return
        if (mysql_num_rows($result) !== 1) {
            return FALSE;
        }
           
        // compute password hash
        $row = mysql_fetch_assoc($result);
        $password_hash = sha1(
            sha1($password).$row['usr_security_salt'] );
        return $password_hash;
    } // makePasswordHash
    
    
    private function rememberUser($nickname, $passw_hash) {
        // save user attributes in cookie
        $next_month_time = time() + SECONDS_PER_MONTH;
        setcookie('login', $nickname, $next_month_time, '/');
        setcookie('passw_hash', $passw_hash, $next_month_time, '/');
    } // rememberUser
   
    
    /** 
     * If cookie has valid login and password hash
     * method send user attributes to session
     * @return user role
     */
    private function loginByCookie() {      
        if ( isset($_SESSION['usr_data']) ) {
            //return (int)$_SESSION['usr_data']['role'];
            return;
        }
        
        if ( !$this->hasValidNickname( $_COOKIE['login'] ) 
            || !$this->hasValidPassword( $_COOKIE['passw_hash'] ) )
        {
            return; //self::GUEST;    
        }

        $nickname = $_COOKIE['login'];
        $passw_hash = $_COOKIE['passw_hash'];
        $data = $this->getUserDataFromDb($nickname, $passw_hash);
        $role = (int)$data['role'];
           
        // if user has account
        if ($role !== self::GUEST) {
            // save user attributes in session 
            $_SESSION['usr_data'] = $data;
        }    
        return; //$role;
    } // loginByCookie
    
    
    private static $instance = NULL;
    private $db_connection; 
} // Authenticator


?>