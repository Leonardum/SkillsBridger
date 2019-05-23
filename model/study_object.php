<?php
/* This file contains the code for the study object and queries. */

class study {
    
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
    
    
    // Save all changes made to the study info to the database.
    public function save() {
        /* Check if the study already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `study` (Name) VALUES (?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("s", $this->name);
            
            $success = $statement->execute();
            
            if ($success) {
                $studyId = $db->insert_id;
                $statement->close();
                return $studyId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `study` SET Name = ? WHERE Study_id = ?";
            
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
        
        $query = "DELETE FROM `study` WHERE Study_id = ?";
        
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
    
    
    /* Create a study object and store all information of the record with the given Study_id in it. */
    static function get_studyById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `study` WHERE Study_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $name);
        
        $statement->fetch();
        
        $study = new study($id, $name);
        
        $statement->close();
        
        return $study;
    }
    
    
    // Returns all study information.
    static function get_allStudyInfo() {
        global $db;
        
        $query = "SELECT * FROM `study` ORDER BY Name";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $studies = array();
        
        while ($row = $result->fetch_assoc()) {
            $studies[] = array($row['Study_id'], $row['Name']);
        }
        
        $statement->close();
        
        return $studies;
    }
}

?>