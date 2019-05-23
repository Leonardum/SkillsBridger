<?php
/* This file contains the code for the university object and queries. */

class university {
    
    private $id;
    private $name;
    
    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    
    public function setId($id){
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setName($name) {
        if (is_string($name)) {
            $this->name = $name;
        }
    }
    
    
    // Save all changes made to the university info to the database.
    public function save() {
        /* Check if the university already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `university` (Name) VALUES (?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("s", $this->name);
            
            $success = $statement->execute();
            
            if ($success) {
                $universityId = $db->insert_id;
                $statement->close();
                return $universityId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `university` SET Name = ? WHERE University_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("si", $this->name, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete study record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `university` WHERE University_id = ?";
        
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
    
    
    /* Create a university object and store all information of the record with the given University_id in it. */
    static function get_universityById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `university` WHERE University_id = ?";
        
        $statement = $db->prepare($query);
        
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $name);
        
        $statement->fetch();
        
        $university = new university($id, $name);
        
        $statement->close();
        
        return $university;
    }
    
    
    // Returns all study information.
    static function get_allUniversityInfo() {
        global $db;

        $query = "SELECT * FROM `university` ORDER BY Name";

        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();

        if ($result == FALSE) {
            display_db_error($db->error);
        }

        $universities = array();

        while ($row = $result->fetch_assoc()) {
            $universities[] = array($row['University_id'], $row['Name']);
        }
        
        $statement->close();

        return $universities;
    }
	
	
	// Returns all study information.
    static function get_allUniversities() {
        global $db;

        $query = "SELECT Name FROM `university`";

        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();

        if ($result == FALSE) {
            display_db_error($db->error);
        }

        $universities = array();

        while ($row = $result->fetch_assoc()) {
            $universities[] = $row['Name'];
        }
        
        $statement->close();

        return $universities;
    }
}

?>