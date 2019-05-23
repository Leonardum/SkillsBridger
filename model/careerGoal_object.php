<?php
/* This file contains the code for the career goal object and queries. */

class careerGoal {
    
	private $id;
	private $name;
	private $level;
	private $parentCareerGoal;
	private $timeAdded;
	
	function __construct($id, $name, $level, $parentCareerGoal, $timeAdded) {
		$this->id = $id;
		$this->name = $name;
		$this->level = $level;
		$this->parentCareerGoal = $parentCareerGoal;
		$this->timeAdded = $timeAdded;
	}
	
    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }
    public function getLevel() {
        return $this->level;
    }
    public function getParentCareerGoal() {
        return $this->parentCareerGoal;
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
    public function setLevel($level) {
        if (is_int($level)) {
            $this->level = $level;
        }
    }
    public function setParentCareerGoal($parentCareerGoal) {
        if (is_string($parentCareerGoal)) {
            $this->parentCareerGoal = $parentCareerGoal;
        }
    }
    public function setTimeAdded($timeAdded) {
        if (is_string($timeAdded)) {
            $this->timeAdded = $timeAdded;
        }
    }
    
    
    // Save all changes made to the career goal info to the database.
    public function save() {
        /* Check if the career goal already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `careergoal` (Name, Level, Parent) VALUES (?, ?, ?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("sis", $this->name, $this->level, $this->parentCareerGoal);
            
            $success = $statement->execute();
            
            if ($success) {
                $careerGoalId = $db->insert_id;
                $statement->close();
                return $careerGoalId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `careergoal` SET Name = ?, Level = ?, Parent = ? WHERE CareerGoal_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("sisi", $this->name, $this->level, $this->parentCareerGoal, $this->id);
            
            $success = $statement->execute();
            
            if ($success) {
                $statement->close();
            } else {
                display_db_error($db->error);
            }
        }
    }
    
    
    // Delete the complete career goal record from the database.
    public function delete() {
        global $db;
        
        $query = "DELETE FROM `careergoal` WHERE CareerGoal_id = ?";
        
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
    
    
    /* Create a career goal object and store all information of the record with the given CareerGoal_id in it. */
    static function get_careerGoalById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `careergoal` WHERE CareerGoal_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $name, $level, $parentCareerGoal, $timeAdded);
        
        $statement->fetch();
        
        $careerGoal = new careerGoal($id, $name, $level, $parentCareerGoal, $timeAdded);
        
        $statement->close();
        
        return $careerGoal;
    }
    
    
    // Returns a list of all career goal names in the database.
    static function get_careerGoals() {
        global $db;
        
        $query = "SELECT Name FROM `careergoal`";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $careerGoalNames = array();

        while ($row = $result->fetch_assoc()) {
            $careerGoalNames[] = $row['Name'];
        }
        
        $statement->close();
        
        return $careerGoalNames;
    }
    
    
    /* Returns a 2-dimensional array of all career goal names in the database with the second dimension being the arrays of the level 1 career goals with all their children:
    
    $careerGoals = array(
        array("Parent 1","Child1","Child2", "Child3"),
        array("Parent 2","Child1","Child2", "Child3", "Child4"),
        array("Parent 3","Child1","Child2")
    ); */
    static function get_careerGoalArray() {
        global $db;
        
        $query = "SELECT CareerGoal_id, Name, Level, Parent FROM `careergoal` ORDER BY Level, Name";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $careerGoals = array();
        
        while ($row = $result->fetch_assoc()) {
            if ($row['Level'] == 1) {
                $careerGoals[] = array($row['Name'], $row['CareerGoal_id']);
            } else if ($row['Level'] == 2) {
                for ($x=0; $x < count($careerGoals); $x++) {
                    if ($row['Parent'] == $careerGoals[$x][0]) {
                        array_push($careerGoals[$x], array($row['Name'], $row['CareerGoal_id']));
                    }
                }
            }
        }
        
        $statement->close();
        
        return $careerGoals;
    }
    
    
    /* Returns a list of all career goal names of a certain level. The level is the required parameter for this function. */
    static function get_careerGoalsByLevel($level) {
        global $db;
        
        $level = $db->escape_string($level);
        
        $query = "SELECT Name FROM `careergoal` WHERE Level = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $level);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $careerGoals = array();
        
        while ($row = $result->fetch_assoc()) {
            $careerGoals[] = $row['Name'];
        }
        
        $statement->close();
        
        return $careerGoals;
    }
    
    
    /* Returns a list of all career goal names which share the same parent. */
    static function get_childCareerGoals($parent) {
        global $db;
        
        $parent = $db->escape_string($parent);
        
        $query = "SELECT CareerGoal_id, Name FROM `careergoal` WHERE Parent = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("s", $parent);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $careerGoals = array();
        
        while ($row = $result->fetch_assoc()) {
            $careerGoals[] = array($row['CareerGoal_id'], $row['Name']);
        }
        
        $statement->close();
        
        return $careerGoals;
    }
    
    
    /* This function adds a career goal and a skill together to the relationship table, thus linking them both. */
    static function add_skillToCareerGoal($skillId, $careerGoalId) {
        global $db;
        
        $skillId = $db->escape_string($skillId);
        $careerGoalId = $db->escape_string($careerGoalId);
        
        $query = "INSERT INTO `skill_required_for_careergoal` (Skill_id, CareerGoal_id) VALUES (?, ?)";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("ii", $skillId, $careerGoalId);
        
        $success = $statement->execute();
        
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
    
    
    /* This function retrieves all the skills needed for a certain career goal. */
    static function get_skillOfCareerGoal($careerGoalId) {
        global $db;
        
        $careerGoalId = $db->escape_string($careerGoalId);
        
        $query = "SELECT skill_required_for_careergoal.Skill_id, skill.Name, skill.Type, skill.Description FROM `skill_required_for_careergoal`, `skill` WHERE skill_required_for_careergoal.Skill_id = skill.Skill_id AND CareerGoal_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $careerGoalId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $skills = array();
        
        while ($row = $result->fetch_assoc()) {
            $skills[] = array ($row['Skill_id'], $row['Name'], $row['Type'], $row['Description']);
        }
        
        $statement->close();
        
        return $skills;
    }
    
    
    /* This function sets the database to ignore foreign key constraints when inserting data in the database. It can be helpful to determine why certain errors occur. */
    static function set_noForeignKeyChecks() {
        global $db;
        
        $query = "SET FOREIGN_KEY_CHECKS=0";

        $statement = $db->prepare($query);

        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $success = $statement->execute();

        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
    
    
    /* This function resets the database to alert foreign key constraints when inserting data in the database. Used to negate the effects of the previous function. */
    static function reset_foreignKeyChecks() {
        global $db;
        
        $query = "SET FOREIGN_KEY_CHECKS=1";

        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $success = $statement->execute();

        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
}

?>