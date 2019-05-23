<?php
/* This file contains the code for the user object and queries. */

class user {
    
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $accountActivated;
    private $language;
    private $addressId;
    private $admin;
    private $token;
    private $termsOfUseAcceptIp;
        
    function __construct($id, $firstName, $lastName, $email, $password, $accountActivated, $language, $addressId, $admin, $token, $termsOfUseAcceptIp) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->accountActivated = $accountActivated;
        $this->language = $language;
        $this->addressId = $addressId;
        $this->admin = $admin;
		$this->token = $token;
        $this->termsOfUseAcceptIp = $termsOfUseAcceptIp;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getAccountActivated() {
        return $this->accountActivated;
    }
    public function getLanguage() {
        return $this->language;
    }
    public function getAddressId() {
        return $this->addressId;
    }
    public function getAdmin() {
        return $this->admin;
    }
    public function getToken() {
        return $this->token;
    }
    public function getTermsOfUseAcceptIp() {
        return $this->termsOfUseAcceptIp;
    }
    
    public function setId($id) {
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setFirstName($firstName) {
        if (is_string($firstName)) {
            $this->firstName = $firstName;
        }
    }
    public function setLastName($lastName) {
        if (is_string($lastName)) {
            $this->lastName = $lastName;
        }
    }
    public function setEmail($email) {
        if (is_string($email)) {
            $this->email = $email;
        }
    }
    public function setPassword($password) {
        if (is_string($password)) {
            $this->password = $password;
        }
    }
    public function setAccountActivated($accountActivated) {
        if (is_int($accountActivated)) {
            $this->accountActivated = $accountActivated;
        }
    }
    public function setLanguage($language) {
        if (is_string($language)) {
            $this->language = $language;
        }
    }
    public function setAddressId($addressId) {
        if (is_int($addressId)) {
            $this->addressId = $addressId;
        }
    }
    public function setAdmin($admin) {
        if (is_int($admin)) {
            $this->admin = $admin;
        }
    }
	public function setToken($token) {
        if (is_int($token)) {
            $this->token = $token;
        }
    }
	public function setTermsOfUseAcceptIp($termsOfUseAcceptIp) {
        if (is_string($termsOfUseAcceptIp)) {
            $this->termsOfUseAcceptIp = $termsOfUseAcceptIp;
        }
    }
    
    /* To call a static function without having an instance of the class it was defined in, use the following syntax: "class::function(parameters);". E.g.: user::add_user("Jan","Dude","Event","jan.dude@example.com","jansPa55"). */
    
    // Save all changes made to the user info to the database.
    public function save() {
        /* Check if the user already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            // Make sure the database object can be accessed
            global $db;
            
            /* Prepare the query, but insert questionmarks where the parameters values should be. ALL DATABASE LABELS SHOULD BE WRITTEN IN ONE WORD (e.g.: Email instead of E-mail). */
            $query = "INSERT INTO `user` (FirstName, LastName, Email, Password, TermsOfUseAcceptIp) VALUES (?, ?, ?, ?, ?)";
            
            /* Creates a prepared object to communicate with the database, which still accepts some parameters and which will automatically escape malicious strings for injection attacks. */
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            /* Bind the function parameters to the query object. The first argument in the bind_param() function determines the datatype of the parametres.*/
            $statement->bind_param("sssss", $this->firstName, $this->lastName, $this->email, $this->password, $this->termsOfUseAcceptIp);
            
            $success = $statement->execute();
            
            if ($success) {
                /* store the automatically created (auto-increment) user_id's into the session variable for later use (in this case in order to add some fields to the same record) */
                $userId = $db->insert_id;
                $statement->close();
                return $userId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `user` SET FirstName = ?, LastName = ?, Email = ?, Password = ?, AccountActivated = ?, Language = ?, Address_Id = ?, Admin = ?, Token = ?, TermsOfUseAcceptIp = ? WHERE User_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("ssssisiiisi", $this->firstName, $this->lastName, $this->email, $this->password, $this->accountActivated, $this->language, $this->addressId, $this->admin, $this->token, $this->termsOfUseAcceptIp, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete user record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `user` WHERE User_id = ?";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("i", $this->id);
        
        $success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
    
    
    /* Create a user object and store all information of the record with the given User_id in it. */
    static function get_userById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `user` WHERE User_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $firstName, $lastName, $email, $password, $accountActivated, $language, $addressId, $admin, $token, $termsOfUseAcceptIp);
        
        $statement->fetch();
        
        $user = new user($id, $firstName, $lastName, $email, $password, $accountActivated, $language, $addressId, $admin, $token, $termsOfUseAcceptIp);
        
        $statement->close();
        
        return $user;
        
        /* Same query, but without using an OOP prepared statement:
        global $db;

        $id = $db->escape_string($id);

        $query = "SELECT Firstname, Lastname, Email, Password, AccountActivated FROM `user` WHERE user_id = $id";
        
        $result = $db->query($query);

        if ($result == FALSE) {
            display_db_error($db->error);
        }

        $userInfo_byId = $result->fetch_assoc();

        $result->free();

        return $userInfo_byId;*/
    }
    
    
    /* Create a user object and store all information of the record with the given Email in it. */
    static function get_userByEmail($email) {
        global $db;
        
        $email = $db->escape_string($email);
        
        $query = "SELECT * FROM `user` WHERE Email = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("s", $email);
        
        $statement->execute();
        
        $statement->bind_result($id, $firstName, $lastName, $email, $password, $accountActivated, $language, $addressId, $admin, $token, $termsOfUseAcceptIp);
        
        $statement->fetch();
        
        $user = new user($id, $firstName, $lastName, $email, $password, $accountActivated, $language, $addressId, $admin, $token, $termsOfUseAcceptIp);
        
        $statement->close();
        
        return $user;
    }
    
    
    // Returns a lis of all user emails in the database.
    static function get_emails() {
        global $db;
        
        $query = "SELECT Email FROM `user`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $emails = array();
        
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['Email'];
        }
        
        $statement->close();
        
        return $emails;
        
        /* Same query, but without using a prepared statement:
        global $db;
        
        $query = "SELECT Email FROM `user`";
        
        $result = $db->query($query);
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }

        $emails = array();

        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['Email'];
        }

        $result->free();
        
        The msqli database connection will close automatically after executing the script.

        return $emails;*/
    }
    
    
    // Returns a list of all users in the database.
    static function get_allUsers() {
        global $db;
        
        $query = "SELECT User_id, FirstName, LastName FROM `user`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $users = array();
        
        while ($row = $result->fetch_assoc()) {
            $users[] = array($row['User_id'], $row['FirstName'] . " " . $row['LastName']);
        }
        
        $statement->close();
        
        return $users;
    }
	
	
	/* Create and return an array with associative arrays of all users whose account has not been activated yet. */
    static function get_unactivatedUsers() {
		global $db;
        
        $query = "SELECT * FROM `user` WHERE AccountActivated = 0";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $unactivatedUsers = array();
        
        while ($row = $result->fetch_assoc()) {
            $unactivatedUsers[] = $row;
        }
        
        $statement->close();
        
        return $unactivatedUsers;
    }
    
    
    // Sets a token for the user in the database.
    static function set_userToken ($id, $token) {
		global $db;
		
		$query = "UPDATE `user` SET Token = ? WHERE User_id = ?";
		
		$statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
		$statement->bind_param("si", $token, $id);
		
		$success = $statement->execute();
		
		if ($success) {
			$statement->close();
		} else {
			display_db_error($db->error);
		}
    }
    
    
    // Gets a token for the user in the database.
    static function get_tokenById ($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT Token FROM `user` WHERE User_id = ?";
        
        $statement = $db->prepare($query);
            
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($token);
        
        $statement->fetch();
        
        $statement->close();
        
        return $token;
    }
    
    
    /* Check if a user is logged in or not. If not, return NULL, else return the user object. */
    static function isLoggedIn() {
        if (!isset($_SESSION['userId']) AND !isset($_COOKIE['rememberme'])) {
            return false;
        } else if (!isset($_SESSION['userId'])) {
            $cookie = isset($_COOKIE['rememberme']) ? $_COOKIE['rememberme'] : false;
            if ($cookie) {
                list ($id, $token, $check) = explode(':', $cookie);
                if (!timingSafeCompare(hash('sha256', $id . ':' . $token), $check)) {
                    return false;
                } else {
                    $usertoken = user::get_tokenById($id);
                    if (timingSafeCompare($usertoken, $token)) {
                        $_SESSION['userId'] = $id;
                        $user = user::get_userById($_SESSION['userId']);
                        return $user;
                    }
                }
            }
        } else {
            $user = user::get_userById($_SESSION['userId']);
            return $user;
        }
    }
    
	
	/* If a user makes a fresh login (from the home page), then store the login data in the database. */
    static function storeLoginData($id) {
		global $db;
		
		$id = $db->escape_string($id);
        $IP = $db->escape_string($_SERVER['REMOTE_ADDR']);
		$ProxyIP = $db->escape_string($_SERVER['HTTP_X_FORWARDED_FOR']);
		
		// Set the timezone.
		date_default_timezone_set("Europe/Brussels");
		// Get the current time.
		$now = date("Y-m-d H:i:s", time());
		
		$query = "INSERT INTO `login_data` (IP, ProxyIP, Time) VALUES (?, ?, ?)";
		
		$statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
		$statement->bind_param("sss", $IP, $ProxyIP, $now);
		
		$success = $statement->execute();
		
		if ($success) {
			$loginId = $db->insert_id;
			$statement->close();
			return $loginId;
		} else {
			display_db_error($db->error);
		}
    }
	
	
	/* If user login data has been stored in the database, map it to the correct user. */
    static function mapLoginData($id, $loginId) {
		global $db;
		
		$id = $db->escape_string($id);
        $loginId = $db->escape_string($loginId);
		
		$query = "INSERT INTO `user_has_login_data` (User_id, Login_id) VALUES (?, ?)";
		
		$statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
		$statement->bind_param("ii", $id, $loginId);
		
		$success = $statement->execute();
		
		if ($success) {
			$statement->close();
		} else {
			display_db_error($db->error);
		}
    }
	
    
    /* Create a cookie when the user decides to remain logged in. */
    static function rememberMe($id) {
        $length = createRandomNumber(64, 128);
        $token = createToken($length);
        user::set_userToken($id, $token);
        $cookie = $id . ':' . $token;
        $check = hash('sha256', $cookie);
        $cookie .= ':' . $check;
        setcookie('rememberme', $cookie, time() + 60 * 60 * 24 * 183); /* Cookie set fot half a year */
    }
    
    
    /* Check if a logged in user is an admin or not. Return true if the user is an admin, return false if the user is no admin or not logged in. */
    static function isAdmin() {
        $user = user::isLoggedIn();
        if($user != NULL) {
            if($user->getAdmin() === 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    
    // Log the current user out.
    static function logOut() {
        setcookie("rememberme", "", time() - 3600);
        session_unset();
        session_destroy();
        header("Location: index.php?action=logIn");
    }
}

?>