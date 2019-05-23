<?php
/* This file contains the code for the study object and queries. */

class careerEventType {
    
    private $id;
    private $type;
    
    function __construct($id, $type) {
        $this->id = $id;
        $this->type = $type;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getType() {
        return $this->type;
    }
    
    public function setId($id){
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setType($type) {
        if (is_string($type)) {
            $this->type = $type;
        }
    }
    
    
    // Save all changes made to the career event type info to the database.
    public function save() {
        /* Check if the career event type already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `careerevent` (Type) VALUES (?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("s", $this->type);
            
            $success = $statement->execute();
            
            if ($success) {
                $careerEventTypeId = $db->insert_id;
                $statement->close();
                return $careerEventTypeId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `careerevent` SET Type = ? WHERE Careerevent_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("si", $this->type, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete career event type record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `careerevent` WHERE Careerevent_id = ?";
        
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
    
    
    /* Create a study object and store all information of the record with the given Careerevent_id in it. */
    static function get_careerEventTypeById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `careerevent` WHERE Careerevent_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $type);
        
        $statement->fetch();
        
        $careerEventType = new careerEventType($id, $type);
        
        $statement->close();
        
        return $careerEventType;
    }
    
    
	// Returns an array of all career event type names in the database.
    static function get_careerEventTypeArray() {
        global $db;
        
        $query = "SELECT * FROM `careerevent` ORDER BY Type";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $careerEventTypes = array();
        
        while ($row = $result->fetch_assoc()) {
            array_push($careerEventTypes, array($row['Careerevent_id'], $row['Type']));
        }
        
        $statement->close();
        
        return $careerEventTypes;
    }
}

?>