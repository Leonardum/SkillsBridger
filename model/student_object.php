<?php
/* This file contains the code for the student object and queries. */

class student {
    
    private $id;
    private $userId;
    private $studyId;
    private $universityId;
    private $currentYear;
    private $graduationMonth;
    private $graduationYear;
    private $internshipInterest;
    private $halfTimeInterest;
    private $fullTimeInterest;
	private $termsOfUseAcceptIp;
    
    function __construct($id, $userId, $studyId, $universityId, $currentYear, $graduationMonth, $graduationYear, $internshipInterest, $halfTimeInterest, $fullTimeInterest, $termsOfUseAcceptIp) {
        $this->id = $id;
        $this->userId = $userId;
        $this->studyId = $studyId;
        $this->universityId = $universityId;
        $this->currentYear = $currentYear;
        $this->graduationMonth = $graduationMonth;
        $this->graduationYear = $graduationYear;
        $this->internshipInterest = $internshipInterest;
        $this->halfTimeInterest = $halfTimeInterest;
        $this->fullTimeInterest = $fullTimeInterest;
        $this->termsOfUseAcceptIp = $termsOfUseAcceptIp;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getStudyId() {
        return $this->studyId;
    }
    public function getUniversityId() {
        return $this->universityId;
    }
    public function getCurrentYear() {
        return $this->currentYear;
    }
    public function getGraduationMonth() {
        return $this->graduationMonth;
    }
    public function getGraduationYear() {
        return $this->graduationYear;
    }
    public function getInternshipInterest() {
        return $this->internshipInterest;
    }
    public function getHalfTimeInterest() {
        return $this->halfTimeInterest;
    }
    public function getFullTimeInterest() {
        return $this->fullTimeInterest;
    }
    public function getTermsOfUseAcceptIp() {
        return $this->termsOfUseAcceptIp;
    }
    
    public function setId($id) {
        if (is_int($id)) {
            $this->id = $id;
        }
    }
    public function setUserId($userId) {
        if (is_int($userId)) {
            $this->userId = $userId;
        }
    }
    public function setStudyId($studyId) {
        if (is_int($studyId)) {
            $this->studyId = $studyId;
        }
    }
    public function setUniversityId($universityId) {
        if (is_int($universityId)) {
            $this->universityId = $universityId;
        }
    }
    public function setCurrentYear($currentYear) {
        if (is_string($currentYear)) {
            $this->currentYear = $currentYear;
        }
    }
    public function setGraduationMonth($graduationMonth) {
        if (is_int($graduationMonth)) {
            $this->graduationMonth = $graduationMonth;
        }
    }
    public function setGraduationYear($graduationYear) {
        if (is_int($graduationYear)) {
            $this->graduationYear = $graduationYear;
        }
    }
    public function setInternshipInterest($internshipInterest) {
        if (is_int($internshipInterest)) {
            $this->internshipInterest = $internshipInterest;
        }
    }
    public function setHalfTimeInterest($halfTimeInterest) {
        if (is_int($halfTimeInterest)) {
            $this->halfTimeInterest = $halfTimeInterest;
        }
    }
    public function setFullTimeInterest($fullTimeInterest) {
        if (is_int($fullTimeInterest)) {
            $this->fullTimeInterest = $fullTimeInterest;
        }
    }
	public function setTermsOfUseAcceptIp($termsOfUseAcceptIp) {
        if (is_string($termsOfUseAcceptIp)) {
            $this->termsOfUseAcceptIp = $termsOfUseAcceptIp;
        }
    }
    
    
    // Save all changes made to the student info to the database.
    public function save() {
        /* Check if the student already exists in database. If it doesn't create a new record. If it does, update the current record. */
        if (!isset($this->id)) {
            global $db;
            
            $query = "INSERT INTO `student` (User_id, Study_id, University_id, CurrentYear, ExpectedGraduationMonth, ExpectedGraduationYear, InternshipInterest, HalfTimeInterest, FullTimeInterest, TermsOfUseAcceptIp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("iiisiiiiis", $this->userId, $this->studyId, $this->universityId, $this->currentYear, $this->graduationMonth, $this->graduationYear, $this->internshipInterest, $this->halfTimeInterest, $this->fullTimeInterest, $this->termsOfUseAcceptIp);
            
            $success = $statement->execute();
            
            if ($success) {
                $studentId = $db->insert_id;
                $statement->close();
                return $studentId;
            } else {
                display_db_error($db->error);
            }
        } else {
            global $db;
            
            $query = "UPDATE `student` SET User_id = ?, Study_id = ?, University_id = ?, CurrentYear = ?, ExpectedGraduationMonth = ?, ExpectedGraduationYear = ?, InternshipInterest = ?, HalfTimeInterest = ?, FullTimeInterest = ?, TermsOfUseAcceptIp = ? WHERE Student_id = ?";
            
            $statement = $db->prepare($query);
            
            if ($statement == FALSE) {
                display_db_error($db->error);
            }
            
            $statement->bind_param("iiisiiiiisi", $this->userId, $this->studyId, $this->universityId, $this->currentYear, $this->graduationMonth, $this->graduationYear, $this->internshipInterest, $this->halfTimeInterest, $this->fullTimeInterest, $this->termsOfUseAcceptIp, $this->id);
            
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
        
        $query = "DELETE FROM `student` WHERE Student_id = ?";
        
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
    
    
    /* Create a student object and store all information of the record with the given Student_id in it. */
    static function get_studentById($id) {
        global $db;
        
        $id = $db->escape_string($id);
        
        $query = "SELECT * FROM `student` WHERE Student_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $id);
        
        $statement->execute();
        
        $statement->bind_result($id, $userId, $studyId, $universityId, $currentYear, $graduationMonth, $graduationYear, $internshipInterest, $halfTimeInterest, $fullTimeInterest, $termsOfUseAcceptIp);
        
        $statement->fetch();
        
        $student = new student($id, $userId, $studyId, $universityId, $currentYear, $graduationMonth, $graduationYear, $internshipInterest, $halfTimeInterest, $fullTimeInterest, $termsOfUseAcceptIp);
        
        $statement->close();
        
        return $student;
    }
    
    
    // Returns the student ID of a user.
    static function get_studentByUser($userId) {
        global $db;
        
        $userId = $db->escape_string($userId);
        
        $query = "SELECT * FROM `student` WHERE User_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $userId);
        
        $statement->execute();
        
        $statement->bind_result($id, $userId, $study, $university, $currentYear, $graduationMonth, $graduationYear, $internshipInterest, $halfTimeInterest, $fullTimeInterest, $termsOfUseAcceptIp);
        
        $statement->fetch();
        
        $student = new student($id, $userId, $study, $university, $currentYear, $graduationMonth, $graduationYear, $internshipInterest, $halfTimeInterest, $fullTimeInterest, $termsOfUseAcceptIp);
        
        $statement->close();
        
        if (isset($student)) {
            return $student;
        }
    }
    
    
    // Returns the list of all ID's of events a student has subscribed for.
    static function get_studentEvents($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "SELECT Event_id FROM `student_going_to_event` WHERE Student_id = ?";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $studentId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
            $events[] = $row['Event_id'];
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	/* Returns the list of all ID's of events a student has applied for but has not been approved for. */
    static function get_appliedEvents($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "SELECT Event_id FROM `student_going_to_event` WHERE Student_id = ? AND Approved = 0";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $studentId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
            $events[] = $row['Event_id'];
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	/* Returns the list of all ID's of events a student has applied for but has not been approved for which are still going to take place. */
    static function get_upcomingAppliedEvents($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "SELECT event.End, event.Cancelled, student_going_to_event.* FROM `event`, `student_going_to_event` WHERE event.Event_id = student_going_to_event.Event_id AND student_going_to_event.Student_id = ? AND student_going_to_event.Approved = 0 AND event.Cancelled = 0";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $studentId);
        
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
			if ($now < $end) { // If the event is not over yet.
				$events[] = $row['Event_id'];
			}
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	// Returns the list of all ID's of events a student has been approved for.
    static function get_approvedEvents($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "SELECT Event_id FROM `student_going_to_event` WHERE Student_id = ? AND Approved = 1";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $studentId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
            $events[] = $row['Event_id'];
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	/* Returns the list of all ID's of events a student has subscribed and been approved which are still going to take place. */
    static function get_upcomingSubscribedEvents($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "SELECT event.End, event.Cancelled, student_going_to_event.* FROM `event`, `student_going_to_event` WHERE event.Event_id = student_going_to_event.Event_id AND student_going_to_event.Student_id = ? AND student_going_to_event.Approved = 1 AND student_going_to_event.CheckedIn = 0 AND event.Cancelled = 0";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $studentId);
        
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
			if ($now < $end) { // If the event is not over yet.
				$events[] = $row['Event_id'];
			}
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	/* Returns the list of all ID's of events a student has subscribed OR applied for and which are still going to take place. */
    static function get_allUpcomingStudentEvents($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "SELECT event.End, event.Cancelled, student_going_to_event.* FROM `event`, `student_going_to_event` WHERE event.Event_id = student_going_to_event.Event_id AND student_going_to_event.Student_id = ? AND student_going_to_event.CheckedIn = 0 AND event.Cancelled = 0";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $studentId);
        
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
			if ($now < $end) { // If the event is not over yet.
				$events[] = $row['Event_id'];
			}
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	// Returns the list of all ID's of events a student has been to.
    static function get_attendedEvents($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "SELECT Event_id FROM `student_going_to_event` WHERE Student_id = ? AND Approved = 1 AND CheckedIn = 1";
        
        $statement = $db->prepare($query);
		
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
        
        $statement->bind_param("i", $studentId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $events = array();
        
        while ($row = $result->fetch_assoc()) {
            $events[] = $row['Event_id'];
        }
        
        $statement->close();
        
        return $events;
    }
	
	
	/* This function adds a student and a career goal together to the relationship table, thus linking them both. */
    static function add_studentToCareerGoal($studentId, $careerGoalId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        $careerGoalId = $db->escape_string($careerGoalId);
        
        $query = "INSERT INTO `student_interested_in_careergoal` (Student_id, CareerGoal_id) VALUES (?, ?)";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("ii", $studentId, $careerGoalId);
        
        $success = $statement->execute();
        
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Returns the list of all ID's of career goals a student is interested in.
    static function get_studentCareerGoals($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "SELECT CareerGoal_id FROM `student_interested_in_careergoal` WHERE Student_id = ?";
        
        $statement = $db->prepare($query);
        
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
        $statement->bind_param("i", $studentId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $careerGoals = array();
        
        while ($row = $result->fetch_assoc()) {
            $careerGoals[] = $row['CareerGoal_id'];
        }
        
        $statement->close();
        
        return $careerGoals;
    }
	
	
	// Remove the career goals a student is interested in.
	static function delete_studentCareerGoals($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "DELETE FROM `student_interested_in_careergoal` WHERE Student_id = ?";
		
		$statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("i", $studentId);
        
        $success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
	
	
	/* This function adds a student and a career event type together to the relationship table, thus linking them both. */
    static function add_studentToCareerEventType($studentId, $careerEventTypeId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        $careerEventTypeId = $db->escape_string($careerEventTypeId);
        
        $query = "INSERT INTO `student_interested_in_careerevent` (Student_id, Careerevent_id) VALUES (?, ?)";
        
        $statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("ii", $studentId, $careerEventTypeId);
        
        $success = $statement->execute();
        
        if ($success) {
            $statement->close();
        } else {
            display_db_error($db->error);
        }
    }
	
	
	// Returns the list of all ID's of career event types a student is interested in.
    static function get_studentCareerEventTypes($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "SELECT Careerevent_id FROM `student_interested_in_careerevent` WHERE Student_id = ?";
        
        $statement = $db->prepare($query);
        
		if ($statement == FALSE) {
			display_db_error($db->error);
		}
		
        $statement->bind_param("i", $studentId);
        
        $statement->execute();
        
        $result = $statement->get_result();
        
        if ($result == FALSE) {
            display_db_error($db->error);
        }
        
        $careerEventTypes = array();
        
        while ($row = $result->fetch_assoc()) {
            $careerEventTypes[] = $row['Careerevent_id'];
        }
        
        $statement->close();
        
        return $careerEventTypes;
    }
	
	
	// Remove the career event types a student is interested in.
	static function delete_studentCareerEventTypes($studentId) {
        global $db;
        
        $studentId = $db->escape_string($studentId);
        
        $query = "DELETE FROM `student_interested_in_careerevent` WHERE Student_id = ?";
		
		$statement = $db->prepare($query);
        
        if ($statement == FALSE) {
            display_db_error($db->error);
        }
        
        $statement->bind_param("i", $studentId);
        
        $success = $statement->execute();
        
        if ($success) {
            $count = $db->affected_rows;
            $statement->close();
            return $count;
        } else {
            display_db_error($db->error);
        }
    }
}

?>