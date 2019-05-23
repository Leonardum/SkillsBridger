<?php
/* This file contains the code for the event organisation object and queries. */

class eventOrganisation {
    
    private $id;
    private $name;
    private $adminUserId;
    
    function __construct($id, $name, $adminUserId) {
        $this->id = $id;
        $this->name = $name;
        $this->adminUserId = $adminUserId;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
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
    public function setAdminUserId($adminUserId) {
        if (is_int($adminUserId)) {
            $this->adminUserId = $adminUserId;
        }
    }
    
    
    // Save all changes made to the event organisation info to the database.
    public function save() {
        /* Check if the event organisation already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `eventorganisation` (Name, AdminUser_id) VALUES (?, ?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("si", $this->name, $this->adminUserId);
            
            $success = $statement->execute();
            
            if ($success) {
                $organisationId = $db->insert_id;
                $statement->close();
                return $organisationId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `eventorganisation` SET Name = ?, AdminUser_id = ? WHERE Organisation_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("sis", $this->name, $this->adminUserId, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete event record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `eventorganisation` WHERE Organisation_id = ?";
        
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
    
    
    /* Create an event organisation object and store all information of the record with the given Organisation_id in it. */
    static function get_eventOrganisationById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `eventorganisation` WHERE Organisation_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $name, $adminUserId);
        
        $statement->fetch();
        
        $eventOrganisation = new eventOrganisation($id, $name, $adminUserId);
        
        $statement->close();
        
        return $eventOrganisation;
    }
    
    
    // Adds a user to an event organisation in the relationship table.
    static function add_userToEventOrganisation($userId, $organisationId) {
        global $db;
		
		$userId = $db->escape_string($userId);
		$organisationId = $db->escape_string($organisationId);

        $query = "INSERT INTO `user_is_part_of_eventorganisation` (User_id, Organisation_id) VALUES (?, ?)";

        $statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }

        $statement->bind_param("ii", $userId, $organisationId);

        $success = $statement->execute();

        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Removes a user from an event organisation in the relationship table.
    static function delete_userFromEventOrganisation($userId, $organisationId) {
        global $db;
		
		$userId = $db->escape_string($userId);
		$organisationId = $db->escape_string($organisationId);
		
        $query = "DELETE FROM `user_is_part_of_eventorganisation` WHERE User_id = ? AND Organisation_id = ?";
		
        $statement = $db->prepare($query);
		
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("ii", $userId, $organisationId);
		
		$success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Check if a user is a part of an event organisation.
	static function check_userPartOfOrganisation($userId, $organisationId) {
		global $db;
		
		$userId = $db->escape_string($userId);
		$organisationId = $db->escape_string($organisationId);
		
		$query = "SELECT User_id, Organisation_id FROM `user_is_part_of_eventorganisation` WHERE User_id = ? AND Organisation_id = ?";
		
		$statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
		$statement->bind_param("ii", $userId, $organisationId);
		
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
	
	
	// Returns a lis of all users mapped to the organisation in the database.
    static function get_members($organisationId) {
        global $db;
		
		$organisationId = $db->escape_string($organisationId);
        
        $query = "SELECT User_id FROM `user_is_part_of_eventorganisation` WHERE Organisation_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
		
        $statement->bind_param("i", $organisationId);
		
		$statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $organisationMemberIds = array();
        
        while ($row = $result->fetch_assoc()) {
            $organisationMemberIds[] = $row['User_id'];
        }
        
        $statement->close();
        
        return $organisationMemberIds;
	}
	
    
    // Returns the event organisations associated with a user ID.
    static function get_eventOrganisationsByUser($userId) {
        global $db;
        
        $userId = $db->escape_string($userId);
        
        $query = "SELECT * FROM `user_is_part_of_eventorganisation`,`eventorganisation` WHERE user_is_part_of_eventorganisation.Organisation_id = eventorganisation.Organisation_id AND user_is_part_of_eventorganisation.User_id = ?";
        
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
        
        $eventOrganisations = array();
        
        while ($row = $result->fetch_assoc()) {
            $eventOrganisations[] = array($row['Organisation_id'], $row['Name']);
        }
        
        $statement->close();
        
        return $eventOrganisations;
    }
    
    
    // Returns an array of all events the organisation is or has been hosting.
    static function get_events($organisationId) {
        global $db;
        
        $organisationId = $db->escape_string($organisationId);
        
        $query = "SELECT * FROM `event` WHERE Organisation_id = ?";
        
        $statement = $db->prepare($query);
        
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
        $statement->bind_param("i", $organisationId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
            $events[] = array($row['Event_id'], $row['Name']);
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	// Returns an array of all upcoming events the organisation is hosting.
    static function get_upcomingEvents($organisationId) {
        global $db;
        
        $organisationId = $db->escape_string($organisationId);
        
        $query = "SELECT * FROM `event` WHERE Organisation_id = ? AND Cancelled = 0";
        
        $statement = $db->prepare($query);
        
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
        $statement->bind_param("i", $organisationId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
			// Set the timezone & get the current time.
			date_default_timezone_set("Europe/Brussels");
			$now = time();
			// Store the event end in a timestamp.
			$end = strtotime(date("Y-m-d H:i:s", strtotime("$row[End] + 2 hours")));
			if ($now < $end) { // If the event is not over yet.
				$events[] = $row;
			}
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	// Returns an array of all passed events the organisation is hosting.
    static function get_passedEvents($organisationId) {
        global $db;
        
        $organisationId = $db->escape_string($organisationId);
        
        $query = "SELECT * FROM `event` WHERE Organisation_id = ? AND Cancelled = 0";
        
        $statement = $db->prepare($query);
        
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
        $statement->bind_param("i", $organisationId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
			// Set the timezone & get the current time.
			date_default_timezone_set("Europe/Brussels");
			$now = time();
			// Store the event end in a timestamp.
			$end = strtotime(date("Y-m-d H:i:s", strtotime("$row[End]")));
			if ($now > $end) { // If the event is not over yet.
				$events[] = $row;
			}
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	// Returns a lis of all names of event organisations in the database.
    static function get_eventOrganisationNames() {
        global $db;
        
        $query = "SELECT Name FROM `eventorganisation`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $organisations = array();
        
        while ($row = $result->fetch_assoc()) {
            $organisations[] = $row['Name'];
        }
        
        $statement->close();
        
        return $organisations;
	}
	
	
	/* Returns a list of all the event organisation ID's, names and logo urls in the database. */
	static function get_allOrganisationInfo() {
        global $db;
        
        $query = "SELECT Organisation_id, Name FROM `eventorganisation`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $organisations = array();
        
        while ($row = $result->fetch_assoc()) {
            $organisations[] = array("organisationId"=>$row['Organisation_id'], "name"=>$row['Name']);
        }
        
        $statement->close();
        
        return $organisations;
	}
}

?>