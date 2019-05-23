<?php
/* This file contains the code for the skill object and queries. */

class skill {
    
    private $id;
    private $name;
    private $type;
    private $level;
    private $description;
    private $timeAdded;
        
    function __construct($id, $name, $type, $level, $description, $timeAdded) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->level = $level;
        $this->description = $description;
        $this->timeAdded = $timeAdded;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getType() {
        return $this->type;
    }
    public function getLevel() {
        return $this->level;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getTimeAdded() {
        return $this->timeAdded;
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
    public function setType($type) {
        if (is_string($type)) {
            $this->type = $type;
        }
    }
    public function setLevel($level) {
        if (is_string($level)) {
            $this->level = $level;
        }
    }
    public function setDescription($description) {
        if (is_string($description)) {
            $this->description = $description;
        }
    }
    public function setTimeAdded($timeAdded) {
        if (is_string($timeAdded)) {
            $this->timeAdded = $timeAdded;
        }
    }
    
    
    // Save all changes made to the skill info to the database.
    public function save() {
        /* Check if the skill already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `skill` (Name, Type, Level, Description) VALUES (?, ?, ?, ?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("ssss", $this->name, $this->type, $this->level, $this->description);
            
            $success = $statement->execute();
            
            if ($success) {
                $skillId = $db->insert_id;
                $statement->close();
                return $skillId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `skill` SET Name = ?, Type = ?, Level = ?, Description = ? WHERE Skill_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("ssssi", $this->name, $this->type, $this->level, $this->description, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete skill record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `skill` WHERE Skill_id = ?";
        
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
    
    
    /* Create a skill object and store all information of the record with the given Skill_id in it. */
    static function get_skillById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `skill` WHERE Skill_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $name, $type, $level, $description, $timeAdded);
        
        $statement->fetch();
        
        $skill = new skill($id, $name, $type, $level, $description, $timeAdded);
        
        $statement->close();
        
        return $skill;
    }
	
	
	/* Create a skill array and store all information of the record with the given Skill_id in it. */
    static function get_skillArrayById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `skill` WHERE Skill_id = ?";
		
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
            $skill = $row;
        }
        
        $statement->close();
        
		if (isset($skill)) {
			return $skill;
		}
    }
    
    
    // Returns the ID of a skill, based on the name.
    static function get_skillByName($skillName) {
        global $db;
        
        $skillName = $db->escape_string($skillName);
        
        $query = "SELECT * FROM `skill` WHERE Name = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("s", $skillName);
        
        $statement->execute();
        
        $statement->bind_result($id, $name, $type, $level, $description, $timeAdded);
        
        $statement->fetch();
        
        $skill = new skill($id, $name, $type, $level, $description, $timeAdded);
        
        $statement->close();
        
        return $skill;
    }
    
    
    // Returns a list of all skills of a certain type.
    static function get_skillsByType($type) {
        global $db;
        
        $type = $db->escape_string($type);

        $query = "SELECT Name FROM `skill` WHERE Type = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("s", $type);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $skillNames = array();
        
        while ($row = $result->fetch_assoc()) {
            $skillNames[] = $row['Name'];
        }
        
        $statement->close();
        
        return $skillNames;
    }
    
    
    // Returns a list of all skill names in the database.
    static function get_skillNames() {
        global $db;
        
        $query = "SELECT Name FROM `skill`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $skillNames = array();
        
        while ($row = $result->fetch_assoc()) {
            $skillNames[] = $row['Name'];
        }
        
        $statement->close();
        
        return $skillNames;
    }
    
    
    // Returns all the skill information from the database.
    static function get_allSkillsInfo() {
        global $db;
        
        $query = "SELECT * FROM `skill` ORDER BY Name";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $skills = array();
        
        while ($row = $result->fetch_assoc()) {
            $skills[] = array($row['Skill_id'], $row['Name'], $row['Type'], $row['Description']);
        }
        
        $statement->close();
        
        return $skills;
    }
}

?>