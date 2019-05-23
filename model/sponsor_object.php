<?php
/* This file contains the code for the university object and queries. */

class sponsor {
    
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
    
    
    // Save all changes made to the sponsor info to the database.
    public function save() {
        /* Check if the sponsor already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `sponsor` (Name) VALUES (?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("s", $this->name);
            
            $success = $statement->execute();
            
            if ($success) {
                $sponsorId = $db->insert_id;
                $statement->close();
                return $sponsorId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `sponsor` SET Name = ? WHERE Sponsor_id = ?";
            
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
    
    
    // Delete the complete sponsor record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `sponsor` WHERE Sponsor_id = ?";
        
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
    
    
    /* Create a sponsor object and store all information of the record with the given Sponsor_id in it. */
    static function get_sponsorById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `sponsor` WHERE Sponsor_id = ?";
        
        $statement = $db->prepare($query);
        
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $name);
        
        $statement->fetch();
        
        $sponsor = new sponsor($id, $name);
        
        $statement->close();
        
        return $sponsor;
    }
	
	
	// Returns a list of all sponsors in the database.
    static function get_allSponsors() {
        global $db;
        
        $query = "SELECT Sponsor_id, Name FROM `sponsor`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $sponsors = array();
        
        while ($row = $result->fetch_assoc()) {
            $sponsors[] = array($row['Sponsor_id'], $row['Name']);
        }
        
        $statement->close();
        
        return $sponsors;
    }
	
	
	// Returns a lis of all sponsor names in the database.
    static function get_names() {
        global $db;
        
        $query = "SELECT Name FROM `sponsor`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $names = array();
        
        while ($row = $result->fetch_assoc()) {
            $names[] = $row['Name'];
        }
        
        $statement->close();
        
        return $names;
    }
	
	
	// Returns a lis of all sponsors for an event in the database.
    static function get_sponsorOfEvent($eventId) {
        global $db;
        
        $eventId = $db->escape_string($eventId);
		
        $query = "SELECT Sponsor_id FROM `event_has_sponsor` WHERE Event_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
        $statement->bind_param("i", $eventId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $sponsorIds = array();
        
        while ($row = $result->fetch_assoc()) {
            $sponsorIds[] = $row['Sponsor_id'];
        }
        
        $statement->close();
        
        return $sponsorIds;
    }
}

?>