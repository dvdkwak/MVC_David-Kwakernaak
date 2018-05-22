<?php

// DATBASE LAYOUT MINIMAL FOR THIS CLASS TO WORK:
// id (int) (AI)
// username (varchar)
// hash (varchar) (12 min)
// salt (varchar) (12 min)


// User class mainly to login and give basic user information (like UID, and loginName)
// This class will store some session which may NEVER be overruled by any other class or controller
// list of the used $_SESSION variables:
// $_SESSION['loggedIn'] => $id
// $_SESSION['userlevel'] => userlevel of logged in user
// LoggedIn will be set to the current loggedIn UID
class User extends db
{

  // **PROPERTIES**

  public $id        = ""; // UID
  public $username  = ""; // Username of the user (needed for the login)
  public $password  = ""; // Password FROM the user (User given password, not db registered)
  public $userLevel = ""; // Userlevel of the user (int)
  private $hash     = ""; // db Registered password (is a salted hash)
  private $salt     = ""; // db stored salt
  private $userData = ""; // userlist() will return this array filled with all users


  // **METHODS**

  // constructor($id = "") => will fill userdata by uid if user is already loggedIn
  // or will set data by given UID
  // or won't do anything :D
  public function __construct($id = "")
  {
    if(isset($id) && !empty($id)){
      $this->setUserById($id);
    }else
    if(isset($_SESSION['loggedIn']) && !empty($_SESSION['loggedIn'])){
      $this->setUserById($_SESSION['loggedIn']);
    }
  } // End of __construct();


  // setUserById($id) => boolean
  // on true: user has been set
  // on false: this UID does not exist
  // note: this has NOTHING to do with logging in etc
  private function setUserById($id)
  {
    if(isset($id) && !empty($id)){
      $mysqli = $this->connect(); // fetching mysqli object
      $id = $mysqli->real_escape_string($id); // string escape
      $query = "SELECT *
                  FROM tbl_users
                 WHERE `id` = '$id'"; // the query
      $result = $mysqli->query($query);
      if(!$result){
        return false; // query failed
      }
      $data = $result->fetch_assoc();
      foreach($data AS $key => $val){
        $this->$key = $val; // Every propertie of user entitie will be set
      }
      return true; // data has been set
    }
    return false; // no ID has been given / failed query
  } // End of setUserById();


  // userlist() => List of all existing users
  public function userlist()
  {
    $mysqli = $this->connect();
    $query = "SELECT * FROM tbl_users";
    $result = $mysqli->query($query);
    if($result){
      while($data = $result->fetch_assoc()){
        $this->userData[] = $data;
      }
      if(!empty($this->userData)){
        return $this->userData; // Return all users
      }
    }
    return false; // Something went wrong
  } // End of userlist();


  // login($username, $password) => boolean
  // on true: given username and password match, sessions will be set
  // on false: given userame and password do not match, or do not exist, sessions won't be set
  public function login($username, $password)
  {
    $mysqli = $this->connect(); // Getting mysqli object from db class
    $username = $mysqli->real_escape_string($username); // string escape username
    $password = $mysqli->real_escape_string($password); // string escape password
    $this->username = $username; // setting username
    $this->password = $password; // setting password
    $query = "SELECT * FROM tbl_users WHERE `username` = '$this->username'";
    $result = $mysqli->query($query);
    if($result->num_rows !== 1){
      $this->logout();
      return false; // Username does not exist in db
    }
    $data = $result->fetch_assoc();
    $this->hash = $data['hash']; // setting hash needed for checkCredentials();
    $this->salt = $data['salt']; // setting salt needed for checkCredentials();
    $this->userLevel = $data['userlevel']; // setting the userlevel
    $this->id = $data['id']; // setting the id of the user
    if($this->checkCredentials()){ // checking wether given input is a match, if no => else
      $this->setSessions(); // setting the session, duhuh ;p
      return true; // Login succeeded!
    }
    $this->logout();
    return false;
  } // End of login();


  // lock() => boolean // should this user be able to view this page?
  public function lock($location = NULL, $oldLocation = NULL, $userlevel = "0")
  {
    if(!empty($oldLocation)){
      $_SESSION['oldLocation'] = $oldLocation;
    }
    if(isset($_SESSION['loggedIn']) && isset($_SESSION['userlevel'])){
      if(is_array($userlevel)){
        if(in_array($_SESSION['userlevel'], $userlevel)){ // check wether this user's userlevel is in the allowed userlevels
          return true; // allowed to view this page
        }
      }elseif($userlevel == $_SESSION['userlevel']){
        return true; // userlevel is same as requested userlevel
      }
    }
    if(isset($location) && !empty($location)){
      $this->moveTo($location);
    }
    return false; // did not meet the requirements
  } // End of lock();


  // generateSalt() => $salt
  // setsCurrent this salt to a random generated one
  public function generateSalt()
  {
    $time = time();
    $add = hash('sha256', $this->username);
    $this->salt = hash('sha256', $time.$add);
    return $this->salt;
  } // End of generateSalt


  // checkCredentials() => boolean
  // on true: set username and password match
  // on false: they don't
  private function checkCredentials()
  {
    $hashedPass = $this->hashPass();
    if($hashedPass === $this->hash){
      return true;
    }
    return false;
  } // End of checkCredentials();


  // setSessions() => boolean
  // on true: sessions have been set
  // on false: something has gone wrong => error will be set
  private function setSessions()
  {
    $_SESSION['loggedIn'] = $this->id;
    $_SESSION['userlevel'] = $this->userLevel;
    return true;
  } // End of setSessions();


  // hashPass() => will return hashed and salted $this->password
  public function hashPass($password = "", $salt = "")
  {
    if(isset($password) && !empty($password)){
      // code applied on a user input on this function
      $hashedPass = hash('sha256', $password);
      $hashedPass = hash('sha256', $hashedPass.$salt);
      return $hashedPass;
    }
    $password = $this->password;
    $hashedPass = hash('sha256', $password);
    $hashedPass = hash('sha256', $hashedPass.$this->salt);
    return $hashedPass;
  } // End of hashPass();


  // register() => Boolean
  // registers this user as a new user in the system
  public function register()
  {
    if(!empty($this->username) || !empty($this->password) || isset($this->userLevel)){
      $mysqli = $this->connect();
      $this->username = $mysqli->real_escape_string($this->username);
      $this->password = $mysqli->real_escape_string($this->password);
      $this->userLevel = $mysqli->real_escape_string($this->userLevel);
      $this->salt = $this->generateSalt();
      $this->hash = $this->hashPass($this->password, $this->salt);
      $query = "INSERT INTO tbl_users
                        SET username = '$this->username',
                            hash = '$this->hash',
                            salt = '$this->salt',
                            userlevel = '$this->userLevel'";
      $result = $mysqli->query($query);
      if(!$result){
        return false; // Something went wrong with the query
      }
      return true; // This user has been added to the database
    }
    return false; // Some data has not been set
  } // End of register();


  // moveTo($location) => moves to $location
  public function moveTo($location = NULL)
  {
    if(empty($location)){
      echo "
      <script type='text/javascript'>
        window.location.href = '".$_SESSION['oldLocation']."';
      </script>
      ";
    }else{
      echo "
      <script type='text/javascript'>
        window.location.href = '$location';
      </script>
      ";
    }
  } // End of moveTo();


  // logout() => return true, removes all user sessions
  public function logout($location = null)
  {
    if(isset($_SESSION)){
      session_destroy();
    }
    if(isset($location) && !empty($location)){
      $this->moveTo($location);
    }
  } // End of logout();

} // End of User
