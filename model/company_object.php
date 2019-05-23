<?php
/* This file contains the code for the company object and queries. */

class company {
    
    private $id;
    private $name;
    private $description;
    private $vatNumber;
	private $adminUserId;
        
    function __construct($id, $name, $description, $vatNumber, $adminUserId) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->vatNumber = $vatNumber;
		$this->adminUserId = $adminUserId;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getVatNumber() {
        return $this->vatNumber;
    }
    public function getAdminUserId() {
        return $this->adminUserId;
    }
    
    public function setId($id) {
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setName($name) {
        if (is_string($name)) {
            $this->name = $name;
        }
    }
    public function setDescription($description) {
        if (is_string($description)) {
            $this->description = $description;
        }
    }
    public function setVatNumber($vatNumber) {
        if (is_string($vatNumber)) {
            $this->vatNumber = $vatNumber;
        }
    }
    public function setAdminUserId($adminUserId) {
        if (is_int($adminUserId)) {
            $this->adminUserId = $adminUserId;
        }
    }
    
    
    // Save all changes made to the company info to the database.
    public function save() {
        /* Check if the company already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `company` (Name, Description, VatNumber, AdminUser_id) VALUES (?, ?, ?, ?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("sssi", $this->name, $this->description, $this->vatNumber, $this->adminUserId);
            
            $success = $statement->execute();
            
            if ($success) {
                $companyId = $db->insert_id;
                $statement->close();
                return $companyId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `company` SET Name = ?, Description = ?, VatNumber = ?, AdminUser_id = ? WHERE Company_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("sssii", $this->name, $this->description, $this->vatNumber, $this->adminUserId, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete company record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `company` WHERE Company_id = ?";
        
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
    
    
    /* Create a company object and store all information of the record with the given Company_id in it. */
    static function get_companyById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `company` WHERE Company_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $name, $description, $vatNumber, $adminUserId);
        
        $statement->fetch();
        
        $company = new company($id, $name, $description, $vatNumber, $adminUserId);
        
        $statement->close();
        
        return $company;
    }
	
	
	/* Create a company array and store all information of the record with the given Company_id in it. */
    static function get_companyArrayById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `company` WHERE Company_id = ?";
		
		$statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        while ($row = $result->fetch_assoc()) {
            $company = $row;
        }
        
        $statement->close();
        
		if (isset($company)) {
			return $company;
		}
    }
	
	
	// Returns the companies associated with a user ID.
    static function get_companiesByUser($userId) {
        global $db;
        
        $userId = $db->escape_string($userId);
        
        $query = "SELECT * FROM `user_is_representative_of_a_company`,`company` WHERE user_is_representative_of_a_company.Company_id = company.Company_id AND user_is_representative_of_a_company.User_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $userId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $companies = array();
        
        while ($row = $result->fetch_assoc()) {
            $companies[] = array($row['Company_id'], $row['Name']);
        }
        
        $statement->close();
        
        return $companies;
    }
    
    
    // Returns the ID of a company, based on the name.
    static function get_companyByName($companyName) {
        global $db;
        
        $companyName = $db->escape_string($companyName);
        
        $query = "SELECT * FROM `company` WHERE Name = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("s", $companyName);
        
        $statement->execute();
        
        $statement->bind_result($id, $name, $description, $vatNumber, $adminUserId);
        
        $statement->fetch();
        
        $company = new company($id, $name, $description, $vatNumber, $adminUserId);
        
        $statement->close();
        
        return $company;
    }
	
	
	// Returns a list of all company names in the database.
    static function get_companyNames() {
        global $db;
        
        $query = "SELECT Name FROM `company`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $companyNames = array();
        
        while ($row = $result->fetch_assoc()) {
            $companyNames[] = $row['Name'];
        }
        
        $statement->close();
        
        return $companyNames;
    }
    
    
    // Returns all the companies' information from the database.
    static function get_allCompaniesInfo() {
        global $db;
        
        $query = "SELECT * FROM `company` ORDER BY Name";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $companies = array();
        
        while ($row = $result->fetch_assoc()) {
            $companies[] = array("companyId"=>$row['Company_id'], "name"=>$row['Name'], "description"=>$row['Description'], "vatNumber"=>$row['VatNumber'], "adminUserId"=>$row['AdminUser_id']);
        }
        
        $statement->close();
        
        return $companies;
    }
	
	
	// Adds a user to a company in the relationship table.
    static function add_userToCompany($userId, $companyId) {
        global $db;
		
		$userId = $db->escape_string($userId);
		$companyId = $db->escape_string($companyId);

        $query = "INSERT INTO `user_is_representative_of_a_company` (User_id, Company_id) VALUES (?, ?)";

        $statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }

        $statement->bind_param("ii", $userId, $companyId);

        $success = $statement->execute();

        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Removes a user from a company in the relationship table.
    static function delete_userFromCompany($userId, $companyId) {
        global $db;
		
		$userId = $db->escape_string($userId);
		$companyId = $db->escape_string($companyId);
		
        $query = "DELETE FROM `user_is_representative_of_a_company` WHERE User_id = ? AND Company_id = ?";
		
        $statement = $db->prepare($query);
		
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("ii", $userId, $companyId);
		
		$success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Check if a user is a part of a company.
	static function check_userPartOfCompany($userId, $companyId) {
		global $db;
		
		$userId = $db->escape_string($userId);
		$companyId = $db->escape_string($companyId);
		
		$query = "SELECT User_id, Company_id FROM `user_is_representative_of_a_company` WHERE User_id = ? AND Company_id = ?";
		
		$statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
		$statement->bind_param("ii", $userId, $companyId);
		
		$statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
		
		if($result->num_rows === 1) {
			return true;
		} else {
			return false;
		}
	}
	
	
	// Returns a lis of all users mapped to the company in the database.
    static function get_members($companyId) {
        global $db;
		
		$companyId = $db->escape_string($companyId);
        
        $query = "SELECT User_id FROM `user_is_representative_of_a_company` WHERE Company_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("i", $companyId);
		
		$statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $companyMemberIds = array();
        
        while ($row = $result->fetch_assoc()) {
            $companyMemberIds[] = $row['User_id'];
        }
        
        $statement->close();
        
        return $companyMemberIds;
	}
}

?>